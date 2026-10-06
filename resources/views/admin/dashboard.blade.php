@extends('layouts.admin')

@section('content')
<!-- Top bar -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between pb-8 mb-8 border-b border-slate-200 gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Overview Dashboard Toko</h1>
        <p class="text-xs text-slate-500 mt-1">Status operasional & penjualan Pamulang Fish Store (100% Khusus Ikan Cupang Hias).</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <span>Database Connected (MySQL Port 3307)</span>
        </span>
    </div>
</div>

<!-- 6 Core Metric Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
    <!-- Total Sales -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Penjualan</span>
            <span class="text-2xl font-extrabold text-slate-900 block mt-1">Rp {{ number_format($stats['total_sales'], 0, ',', '.') }}</span>
            <span class="text-[11px] text-emerald-600 font-semibold mt-1 block">Pesanan lunas terverifikasi</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>

    <!-- Total Products -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Ikan Cupang</span>
            <span class="text-2xl font-extrabold text-slate-900 block mt-1">{{ $stats['total_products'] }} Ekor</span>
            <span class="text-[11px] text-sky-600 font-semibold mt-1 block">100% Khusus Varietas Cupang</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/></svg>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Pesanan</span>
            <span class="text-2xl font-extrabold text-slate-900 block mt-1">{{ $stats['total_orders'] }} Transaksi</span>
            <span class="text-[11px] text-slate-500 font-semibold mt-1 block">Alur live fish tracking</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Pelanggan Terdaftar</span>
            <span class="text-2xl font-extrabold text-slate-900 block mt-1">{{ $stats['total_customers'] }} User</span>
            <span class="text-[11px] text-slate-500 font-semibold mt-1 block">Customer role</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
    </div>

    <!-- Low Stock -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Stok Menipis (&le; 2)</span>
            <span class="text-2xl font-extrabold text-rose-600 block mt-1">{{ $stats['low_stock'] }} Varian</span>
            <span class="text-[11px] text-slate-500 font-semibold mt-1 block">Perlu restock segera</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
    </div>

    <!-- Educational Articles -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Artikel Edukasi Aktif</span>
            <span class="text-2xl font-extrabold text-cyan-600 block mt-1">{{ $stats['total_articles'] }} Post</span>
            <span class="text-[11px] text-slate-500 font-semibold mt-1 block">Content Marketing & Cross-selling</span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        </div>
    </div>
</div>

<!-- Live Appearance / Theme Setting Card -->
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs mb-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-4 border-b border-slate-100 gap-2">
        <div>
            <span class="text-xs font-bold text-sky-600 uppercase tracking-wider">Kustomisasi Tampilan & Frontend Dinamis</span>
            <h3 class="text-lg font-bold text-slate-900">Konfigurasi Desain & Live Customizer Aktif</h3>
        </div>
        <a href="{{ route('admin.appearance.index') }}" class="text-xs font-bold px-3 py-1.5 rounded-lg bg-sky-50 text-sky-700 hover:bg-sky-100 transition flex items-center gap-1.5">
            <span>Buka Live Customizer</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 text-xs">
        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
            <span class="text-slate-400 block text-[10px]">Primary Color</span>
            <div class="flex items-center gap-2 mt-1">
                <span class="w-4 h-4 rounded-full border border-slate-300" style="background-color: {{ $appearance->primary_color }}"></span>
                <span class="font-bold text-slate-800">{{ $appearance->primary_color }}</span>
            </div>
        </div>
        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
            <span class="text-slate-400 block text-[10px]">Secondary Color</span>
            <div class="flex items-center gap-2 mt-1">
                <span class="w-4 h-4 rounded-full border border-slate-300" style="background-color: {{ $appearance->secondary_color }}"></span>
                <span class="font-bold text-slate-800">{{ $appearance->secondary_color }}</span>
            </div>
        </div>
        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
            <span class="text-slate-400 block text-[10px]">Accent Color</span>
            <div class="flex items-center gap-2 mt-1">
                <span class="w-4 h-4 rounded-full border border-slate-300" style="background-color: {{ $appearance->accent_color }}"></span>
                <span class="font-bold text-slate-800">{{ $appearance->accent_color }}</span>
            </div>
        </div>
        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
            <span class="text-slate-400 block text-[10px]">Font Family</span>
            <span class="font-bold text-slate-800 block mt-1">{{ $appearance->font_family }}</span>
        </div>
        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
            <span class="text-slate-400 block text-[10px]">Border Radius</span>
            <span class="font-bold text-slate-800 block mt-1">{{ $appearance->border_radius }}</span>
        </div>
        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
            <span class="text-slate-400 block text-[10px]">Theme Mode</span>
            <span class="font-bold text-slate-800 block mt-1 capitalize">{{ $appearance->theme_mode }}</span>
        </div>
    </div>
</div>

<!-- Recent Orders Section -->
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
    <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
        <div>
            <h3 class="text-lg font-bold text-slate-900">Pesanan Ikan Cupang Terbaru</h3>
            <p class="text-xs text-slate-500">Daftar transaksi dan pengiriman ekspedisi hewan hidup</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-sky-600 hover:text-sky-700">Lihat Semua Pesanan &rarr;</a>
    </div>

    @if($recentOrders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-100 uppercase tracking-wider font-semibold">
                        <th class="pb-3">No. Pesanan</th>
                        <th class="pb-3">Customer</th>
                        <th class="pb-3">Total Belanja</th>
                        <th class="pb-3">Status Bayar</th>
                        <th class="pb-3">Status Pengiriman</th>
                        <th class="pb-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($recentOrders as $ord)
                        <tr>
                            <td class="py-3 font-bold text-sky-600">{{ $ord->order_number }}</td>
                            <td class="py-3 font-medium text-slate-800">{{ $ord->customer_name }}</td>
                            <td class="py-3 font-bold text-slate-900">Rp {{ number_format($ord->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ord->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $ord->payment_status }}
                                </span>
                            </td>
                            <td class="py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                    {{ str_replace('_', ' ', $ord->order_status) }}
                                </span>
                            </td>
                            <td class="py-3 text-slate-400">{{ $ord->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 text-slate-400 text-xs">
            Belum ada pesanan terbaru. Transaksi customer akan muncul di sini secara otomatis.
        </div>
    @endif
</div>
@endsection
