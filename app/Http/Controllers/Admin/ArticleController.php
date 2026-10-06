<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::with(['category', 'author']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $articles = $query->latest()->paginate(10)->withQueryString();

        return view('admin.articles.index', compact('articles'));
    }

    public function create(): View
    {
        $categories = ArticleCategory::all();
        $products = Product::where('status', 'available')->orderBy('name')->get();

        return view('admin.articles.create', compact('categories', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:article_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'reading_time_minutes' => 'required|integer|min:1',
            'status' => 'required|in:draft,published,archived',
            'image_file' => 'nullable|image|max:3072',
            'related_products' => 'nullable|array',
            'related_products.*' => 'exists:products,id',
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Article::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug.'-'.$count++;
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('articles', 'public');
            $validated['featured_image'] = '/storage/'.$path;
        }

        $relatedProductIds = $validated['related_products'] ?? [];
        unset($validated['image_file'], $validated['related_products']);

        $article = Article::create($validated);

        if (! empty($relatedProductIds)) {
            $syncData = [];
            foreach ($relatedProductIds as $idx => $pId) {
                $syncData[$pId] = ['sort_order' => $idx + 1];
            }
            $article->relatedProducts()->sync($syncData);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel panduan cupang berhasil diterbitkan!');
    }

    public function edit(Article $article): View
    {
        $categories = ArticleCategory::all();
        $products = Product::where('status', 'available')->orderBy('name')->get();
        $article->load('relatedProducts');

        return view('admin.articles.edit', compact('article', 'categories', 'products'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:article_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'reading_time_minutes' => 'required|integer|min:1',
            'status' => 'required|in:draft,published,archived',
            'image_file' => 'nullable|image|max:3072',
            'related_products' => 'nullable|array',
            'related_products.*' => 'exists:products,id',
        ]);

        if ($article->title !== $validated['title']) {
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $count = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = $originalSlug.'-'.$count++;
            }
            $validated['slug'] = $slug;
        }

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('articles', 'public');
            $validated['featured_image'] = '/storage/'.$path;
        }

        $relatedProductIds = $validated['related_products'] ?? [];
        unset($validated['image_file'], $validated['related_products']);

        $article->update($validated);

        $syncData = [];
        foreach ($relatedProductIds as $idx => $pId) {
            $syncData[$pId] = ['sort_order' => $idx + 1];
        }
        $article->relatedProducts()->sync($syncData);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel panduan cupang berhasil diperbarui!');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
