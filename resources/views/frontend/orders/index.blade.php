@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="pb-6 mb-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-sky-600">Akun Pelanggan</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Riwayat Pesanan Spesimen</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar transaksi dan tracking pengiriman ikan cupang hias Anda.</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 transition self-start sm:self-auto">
            + Belanja Spesimen Baru
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-6">No. Pesanan</th>
                            <th class="py-3.5 px-6">Tanggal</th>
                            <th class="py-3.5 px-6">Spesimen Dipesan</th>
                            <th class="py-3.5 px-6">Total Belanja</th>
                            <th class="py-3.5 px-6">Status Bayar</th>
                            <th class="py-3.5 px-6">Status Ekspedisi</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($orders as $ord)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 font-bold text-sky-600 font-mono">{{ $ord->order_number }}</td>
                                <td class="py-4 px-6 text-slate-500">{{ $ord->created_at->format('d M Y') }}</td>
                                <td class="py-4 px-6 font-medium text-slate-800">
                                    {{ $ord->items->count() }} Varietas Ikan
                                </td>
                                <td class="py-4 px-6 font-extrabold text-slate-900">
                                    Rp {{ number_format($ord->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ord->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $ord->payment_status }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                        {{ str_replace('_', ' ', $ord->order_status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('orders.show', $ord->order_number) }}" class="inline-block px-3 py-1.5 rounded-lg text-xs font-bold text-sky-600 bg-sky-50 hover:bg-sky-100 transition">
                                        Lihat & Lacak &rarr;
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 text-xs text-slate-500 space-y-3">
            <p>Anda belum memiliki riwayat transaksi pembelian ikan cupang.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block px-5 py-2.5 rounded-xl font-bold bg-sky-600 text-white hover:bg-sky-700 transition">
                Jelajahi Katalog Cupang &rarr;
            </a>
        </div>
    @endif
</div>
@endsection
