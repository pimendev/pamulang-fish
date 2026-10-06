@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="pb-6 mb-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-sky-600">Wishlist & Favorit</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Spesimen Cupang Koleksi Impian</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar spesimen ikan cupang hias yang Anda tandai untuk koleksi akuarium Anda.</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 transition self-start sm:self-auto">
            + Cari Spesimen Lain
        </a>
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="aquatic-card overflow-hidden group flex flex-col justify-between">
                    <div>
                        <div class="h-48 relative overflow-hidden bg-slate-100 flex items-center justify-center">
                            @if($product->thumbnail)
                                <img src="{{ $product->thumbnail }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                            @else
                                <span class="text-xs text-slate-400">WYSIWYG Betta</span>
                            @endif
                            <span class="absolute top-2 left-2 bg-slate-900/80 text-white text-[10px] font-bold px-2 py-0.5 rounded-full capitalize">
                                {{ $product->betta_type }}
                            </span>
                        </div>

                        <div class="p-4 space-y-2 text-xs">
                            <span class="text-[10px] uppercase font-bold text-sky-600">{{ $product->category->name }}</span>
                            <h4 class="font-bold text-slate-900 line-clamp-1 text-sm">{{ $product->name }}</h4>
                            <span class="font-extrabold text-slate-900 block text-base">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="p-4 pt-0 space-y-2">
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <button type="submit" class="w-full py-2.5 rounded-xl text-xs font-bold bg-sky-600 hover:bg-sky-700 text-white transition shadow-xs">
                                + Masukkan Keranjang
                            </button>
                        </form>

                        <form method="POST" action="{{ route('wishlist.toggle', $product) }}">
                            @csrf
                            <button type="submit" class="w-full py-1.5 rounded-xl text-[11px] font-semibold text-rose-600 hover:bg-rose-50 transition">
                                Hapus dari Wishlist
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 max-w-md mx-auto space-y-3">
            <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mx-auto text-2xl">
                ♡
            </div>
            <h3 class="font-bold text-slate-900 text-base">Wishlist Anda Masih Kosong</h3>
            <p class="text-xs text-slate-500">Tandai spesimen ikan cupang favorit Anda saat menjelajahi katalog.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block mt-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-sky-600 text-white hover:bg-sky-700 transition">
                Jelajahi Katalog Cupang &rarr;
            </a>
        </div>
    @endif
</div>
@endsection
