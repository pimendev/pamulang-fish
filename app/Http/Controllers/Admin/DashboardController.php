<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppearanceSetting;
use App\Models\Article;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_sales' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'low_stock' => Product::where('stock', '<=', 2)->count(),
            'total_articles' => Article::where('status', 'published')->count(),
        ];

        $recentOrders = Order::latest()->take(5)->get();
        $appearance = AppearanceSetting::current();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'appearance'));
    }
}
