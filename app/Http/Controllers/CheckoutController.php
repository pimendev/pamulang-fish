<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong. Silakan pilih spesimen cupang terlebih dahulu.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $packingCost = 25000;
        $shippingCost = 35000; // Ekspedisi Kilat Hewan Hidup (JNE YES / TIKI ONS)
        $total = $subtotal + $packingCost + $shippingCost;

        $user = auth()->user();

        return view('frontend.checkout', compact('cart', 'subtotal', 'packingCost', 'shippingCost', 'total', 'user'));
    }

    public function process(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:25',
            'shipping_province' => 'required|string|max:100',
            'shipping_city' => 'required|string|max:100',
            'shipping_district' => 'required|string|max:100',
            'shipping_address' => 'required|string',
            'shipping_postal_code' => 'required|string|max:10',
            'shipping_courier' => 'required|string|max:100',
            'payment_method' => 'required|string|in:bank_transfer,qris,virtual_account',
            'notes' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated, $cart) {
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $packingCost = 25000;
            $shippingCost = 35000;
            $totalAmount = $subtotal + $packingCost + $shippingCost;

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_province' => $validated['shipping_province'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_district' => $validated['shipping_district'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_courier' => $validated['shipping_courier'],
                'special_live_fish_packing' => true,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost + $packingCost,
                'discount' => 0,
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'order_status' => 'received',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'product_sku' => $item['sku'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Reduce stock
                $product = Product::find($productId);
                if ($product) {
                    $newStock = max(0, $product->stock - $item['quantity']);
                    $product->stock = $newStock;
                    if ($newStock <= 0) {
                        $product->status = 'sold_out';
                    }
                    $product->save();
                }
            }

            // Clear session cart
            session()->forget('cart');

            return redirect()->route('orders.show', $order->order_number)->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran untuk memulai persiapan ikan cupang.');
        });
    }
}
