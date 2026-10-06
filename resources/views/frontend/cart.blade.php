@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="pb-6 mb-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-sky-600">Keranjang Belanja</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Spesimen Cupang Dipilih</h1>
        </div>
        @if(!empty($cart))
            <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Kosongkan seluruh keranjang belanja?');">
                @csrf
                <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-700 hover:underline">
                    Kosongkan Keranjang
                </button>
            </form>
        @endif
    </div>

    @if(!empty($cart))
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Items Table (8 cols) -->
            <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                                <th class="py-3 px-4">Spesimen Cupang</th>
                                <th class="py-3 px-4">Harga Satuan</th>
                                <th class="py-3 px-4 text-center">Jumlah</th>
                                <th class="py-3 px-4 text-right">Subtotal</th>
                                <th class="py-3 px-4 text-center">Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($cart as $id => $item)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <!-- Product Info -->
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-14 h-14 rounded-xl bg-slate-100 border overflow-hidden flex-shrink-0 flex items-center justify-center">
                                                @if(!empty($item['thumbnail']))
                                                    <img src="{{ $item['thumbnail'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route('catalog.show', $item['slug']) }}" class="font-bold text-slate-900 hover:text-sky-600 transition block leading-snug">
                                                    {{ $item['name'] }}
                                                </a>
                                                <span class="text-[10px] text-slate-400 block mt-0.5">SKU: {{ $item['sku'] }} | {{ $item['gender'] }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Price -->
                                    <td class="py-4 px-4 font-semibold text-slate-800">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </td>

                                    <!-- Quantity controls -->
                                    <td class="py-4 px-4">
                                        <form method="POST" action="{{ route('cart.update', $id) }}" class="flex items-center justify-center gap-1">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="w-7 h-7 rounded-lg border bg-slate-50 hover:bg-slate-100 flex items-center justify-center font-bold text-slate-600">
                                                -
                                            </button>
                                            <span class="w-8 text-center font-bold text-slate-900">{{ $item['quantity'] }}</span>
                                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" {{ $item['quantity'] >= $item['stock'] ? 'disabled' : '' }} class="w-7 h-7 rounded-lg border bg-slate-50 hover:bg-slate-100 flex items-center justify-center font-bold text-slate-600 disabled:opacity-30">
                                                +
                                            </button>
                                        </form>
                                    </td>

                                    <!-- Subtotal -->
                                    <td class="py-4 px-4 text-right font-extrabold text-slate-900">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </td>

                                    <!-- Delete -->
                                    <td class="py-4 px-4 text-center">
                                        <form method="POST" action="{{ route('cart.remove', $id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700" title="Hapus spesimen">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                    <a href="{{ route('catalog.index') }}" class="text-xs font-bold text-sky-600 hover:underline">
                        &larr; Tambah Spesimen Lain dari Katalog
                    </a>
                </div>
            </div>

            <!-- Summary Card (4 cols) -->
            <div class="lg:col-span-4 space-y-4">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4 text-xs">
                    <h3 class="font-extrabold text-slate-900 text-sm pb-3 border-b border-slate-100">
                        Ringkasan Pembelian
                    </h3>

                    <div class="space-y-2.5 text-slate-600">
                        <div class="flex items-center justify-between">
                            <span>Subtotal Spesimen Ikan</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-1">
                                <span>Packing Tabung Oksigen & Box</span>
                                <span class="text-[10px] bg-sky-100 text-sky-800 font-bold px-1.5 py-0.2 rounded-full">Wajib</span>
                            </span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($packingCost, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-sm">
                        <span class="font-bold text-slate-800">Total Pembayaran</span>
                        <span class="text-xl font-extrabold text-sky-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="block w-full py-3.5 rounded-xl font-bold text-xs bg-sky-600 hover:bg-sky-700 text-white text-center shadow-md shadow-sky-500/20 transition">
                        Lanjut ke Checkout Pengiriman &rarr;
                    </a>
                </div>

                <!-- Live Fish Shipping Notice -->
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-900 space-y-1">
                    <div class="font-bold flex items-center gap-1.5 text-emerald-800">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Garansi Selamat Sampai Tujuan</span>
                    </div>
                    <p class="text-[11px] leading-relaxed text-emerald-800/80">
                        Ikan akan dipuasakan 24 jam sebelum pengiriman dan dikemas dengan oksigen murni serta sterofoam khusus agar tetap prima di perjalanan.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 shadow-xs max-w-xl mx-auto space-y-4">
            <div class="w-16 h-16 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center mx-auto">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-slate-900">Keranjang Belanja Masih Kosong</h2>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">
                Anda belum memilih spesimen ikan cupang hias untuk diadopsi. Jelajahi katalog kami dan temukan cupang impian Anda.
            </p>
            <a href="{{ route('catalog.index') }}" class="inline-block px-6 py-3 rounded-xl font-bold text-xs bg-sky-600 text-white hover:bg-sky-700 shadow-md shadow-sky-500/20 transition">
                Jelajahi Katalog Cupang Sekarang &rarr;
            </a>
        </div>
    @endif
</div>
@endsection
