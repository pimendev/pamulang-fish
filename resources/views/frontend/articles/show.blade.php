@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium">
        <a href="{{ route('home') }}" class="hover:text-sky-600 transition">Beranda</a>
        <span>/</span>
        <a href="{{ route('articles.index') }}" class="hover:text-sky-600 transition">Panduan Cupang</a>
        <span>/</span>
        <span class="text-slate-800 font-bold truncate max-w-sm">{{ $article->title }}</span>
    </nav>

    <!-- Article Header -->
    <header class="space-y-4 pb-8 border-b border-slate-200">
        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800 uppercase">
            {{ $article->category->name }}
        </span>
        <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
            {{ $article->title }}
        </h1>
        <div class="flex items-center gap-4 text-xs text-slate-500">
            <span>Ditulis oleh: <strong class="text-slate-700">{{ $article->author->name ?? 'Breeder Pamulang Fish' }}</strong></span>
            <span>&bull;</span>
            <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
            <span>&bull;</span>
            <span>{{ $article->reading_time_minutes }} menit waktu baca</span>
        </div>
    </header>

    <!-- Main Content Body -->
    <div class="py-10 text-slate-700 leading-relaxed text-sm space-y-6 border-b border-slate-200 prose prose-slate max-w-none">
        {!! $article->content !!}
    </div>

    <!-- Cross-Selling Section (Fitur Pertemuan 9) -->
    @if($article->relatedProducts->count() > 0)
        <div class="mt-12 p-8 rounded-3xl bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 text-white space-y-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-sky-500/20 text-sky-300 border border-sky-400/30 uppercase">
                    Rekomendasi Spesimen Sesuai Panduan
                </span>
                <h3 class="text-xl font-extrabold tracking-tight mt-2">Ikan Cupang Terkait Topik Ini</h3>
                <p class="text-xs text-slate-300 mt-1">Spesimen pilihan terbaik di farm Pamulang Fish Store yang relevan dengan teknik perawatan di atas.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($article->relatedProducts as $relProduct)
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-16 rounded-xl bg-slate-800 overflow-hidden flex-shrink-0 flex items-center justify-center border border-white/10">
                                @if($relProduct->thumbnail)
                                    <img src="{{ $relProduct->thumbnail }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-[9px] text-slate-400">Cupang</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-sky-400 block">{{ $relProduct->category->name }}</span>
                                <h4 class="font-bold text-white text-xs leading-snug line-clamp-1">{{ $relProduct->name }}</h4>
                                <span class="text-sm font-extrabold text-white block mt-1">Rp {{ number_format($relProduct->effective_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('catalog.show', $relProduct->slug) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-sky-500 hover:bg-sky-400 text-white transition flex-shrink-0 shadow-md">
                            Lihat &rarr;
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Back to Articles -->
    <div class="pt-8 flex items-center justify-between text-xs">
        <a href="{{ route('articles.index') }}" class="font-bold text-sky-600 hover:underline">
            &larr; Kembali ke Daftar Panduan Cupang
        </a>
        <a href="{{ route('catalog.index') }}" class="font-bold text-slate-700 hover:underline">
            Katalog Spesimen Cupang &rarr;
        </a>
    </div>
</div>
@endsection
