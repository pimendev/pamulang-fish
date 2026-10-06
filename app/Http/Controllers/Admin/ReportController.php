<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $period = $request->get('period', 'all');

        $query = Order::query();

        if ($period === 'month') {
            $query->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        } elseif ($period === '30days') {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        $paidOrders = (clone $query)->where('payment_status', 'paid');
        $totalRevenue = $paidOrders->sum('total_amount');
        $totalOrdersCount = (clone $query)->count();
        $paidOrdersCount = $paidOrders->count();

        $totalFishSold = OrderItem::whereHas('order', function ($q) use ($period) {
            $q->where('payment_status', 'paid');
            if ($period === 'month') {
                $q->whereMonth('created_at', now()->month);
            } elseif ($period === '30days') {
                $q->where('created_at', '>=', now()->subDays(30));
            }
        })->sum('quantity');

        $avgOrderValue = $paidOrdersCount > 0 ? (int) ($totalRevenue / $paidOrdersCount) : 0;

        $orders = (clone $query)->with(['items'])->latest()->take(20)->get();

        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalOrdersCount',
            'paidOrdersCount',
            'totalFishSold',
            'avgOrderValue',
            'orders',
            'period'
        ));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $orders = Order::with('items')->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_penjualan_pamulang_fish_'.date('Ymd_His').'.csv"',
        ];

        $callback = function () use ($orders) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            fwrite($handle, "\xEF\xBB\xBF");

            // Header row
            fputcsv($handle, [
                'No. Pesanan',
                'Tanggal',
                'Nama Pelanggan',
                'Email',
                'No. HP',
                'Kota / Provinsi',
                'Kurir',
                'Metode Pembayaran',
                'Status Bayar',
                'Status Pesanan',
                'Subtotal (Rp)',
                'Ongkir & Packing (Rp)',
                'Total (Rp)',
                'Nomor Resi',
            ]);

            foreach ($orders as $ord) {
                fputcsv($handle, [
                    $ord->order_number,
                    $ord->created_at->format('Y-m-d H:i:s'),
                    $ord->customer_name,
                    $ord->customer_email,
                    $ord->customer_phone,
                    $ord->shipping_city.', '.$ord->shipping_province,
                    $ord->shipping_courier,
                    $ord->payment_method,
                    $ord->payment_status,
                    $ord->order_status,
                    $ord->subtotal,
                    $ord->shipping_cost,
                    $ord->total_amount,
                    $ord->tracking_number ?? '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function print(Request $request): View
    {
        $orders = Order::with('items')->latest()->get();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalPaidOrders = Order::where('payment_status', 'paid')->count();

        return view('admin.reports.print', compact('orders', 'totalRevenue', 'totalPaidOrders'));
    }
}
