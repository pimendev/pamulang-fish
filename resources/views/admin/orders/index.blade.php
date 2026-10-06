@extends('layouts.admin')

@section('content')
<div class="pb-8 mb-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-100 text-sky-800">Pesanan</span>
            <span class="text-xs text-slate-400">Manajemen Pesanan & Ekspedisi</span>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Pesanan & Pengiriman Ikan Hidup</h1>
        <p class="text-xs text-slate-500 mt-0.5">Kelola verifikasi pembayaran, puasa karantina ikan, packing oksigen, dan input nomor resi kilat.</p>
    </div>
</div>

<!-- Filters Bar -->
<div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-6">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Pesanan, Nama, Resi..." class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:border-sky-500">
        </div>
        <div>
            <select name="status" class="w-full px-3 py-2 border rounded-xl bg-white focus:outline-none focus:border-sky-500">
                <option value="">Semua Tahapan Ekspedisi</option>
                <option value="received" {{ request('status') === 'received' ? 'selected' : '' }}>Pesanan Diterima (Received)</option>
                <option value="payment_confirmed" {{ request('status') === 'payment_confirmed' ? 'selected' : '' }}>Pembayaran Valid</option>
                <option value="fish_preparation" {{ request('status') === 'fish_preparation' ? 'selected' : '' }}>Puasa & Karantina Ikan</option>
                <option value="packing" {{ request('status') === 'packing' ? 'selected' : '' }}>Packing Tabung Oksigen</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Sedang Dikirim (Shipped)</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Tiba Selamat (Delivered)</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <div>
            <select name="payment_status" class="w-full px-3 py-2 border rounded-xl bg-white focus:outline-none focus:border-sky-500">
                <option value="">Semua Status Bayar</option>
                <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Menunggu Bayar (Pending)</option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Lunas Terverifikasi (Paid)</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="flex-1 py-2 rounded-xl font-bold bg-sky-600 text-white hover:bg-sky-700 transition">
                Filter Pesanan
            </button>
            <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 rounded-xl text-slate-500 border hover:bg-slate-50 transition" title="Reset filter">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <th class="py-3.5 px-4">No. Pesanan</th>
                    <th class="py-3.5 px-4">Pelanggan</th>
                    <th class="py-3.5 px-4">Spesimen Dipesan</th>
                    <th class="py-3.5 px-4">Total Bayar</th>
                    <th class="py-3.5 px-4">Status Bayar</th>
                    <th class="py-3.5 px-4">Tahapan Ekspedisi</th>
                    <th class="py-3.5 px-4">No. Resi</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $ord)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="py-3.5 px-4 font-mono font-bold text-sky-600">
                            {{ $ord->order_number }}
                            <span class="block text-[10px] text-slate-400 font-sans mt-0.5">{{ $ord->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-900 block">{{ $ord->customer_name }}</span>
                            <span class="text-[10px] text-slate-500 block">{{ $ord->shipping_city }} ({{ $ord->customer_phone }})</span>
                        </td>
                        <td class="py-3.5 px-4 font-medium text-slate-700">
                            {{ $ord->items->count() }} Varietas Cupang
                        </td>
                        <td class="py-3.5 px-4 font-extrabold text-slate-900">
                            Rp {{ number_format($ord->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ord->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $ord->payment_status }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            @php
                                $badgeClass = match($ord->order_status) {
                                    'delivered' => 'bg-emerald-100 text-emerald-800',
                                    'shipped' => 'bg-sky-100 text-sky-800',
                                    'packing', 'fish_preparation' => 'bg-indigo-100 text-indigo-800',
                                    'cancelled' => 'bg-rose-100 text-rose-800',
                                    default => 'bg-slate-100 text-slate-700'
                                };
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $badgeClass }}">
                                {{ str_replace('_', ' ', $ord->order_status) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-mono text-[11px] text-slate-600">
                            {{ $ord->tracking_number ?? '-' }}
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="{{ route('admin.orders.show', $ord) }}" class="inline-block px-3 py-1.5 rounded-lg text-xs font-bold text-sky-600 bg-sky-50 hover:bg-sky-100 transition">
                                Kelola &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-10 text-slate-400">Tidak ada pesanan ikan cupang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
