@extends('layouts.app')

@section('content')
@php
    $theme = $appearance ?? \App\Models\AppearanceSetting::current();
@endphp

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-b from-sky-900 via-slate-900 to-slate-950 text-white py-20 lg:py-28">
    <div class="absolute inset-0 opacity-20 pointer-events-none bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-500/10 border border-sky-400/20 text-sky-300 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                    <span>{{ $theme->hero_badge ?? '100% Spesialis Koleksi Ikan Cupang Hias & Kontes' }}</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                    {{ $theme->hero_title ?? 'Toko Spesialis Khusus Ikan Cupang Hias' }}
                </h1>
                <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                    {{ $theme->hero_subtitle ?? 'Pusat lelang & jual beli 100% khusus jenis ikan cupang pilihan: Halfmoon, Plakat, Crowntail (Serit), Giant, Double Tail, hingga Wild Betta. Murni spesialis Betta Fish berkualitas kontes dengan garansi hidup sampai tujuan.' }}
                </p>
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-4">
                    <a href="{{ $theme->hero_btn_primary_link ?? route('catalog.index') }}" class="btn-primary">
                        <span>{{ $theme->hero_btn_primary_text ?? 'Belanja Sekarang' }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ $theme->hero_btn_secondary_link ?? route('articles.index') }}" class="px-6 py-3 rounded-xl border border-slate-700 bg-slate-800/80 hover:bg-slate-800 text-slate-200 text-sm font-semibold transition flex items-center gap-2">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>{{ $theme->hero_btn_secondary_text ?? 'Panduan Perawatan' }}</span>
                    </a>
                </div>
                <!-- Trust Badges -->
                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-slate-800/80 max-w-lg mx-auto lg:mx-0 text-left">
                    <div>
                        <div class="text-xl font-bold text-white">{{ $theme->trust_badge_1_val ?? '100%' }}</div>
                        <div class="text-xs text-slate-400">{{ $theme->trust_badge_1_lbl ?? 'Garansi Hidup' }}</div>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-white">{{ $theme->trust_badge_2_val ?? 'Grade A+' }}</div>
                        <div class="text-xs text-slate-400">{{ $theme->trust_badge_2_lbl ?? 'Genetik Pilihan' }}</div>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-white">{{ $theme->trust_badge_3_val ?? '24 Jam' }}</div>
                        <div class="text-xs text-slate-400">{{ $theme->trust_badge_3_lbl ?? 'Packing Oksigen' }}</div>
                    </div>
                </div>
            </div>
            <!-- Hero Image Showcase -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-sky-500 to-cyan-500 rounded-3xl blur-lg opacity-40 animate-pulse"></div>
                    <div class="relative rounded-3xl overflow-hidden border border-sky-400/30 bg-slate-900 shadow-2xl group">
                        <div class="h-64 sm:h-72 relative overflow-hidden bg-slate-950">
                            <img src="{{ asset('images/hero-betta.jpg') }}" alt="Champion Betta Fish" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute top-4 left-4 flex flex-col gap-1.5">
                                <span class="bg-gradient-to-r from-amber-500 to-yellow-400 text-slate-950 text-[11px] font-extrabold px-3 py-1 rounded-full shadow-lg">
                                    ★ SPESIMEN KONTES
                                </span>
                                <span class="bg-slate-900/90 backdrop-blur-md text-sky-300 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-sky-400/30">
                                    100% WYSIWYG
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="bg-emerald-500 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-md">
                                    Siap Kirim
                                </span>
                            </div>
                        </div>
                        <div class="p-6 bg-slate-900/95 border-t border-slate-800 text-left space-y-3">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-sky-400 font-bold uppercase tracking-wider">Halfmoon Blue Rim Grade A+</span>
                                <span class="text-slate-400 font-mono">BO: 4.8 cm</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-slate-400 line-through">Rp 250.000</span>
                                    <div class="text-2xl font-black text-white">Rp 199.000</div>
                                </div>
                                <a href="{{ route('catalog.index') }}" class="btn-primary text-xs py-2 px-4">
                                    <span>Pilih Spesimen</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section id="kategori" class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-sky-600 block mb-1">Varian & Spesies</span>
            <h2 class="text-3xl font-extrabold text-slate-900">Kategori Ikan Cupang Pilihan</h2>
            <p class="text-slate-600 text-sm mt-2">Pilih varietas ikan cupang sesuai selera estetika dan kebutuhan koleksi Anda.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="aquatic-card overflow-hidden group block">
                    <div class="h-36 overflow-hidden relative bg-slate-950 flex items-center justify-center border-b border-slate-100">
                        <img src="{{ $category->image ?: '/images/categories/' . $category->slug . '.jpg' }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.onerror=null; this.src='/images/hero-betta.jpg';">
                        <span class="absolute bottom-2.5 left-3 text-white text-[11px] font-bold px-2 py-0.5 rounded bg-sky-600/90 backdrop-blur-xs">
                            {{ $category->products_count ?? $category->products()->count() }} Produk
                        </span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-slate-900 group-hover:text-sky-600 transition text-base">{{ $category->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $category->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section id="produk" class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-sky-600 block mb-1">Katalog Unggulan</span>
                <h2 class="text-3xl font-extrabold text-slate-900">Koleksi Ikan Cupang Terbaru</h2>
                <p class="text-slate-600 text-sm mt-1">Setiap ikan adalah individu unik yang difoto asli sesuai kondisi aslinya.</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-xs font-bold text-sky-600 hover:text-sky-700 flex items-center gap-1 group">
                <span>Lihat Seluruh Koleksi</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredProducts as $product)
                <div class="aquatic-card overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Product Thumbnail & Badges -->
                        <div class="h-56 relative overflow-hidden bg-gradient-to-br from-slate-100 via-sky-50/50 to-slate-200/70 flex items-center justify-center border-b border-slate-100">
                            @if($product->thumbnail)
                                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-white shadow-xs border border-slate-200/80 flex items-center justify-center text-sky-500 mb-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-500">Foto Belum Diunggah</span>
                                    <span class="text-[10px] text-slate-400 mt-0.5">Spesimen Cupang (WYSIWYG)</span>
                                </div>
                            @endif

                            <!-- Status & Betta Type Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                @if($product->has_discount)
                                    <span class="bg-rose-600 text-white text-[11px] font-extrabold px-2.5 py-1 rounded-full shadow-md">
                                        HEMAT {{ $product->discount_percentage }}%
                                    </span>
                                @endif
                                <span class="bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-bold px-2 py-0.5 rounded-full capitalize">
                                    {{ $product->betta_type }}
                                </span>
                            </div>
                            <div class="absolute top-3 right-3">
                                <span class="bg-emerald-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs capitalize">
                                    {{ $product->status }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Information -->
                        <div class="p-5 space-y-3">
                            <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                                <span class="uppercase tracking-wider font-semibold text-sky-700">{{ $product->category->name }}</span>
                                <span>SKU: {{ $product->sku }}</span>
                            </div>

                            <a href="{{ route('catalog.show', $product->slug) }}" class="block">
                                <h3 class="font-bold text-slate-900 text-lg leading-snug hover:text-sky-600 transition">
                                    {{ $product->name }}
                                </h3>
                            </a>

                            <!-- Betta Specific Attributes Badge Row -->
                            @if($product->gender !== 'unsexed')
                                <div class="grid grid-cols-3 gap-2 py-2 border-y border-slate-100 text-center text-xs">
                                    <div class="bg-slate-100/70 p-1.5 rounded">
                                        <span class="text-slate-400 block text-[10px]">Gender</span>
                                        <span class="font-bold text-slate-800 capitalize">{{ $product->gender }}</span>
                                    </div>
                                    <div class="bg-slate-100/70 p-1.5 rounded">
                                        <span class="text-slate-400 block text-[10px]">Ukuran</span>
                                        <span class="font-bold text-slate-800">{{ $product->size_cm ? $product->size_cm . ' cm' : '-' }}</span>
                                    </div>
                                    <div class="bg-slate-100/70 p-1.5 rounded">
                                        <span class="text-slate-400 block text-[10px]">Umur</span>
                                        <span class="font-bold text-slate-800">{{ $product->age_months ? $product->age_months . ' bln' : '-' }}</span>
                                    </div>
                                </div>
                            @endif

                            <p class="text-xs text-slate-600 line-clamp-2">
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Price & CTA -->
                    <div class="p-5 pt-0 flex items-center justify-between border-t border-slate-100 gap-2">
                        <div>
                            @if($product->has_discount)
                                <div class="text-xs text-slate-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="text-xl font-extrabold text-sky-700">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</div>
                            @else
                                <div class="text-xl font-extrabold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            @endif
                        </div>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                Detail
                            </a>
                            <form method="POST" action="{{ route('cart.add', $product) }}">
                                @csrf
                                <button type="submit" class="btn-primary text-xs px-3 py-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <span>Beli</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Educational Articles Section -->
<section id="panduan" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-sky-600 block mb-1">Pusat Edukasi</span>
            <h2 class="text-3xl font-extrabold text-slate-900">Panduan & Tips Perawatan Cupang</h2>
            <p class="text-slate-600 text-sm mt-2">Dapatkan wawasan seputar air, pakan, pengobatan dan teknik pembesaran cupang dari pengalaman breeder terpercaya.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestArticles as $article)
                <a href="{{ route('articles.show', $article->slug) }}" class="aquatic-card overflow-hidden flex flex-col justify-between group block">
                    <div>
                        <div class="h-44 overflow-hidden relative bg-gradient-to-br from-slate-100 via-sky-50 to-slate-200/80 flex items-center justify-center border-b border-slate-100">
                            @if($article->featured_image)
                                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                    <div class="w-11 h-11 rounded-xl bg-white shadow-xs border border-slate-200/80 flex items-center justify-center text-sky-600 mb-1.5 group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                    <span class="text-[11px] font-semibold text-slate-500">Panduan Edukasi Cupang</span>
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 bg-sky-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-xs">
                                {{ $article->category->name }}
                            </span>
                        </div>
                        <div class="p-5 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-slate-400 font-medium">
                                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : date('d M Y') }}</span>
                                <span>•</span>
                                <span>{{ $article->reading_time_minutes }} menit baca</span>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base group-hover:text-sky-600 transition leading-snug">
                                {{ $article->title }}
                            </h3>
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                {{ $article->excerpt }}
                            </p>
                        </div>
                    </div>
                    <div class="p-5 pt-0">
                        <span class="text-xs font-bold text-sky-600 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            <span>Baca Selengkapnya</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
