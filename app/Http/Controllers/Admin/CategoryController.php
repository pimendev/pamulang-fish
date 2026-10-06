<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'required|integer',
            'is_active' => 'nullable|boolean',
            'image_file' => 'nullable|image|max:3072',
            'image_url' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        // Check unique slug
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Category::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug.'-'.$count++;
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('categories', 'public');
            $validated['image'] = '/storage/'.$path;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        unset($validated['image_file'], $validated['image_url']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori varietas cupang berhasil ditambahkan!');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'required|integer',
            'is_active' => 'nullable|boolean',
            'image_file' => 'nullable|image|max:3072',
            'image_url' => 'nullable|string|max:500',
        ]);

        if ($category->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $count = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug.'-'.$count++;
            }
            $validated['slug'] = $slug;
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image_file')) {
            // Delete old storage image if exists
            if ($category->image && Str::startsWith($category->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $category->image));
            }
            $path = $request->file('image_file')->store('categories', 'public');
            $validated['image'] = '/storage/'.$path;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        unset($validated['image_file'], $validated['image_url']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori varietas cupang berhasil diperbarui!');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk ikan cupang.');
        }

        if ($category->image && Str::startsWith($category->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $category->image));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
