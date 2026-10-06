<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'images'])
            ->where('status', '!=', 'sold_out'); // Prioritize available / reserved / coming soon

        // Search query
        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('color_pattern', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category & Betta Type filters (with graceful cross-matching)
        if ($request->filled('category') && $request->filled('type')) {
            $categorySlug = $request->category;
            $type = $request->type;

            $hasExactMatch = Product::where('status', '!=', 'sold_out')
                ->whereHas('category', fn ($q) => $q->where('slug', $categorySlug))
                ->where(function ($q) use ($type) {
                    $q->where('betta_type', $type)
                        ->orWhere('betta_type', str_replace('-', '_', $type));
                })
                ->exists();

            if ($hasExactMatch) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug))
                    ->where(function ($q) use ($type) {
                        $q->where('betta_type', $type)
                            ->orWhere('betta_type', str_replace('-', '_', $type));
                    });
            } else {
                // When conflicting (e.g. Crowntail category + Plakat type), show matching specimens from either
                $query->where(function ($q) use ($categorySlug, $type) {
                    $q->whereHas('category', fn ($cq) => $cq->where('slug', $categorySlug))
                        ->orWhere('betta_type', $type)
                        ->orWhere('betta_type', str_replace('-', '_', $type));
                });
            }
        } elseif ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        } elseif ($request->filled('type')) {
            $type = $request->type;
            $query->where(function ($q) use ($type) {
                $q->where('betta_type', $type)
                    ->orWhere('betta_type', str_replace('-', '_', $type))
                    ->orWhereHas('category', function ($cq) use ($type) {
                        $cq->where('slug', $type)
                            ->orWhere('slug', str_replace('_', '-', $type));
                    });
            });
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Care Level filter
        if ($request->filled('care_level')) {
            $query->where('care_level', $request->care_level);
        }

        // Price range (with digit sanitization)
        if ($request->filled('min_price')) {
            $minPrice = (float) preg_replace('/[^0-9]/', '', (string) $request->min_price);
            if ($minPrice > 0) {
                $query->where(function ($q) use ($minPrice) {
                    $q->whereRaw('COALESCE(NULLIF(discount_price, 0), price) >= ?', [$minPrice]);
                });
            }
        }
        if ($request->filled('max_price')) {
            $maxPrice = (float) preg_replace('/[^0-9]/', '', (string) $request->max_price);
            if ($maxPrice > 0) {
                $query->where(function ($q) use ($maxPrice) {
                    $q->whereRaw('COALESCE(NULLIF(discount_price, 0), price) <= ?', [$maxPrice]);
                });
            }
        }

        // Sorting (support terkait, terbaru, terlaris, harga_terendah, harga_tertinggi)
        $sort = $request->get('sort', 'terkait');
        switch ($sort) {
            case 'price_low':
            case 'harga_terendah':
                $query->orderByRaw('COALESCE(NULLIF(discount_price, 0), price) ASC');
                break;
            case 'price_high':
            case 'harga_tertinggi':
                $query->orderByRaw('COALESCE(NULLIF(discount_price, 0), price) DESC');
                break;
            case 'popular':
            case 'terlaris':
                $query->orderByDesc('views_count')->orderByDesc('id');
                break;
            case 'latest':
            case 'terbaru':
                $query->latest('id');
                break;
            case 'terkait':
            default:
                $query->orderByDesc('is_featured')->latest('id');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->orderBy('sort_order')->get();

        return view('frontend.catalog', compact('products', 'categories'));
    }

    public function show(string $slug): View
    {
        $product = Product::with(['category', 'images', 'reviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views count
        $product->increment('views_count');

        // Related specimens
        $relatedProducts = Product::with(['category', 'images'])
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('category_id', $product->category_id)
                    ->orWhere('betta_type', $product->betta_type);
            })
            ->where('status', 'available')
            ->take(4)
            ->get();

        return view('frontend.product-detail', compact('product', 'relatedProducts'));
    }
}
