<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::with(['category', 'author'])
            ->where('status', 'published');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $articles = $query->latest('published_at')->paginate(6)->withQueryString();
        $categories = ArticleCategory::withCount('articles')->get();

        return view('frontend.articles.index', compact('articles', 'categories'));
    }

    public function show(string $slug): View
    {
        $article = Article::with(['category', 'author', 'relatedProducts.category', 'relatedProducts.images'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $article->increment('views_count');

        $latestArticles = Article::where('id', '!=', $article->id)
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.articles.show', compact('article', 'latestArticles'));
    }
}
