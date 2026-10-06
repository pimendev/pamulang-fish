@extends('layouts.admin')

@section('content')
<div class="pb-8 mb-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-100 text-sky-800">Laporan Keuangan</span>
            <span class="text-xs text-slate-400">Analitik & Pembukuan Toko</span>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Laporan Penjualan & Analitik</h1>
        <p class="text-xs text-slate-500 mt-0.5">Rekapitulasi keuangan omzet penjualan ikan cupang, rata-rata transaksi, dan ekspor pembukuan.</p>
    </div>
    <div class="flex items-center gap-2 self-start sm:self-auto">
        <a href="{{ route('admin.reports.export_csv') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition flex items-center gap-1.5 shadow-xs">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>Ekspor Excel (.csv)</span>
        </a>
        <a href="{{ route('admin.reports.print') }}" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 transition flex items-center gap-1.5 shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Cetak Rekap</span>
        </a>
    </div>
</div>

<!-- Period Filter Tabs -->
<div class="flex items-center gap-2 mb-8 text-xs font-semibold">
    <a href="{{ route('admin.reports.index', ['period' => 'all']) }}" class="px-4 py-2 rounded-xl transition {{ $period === 'all' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white border text-slate-700 hover:bg-slate-50' }}">
        Semua Waktu
    </a>
    <a href="{{ route('admin.reports.index', ['period' => 'month']) }}" class="px-4 py-2 rounded-xl transition {{ $period === 'month' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white border text-slate-700 hover:bg-slate-50' }}">
        Bulan Ini ({{ now()->translatedFormat('F Y') }})
    </a>
    <a href="{{ route('admin.reports.index', ['period' => '30days']) }}" class="px-4 py-2 rounded-xl transition {{ $period === '30days' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white border text-slate-700 hover:bg-slate-50' }}">
        30 Hari Terakhir
    </a>
</div>

<!-- 4 Key Analytics Metric Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-1">
        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Omzet Penjualan</span>
        <span class="text-2xl font-extrabold text-slate-900 block">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        <span class="text-[11px] text-emerald-600 font-semibold block">Dari {{ $paidOrdersCount }} pesanan lunas</span>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-1">
        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Ikan Cupang Terjual</span>
        <span class="text-2xl font-extrabold text-sky-700 block">{{ $totalFishSold }} Ekor</span>
        <span class="text-[11px] text-slate-500 font-semibold block">Spesimen kontes teradopsi</span>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-1">
        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Rata-Rata Nilai Order (AOV)</span>
        <span class="text-2xl font-extrabold text-indigo-700 block">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</span>
        <span class="text-[11px] text-slate-500 font-semibold block">Nilai belanja per transaksi</span>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-1">
        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Tingkat Pelunasan</span>
        @php
            $conversionRate = $totalOrdersCount > 0 ? round(($paidOrdersCount / $totalOrdersCount) * 100) : 0;
        @endphp
        <span class="text-2xl font-extrabold text-emerald-700 block">{{ $conversionRate }}%</span>
        <span class="text-[11px] text-slate-500 font-semibold block">{{ $paidOrdersCount }} lunas dari {{ $totalOrdersCount }} order</span>
    </div>
</div>

<!-- Recent Transactions in Report -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="text-sm font-bold text-slate-900">Rekapitulasi Transaksi Penjualan Terakhir</h3>
            <p class="text-xs text-slate-400">Menampilkan hingga 20 transaksi pada periode terpilih</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <th class="py-3 px-4">No. Pesanan</th>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4">Pelanggan</th>
                    <th class="py-3 px-4">Metode Bayar</th>
                    <th class="py-3 px-4">Nilai Transaksi</th>
                    <th class="py-3 px-4">Status Bayar</th>
                    <th class="py-3 px-4">Status Ekspedisi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $ord)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3.5 px-4 font-mono font-bold text-sky-600">{{ $ord->order_number }}</td>
                        <td class="py-3.5 px-4 text-slate-500">{{ $ord->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-3.5 px-4 font-medium text-slate-800">{{ $ord->customer_name }}</td>
                        <td class="py-3.5 px-4 uppercase text-slate-600">{{ str_replace('_', ' ', $ord->payment_method) }}</td>
                        <td class="py-3.5 px-4 font-bold text-slate-900">Rp {{ number_format($ord->total_amount, 0, ',', '.') }}</td>
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ord->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $ord->payment_status }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                {{ str_replace('_', ' ', $ord->order_status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-slate-400">Belum ada riwayat transaksi pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
