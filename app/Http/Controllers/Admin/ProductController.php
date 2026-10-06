<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'images']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('color_pattern', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('betta_type')) {
            $query->where('betta_type', $request->betta_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|lt:price|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,sold_out,reserved,coming_soon',
            'gender' => 'required|in:male,female,pair,unsexed',
            'betta_type' => 'required|string',
            'color_pattern' => 'nullable|string|max:255',
            'size_cm' => 'nullable|numeric|min:0|max:20',
            'age_months' => 'nullable|numeric|min:0|max:36',
            'care_level' => 'required|in:beginner,intermediate,advanced',
            'description' => 'nullable|string',
            'care_guide' => 'nullable|string',
            'is_featured' => 'boolean',
            'image_file' => 'nullable|image|max:3072',
            'image_url' => 'nullable|url',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug.'-'.$count++;
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        // Extract image fields
        $imageFile = $request->file('image_file');
        $imageUrl = $validated['image_url'] ?? null;
        unset($validated['image_file'], $validated['image_url']);

        $product = Product::create($validated);

        if ($imageFile) {
            $path = $imageFile->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => '/storage/'.$path,
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        } elseif ($imageUrl) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => $imageUrl,
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Spesimen ikan cupang berhasil ditambahkan!');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku,'.$product->id,
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|lt:price|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,sold_out,reserved,coming_soon',
            'gender' => 'required|in:male,female,pair,unsexed',
            'betta_type' => 'required|string',
            'color_pattern' => 'nullable|string|max:255',
            'size_cm' => 'nullable|numeric|min:0|max:20',
            'age_months' => 'nullable|numeric|min:0|max:36',
            'care_level' => 'required|in:beginner,intermediate,advanced',
            'description' => 'nullable|string',
            'care_guide' => 'nullable|string',
            'is_featured' => 'boolean',
            'image_file' => 'nullable|image|max:3072',
            'image_url' => 'nullable|url',
        ]);

        if ($product->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $count = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug.'-'.$count++;
            }
            $validated['slug'] = $slug;
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        $imageFile = $request->file('image_file');
        $imageUrl = $validated['image_url'] ?? null;
        unset($validated['image_file'], $validated['image_url']);

        $product->update($validated);

        if ($imageFile) {
            $path = $imageFile->store('products', 'public');
            // Remove previous primary or add new
            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => '/storage/'.$path,
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        } elseif ($imageUrl) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => $imageUrl,
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Data spesimen cupang berhasil diperbarui!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Spesimen ikan cupang berhasil dihapus!');
    }

    public function duplicate(Product $product): RedirectResponse
    {
        $newProduct = $product->replicate();
        $newProduct->name = $product->name.' (Salinan)';
        $newProduct->sku = $product->sku.'-COPY-'.strtoupper(Str::random(3));
        $newProduct->slug = Str::slug($newProduct->name).'-'.strtolower(Str::random(4));
        $newProduct->save();

        foreach ($product->images as $img) {
            $newImg = $img->replicate();
            $newImg->product_id = $newProduct->id;
            $newImg->save();
        }

        return redirect()->route('admin.products.index')->with('success', 'Spesimen cupang berhasil diduplikasi!');
    }
}
