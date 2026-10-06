<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        if (auth()->check()) {
            $wishlists = Wishlist::with('product.category', 'product.images')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
            $products = $wishlists->map(fn ($w) => $w->product)->filter();
        } else {
            $productIds = session()->get('wishlist', []);
            $products = Product::with(['category', 'images'])
                ->whereIn('id', $productIds)
                ->get();
        }

        return view('frontend.wishlist', compact('products'));
    }

    public function toggle(Product $product): RedirectResponse
    {
        if (auth()->check()) {
            $existing = Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->first();

            if ($existing) {
                $existing->delete();
                $message = "Spesimen {$product->name} dihapus dari wishlist.";
            } else {
                Wishlist::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                ]);
                $message = "Spesimen {$product->name} berhasil ditambahkan ke wishlist!";
            }
        } else {
            $wishlist = session()->get('wishlist', []);
            if (in_array($product->id, $wishlist)) {
                $wishlist = array_values(array_diff($wishlist, [$product->id]));
                $message = "Spesimen {$product->name} dihapus dari wishlist.";
            } else {
                $wishlist[] = $product->id;
                $message = "Spesimen {$product->name} berhasil ditambahkan ke wishlist!";
            }
            session()->put('wishlist', $wishlist);
        }

        return back()->with('success', $message);
    }
}
