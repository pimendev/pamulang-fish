<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function show(string $order_number): View
    {
        $order = Order::with(['items.product', 'user'])
            ->where('order_number', $order_number)
            ->firstOrFail();

        return view('frontend.orders.show', compact('order'));
    }

    public function confirmPayment(Request $request, string $order_number): RedirectResponse
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        $request->validate([
            'payment_proof' => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            $order->payment_proof = '/storage/'.$path;
        }

        $order->payment_status = 'paid';
        if ($order->order_status === 'received') {
            $order->order_status = 'payment_confirmed';
        }
        $order->save();

        return redirect()->route('orders.show', $order->order_number)->with('success', 'Pembayaran berhasil dikonfirmasi! Tim Pamulang Fish sedang mempersiapkan karantina & packing spesimen.');
    }

    public function customerOrders(): View
    {
        $user = auth()->user();
        $orders = Order::with(['items'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }

    public function track(Request $request): View
    {
        $order = null;
        if ($request->filled('order_number')) {
            $order = Order::with(['items'])
                ->where('order_number', trim($request->order_number))
                ->first();
        }

        return view('frontend.tracking', compact('order'));
    }
}
