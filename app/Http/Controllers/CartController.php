<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session()->get('cart', []);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Live fish special oxygen & styrofoam packing cost
        $packingCost = ! empty($cart) ? 25000 : 0;
        $total = $subtotal + $packingCost;

        return view('frontend.cart', compact('cart', 'subtotal', 'packingCost', 'total'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        if ($product->status === 'sold_out' || $product->stock <= 0) {
            return back()->with('error', 'Maaf, spesimen cupang ini sudah terjual (Sold Out).');
        }

        $cart = session()->get('cart', []);
        $quantityToAdd = (int) $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantityToAdd;
            if ($newQuantity > $product->stock) {
                return back()->with('error', "Stok spesimen cupang ini hanya tersisa {$product->stock} ekor (WYSIWYG: 1 Ikan 1 Spesimen).");
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            if ($quantityToAdd > $product->stock) {
                return back()->with('error', "Stok spesimen cupang ini hanya tersisa {$product->stock} ekor.");
            }

            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'slug' => $product->slug,
                'category_name' => $product->category->name,
                'betta_type' => $product->betta_type,
                'gender' => $product->gender,
                'price' => $product->effective_price,
                'original_price' => $product->price,
                'thumbnail' => $product->thumbnail,
                'quantity' => $quantityToAdd,
                'stock' => $product->stock,
            ];
        }

        session()->put('cart', $cart);

        if ($request->input('buy_now')) {
            return redirect()->route('checkout.index');
        }

        return redirect()->route('cart.index')->with('success', "Spesimen {$product->name} berhasil ditambahkan ke keranjang!");
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::find($id);
            if (! $product) {
                unset($cart[$id]);
                session()->put('cart', $cart);

                return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan lagi.');
            }

            $quantity = (int) $request->input('quantity', 1);
            if ($quantity <= 0) {
                unset($cart[$id]);
            } elseif ($quantity > $product->stock) {
                return redirect()->route('cart.index')->with('error', "Maksimum stok spesimen adalah {$product->stock} ekor.");
            } else {
                $cart[$id]['quantity'] = $quantity;
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang belanja berhasil diperbarui.');
    }

    public function remove(int $id): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Spesimen ikan dikeluarkan dari keranjang belanja.');
    }

    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Keranjang belanja telah dikosongkan.');
    }
}
