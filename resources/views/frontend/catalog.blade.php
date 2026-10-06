@extends('layouts.app')

@section('content')
@php
    $currentSort = request('sort', 'terkait');
    if ($currentSort === 'latest') $currentSort = 'terbaru';
    if ($currentSort === 'popular') $currentSort = 'terlaris';
    if ($currentSort === 'price_low') $currentSort = 'harga_terendah';
    if ($currentSort === 'price_high') $currentSort = 'harga_tertinggi';

    $isPriceSort = in_array($currentSort, ['harga_terendah', 'harga_tertinggi']);
    $priceLabel = match($currentSort) {
        'harga_terendah' => 'Harga: Rendah ke Tinggi',
        'harga_tertinggi' => 'Harga: Tinggi ke Rendah',
        default => 'Harga',
    };

    $activeCategory = $categories->firstWhere('slug', request('category'));
    $hasActiveFilters = request()->anyFilled(['q', 'category', 'type', 'gender', 'care_level', 'min_price', 'max_price']);
@endphp

<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-500/20 text-sky-300 border border-sky-400/30 mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                <span>Katalog 100% Khusus Ikan Cupang Hias (Betta Fish Only)</span>
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Katalog Spesimen Ikan Cupang</h1>
            <p class="text-sm text-slate-300 mt-2 leading-relaxed">
                Temukan varietas cupang kontes pilihan dengan corak mutasi eksotis. Setiap ikan yang Anda lihat adalah spesimen asli yang akan dikirim (WYSIWYG: What You See Is What You Get).
            </p>
        </div>
    </div>
</section>

<!-- Main Catalog Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Filter Sidebar (3 cols) -->
        <aside class="lg:col-span-3">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs sticky top-24 space-y-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        <span>Filter Katalog</span>
                    </h3>
                    @if($hasActiveFilters)
                        <a href="{{ route('catalog.index', ['sort' => $currentSort]) }}" class="text-[11px] font-bold text-rose-600 hover:text-rose-700 hover:underline flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Reset
                        </a>
                    @endif
                </div>

                <form id="filter-form" method="GET" action="{{ route('catalog.index') }}" class="space-y-5 text-xs">
                    <!-- Preserve currently active sort -->
                    <input type="hidden" name="sort" value="{{ $currentSort }}">

                    <!-- Search Input -->
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Pencarian Spesimen</label>
                        <div class="relative flex items-center">
                            <input type="text" id="filter-search-input" name="q" value="{{ request('q') }}" placeholder="Cari warna, nama, SKU..." class="w-full pl-8 pr-8 py-2 border rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition">
                            <svg class="w-4 h-4 text-slate-400 absolute left-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            @if(request('q'))
                                <button type="button" onclick="clearSearch()" class="absolute right-2.5 text-slate-400 hover:text-slate-600 p-0.5" title="Hapus Pencarian">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Kategori Varietas -->
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Kategori Varietas</label>
                        <select id="filter-category" name="category" onchange="handleFilterCategoryChange(this)" class="w-full px-3 py-2 border rounded-xl bg-white text-slate-800 font-medium focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition cursor-pointer">
                            <option value="">Semua Varietas Cupang</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bentuk Sirip (Tipe) -->
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Bentuk Sirip (Tipe)</label>
                        <select id="filter-type" name="type" onchange="handleFilterTypeChange(this)" class="w-full px-3 py-2 border rounded-xl bg-white text-slate-800 font-medium focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition cursor-pointer">
                            <option value="">Semua Tipe Sirip</option>
                            <option value="halfmoon" {{ request('type') === 'halfmoon' ? 'selected' : '' }}>Cupang Halfmoon (180°)</option>
                            <option value="plakat" {{ request('type') === 'plakat' ? 'selected' : '' }}>Cupang Plakat (Ekor Pendek)</option>
                            <option value="crowntail" {{ request('type') === 'crowntail' ? 'selected' : '' }}>Cupang Crowntail (Serit)</option>
                            <option value="double_tail" {{ request('type') === 'double_tail' ? 'selected' : '' }}>Cupang Double Tail (Cagak)</option>
                            <option value="giant" {{ request('type') === 'giant' ? 'selected' : '' }}>Cupang Giant (Raksasa)</option>
                            <option value="dumbo_ear" {{ request('type') === 'dumbo_ear' ? 'selected' : '' }}>Cupang Dumbo Ear (Telinga Gajah)</option>
                            <option value="alien" {{ request('type') === 'alien' ? 'selected' : '' }}>Cupang Alien & Wild Hybrid</option>
                        </select>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Jenis Kelamin (Gender)</label>
                        <div class="space-y-1.5">
                            <label class="flex items-center gap-2.5 p-1.5 rounded-lg hover:bg-slate-50 cursor-pointer transition {{ !request('gender') ? 'bg-sky-50/60 font-bold text-sky-900' : 'text-slate-700' }}">
                                <input type="radio" name="gender" value="" {{ !request('gender') ? 'checked' : '' }} onchange="this.form.submit()" class="text-sky-600 focus:ring-sky-500">
                                <span>Semua Gender</span>
                            </label>
                            <label class="flex items-center gap-2.5 p-1.5 rounded-lg hover:bg-slate-50 cursor-pointer transition {{ request('gender') === 'male' ? 'bg-sky-50/60 font-bold text-sky-900' : 'text-slate-700' }}">
                                <input type="radio" name="gender" value="male" {{ request('gender') === 'male' ? 'checked' : '' }} onchange="this.form.submit()" class="text-sky-600 focus:ring-sky-500">
                                <span>Jantan (Male)</span>
                            </label>
                            <label class="flex items-center gap-2.5 p-1.5 rounded-lg hover:bg-slate-50 cursor-pointer transition {{ request('gender') === 'female' ? 'bg-sky-50/60 font-bold text-sky-900' : 'text-slate-700' }}">
                                <input type="radio" name="gender" value="female" {{ request('gender') === 'female' ? 'checked' : '' }} onchange="this.form.submit()" class="text-sky-600 focus:ring-sky-500">
                                <span>Betina (Female / Indukan)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Care Level -->
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Tingkat Perawatan</label>
                        <select name="care_level" onchange="this.form.submit()" class="w-full px-3 py-2 border rounded-xl bg-white text-slate-800 font-medium focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition cursor-pointer">
                            <option value="">Semua Tingkat</option>
                            <option value="beginner" {{ request('care_level') === 'beginner' ? 'selected' : '' }}>Pemula (Mudah Dirawat)</option>
                            <option value="intermediate" {{ request('care_level') === 'intermediate' ? 'selected' : '' }}>Menengah (Standar Perawatan)</option>
                            <option value="advanced" {{ request('care_level') === 'advanced' ? 'selected' : '' }}>Tinggi (Kontes / Spesimen)</option>
                        </select>
                    </div>

                    <!-- Price Filter -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px]">Rentang Harga (Rp)</label>
                            @if(request('min_price') || request('max_price'))
                                <button type="button" onclick="setQuickPrice('', '')" class="text-[10px] text-rose-600 hover:underline">Hapus</button>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <input type="number" id="min-price-input" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full px-2.5 py-1.5 border rounded-lg text-xs focus:outline-none focus:border-sky-500">
                            <input type="number" id="max-price-input" name="max_price" value="{{ request('max_price') }}" placeholder="Maks" class="w-full px-2.5 py-1.5 border rounded-lg text-xs focus:outline-none focus:border-sky-500">
                        </div>
                        <!-- Quick Price Pills -->
                        <div class="flex flex-wrap gap-1">
                            <button type="button" onclick="setQuickPrice(0, 200000)" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-sky-50 hover:text-sky-700 text-[10px] font-medium transition {{ request('max_price') == '200000' && !request('min_price') ? 'bg-sky-100 text-sky-700 font-bold' : 'text-slate-600' }}">
                                &lt; 200rb
                            </button>
                            <button type="button" onclick="setQuickPrice(200000, 350000)" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-sky-50 hover:text-sky-700 text-[10px] font-medium transition {{ request('min_price') == '200000' && request('max_price') == '350000' ? 'bg-sky-100 text-sky-700 font-bold' : 'text-slate-600' }}">
                                200rb - 350rb
                            </button>
                            <button type="button" onclick="setQuickPrice(350000, '')" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-sky-50 hover:text-sky-700 text-[10px] font-medium transition {{ request('min_price') == '350000' && !request('max_price') ? 'bg-sky-100 text-sky-700 font-bold' : 'text-slate-600' }}">
                                &gt; 350rb
                            </button>
                        </div>
                    </div>

                    <div class="pt-2 space-y-2">
                        <button type="submit" class="w-full py-2.5 rounded-xl font-bold bg-sky-600 text-white hover:bg-sky-700 shadow-md shadow-sky-500/20 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            <span>Terapkan Filter</span>
                        </button>
                        @if($hasActiveFilters)
                            <a href="{{ route('catalog.index', ['sort' => $currentSort]) }}" class="block w-full py-2 rounded-xl text-center font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                                Reset Semua Filter
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </aside>

        <!-- Product Grid (9 cols) -->
        <main class="lg:col-span-9 space-y-5">
            
            <!-- Shopee-style Sorting & Mini-Pagination Toolbar (Aquatic Theme) -->
            <div class="bg-slate-100/90 p-3 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs border border-slate-200/80">
                
                <!-- Left: Label & Sort Buttons -->
                <div class="flex items-center gap-2.5 flex-wrap text-sm">
                    <span class="text-slate-500 font-medium mr-1 select-none">Urutkan</span>

                    <!-- Terkait -->
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'terkait', 'page' => 1]) }}"
                       class="px-4 py-2 rounded-lg text-sm transition-all duration-150 {{ (!request('sort') || $currentSort === 'terkait') ? 'bg-sky-600 hover:bg-sky-700 text-white font-semibold shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-700 font-normal shadow-2xs border border-slate-200/80' }}">
                        Terkait
                    </a>

                    <!-- Terbaru -->
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'terbaru', 'page' => 1]) }}"
                       class="px-4 py-2 rounded-lg text-sm transition-all duration-150 {{ $currentSort === 'terbaru' ? 'bg-sky-600 hover:bg-sky-700 text-white font-semibold shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-700 font-normal shadow-2xs border border-slate-200/80' }}">
                        Terbaru
                    </a>

                    <!-- Terlaris -->
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'terlaris', 'page' => 1]) }}"
                       class="px-4 py-2 rounded-lg text-sm transition-all duration-150 {{ $currentSort === 'terlaris' ? 'bg-sky-600 hover:bg-sky-700 text-white font-semibold shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-700 font-normal shadow-2xs border border-slate-200/80' }}">
                        Terlaris
                    </a>

                    <!-- Dropdown Harga -->
                    <div class="relative group" id="price-dropdown-container">
                        <button type="button" 
                                id="price-dropdown-btn" 
                                onclick="togglePriceDropdown(event)"
                                class="px-4 py-2 rounded-lg text-sm transition-all duration-150 flex items-center justify-between gap-3 min-w-[130px] {{ $isPriceSort ? 'bg-white text-sky-600 font-semibold border border-sky-500 shadow-2xs' : 'bg-white hover:bg-slate-50 text-slate-700 font-normal shadow-2xs border border-slate-200/80' }}">
                            <span>{{ $priceLabel }}</span>
                            <svg class="w-3.5 h-3.5 {{ $isPriceSort ? 'text-sky-600' : 'text-slate-500' }} transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <!-- Floating Menu -->
                        <div id="price-dropdown-menu" 
                             class="hidden group-hover:block absolute left-0 top-full mt-1.5 w-56 bg-white rounded-xl shadow-lg border border-slate-200 py-1.5 z-40">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'harga_terendah', 'page' => 1]) }}" 
                               class="block px-4 py-2.5 text-sm hover:text-sky-600 hover:bg-sky-50 transition {{ $currentSort === 'harga_terendah' ? 'text-sky-600 font-bold bg-sky-50/70' : 'text-slate-700' }}">
                                Harga: Rendah ke Tinggi
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'harga_tertinggi', 'page' => 1]) }}" 
                               class="block px-4 py-2.5 text-sm hover:text-sky-600 hover:bg-sky-50 transition {{ $currentSort === 'harga_tertinggi' ? 'text-sky-600 font-bold bg-sky-50/70' : 'text-slate-700' }}">
                                Harga: Tinggi ke Rendah
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right: Mini Pagination Controls -->
                <div class="flex items-center justify-end gap-3 text-sm">
                    <div class="font-normal select-none">
                        <span class="text-sky-600 font-bold">{{ $products->currentPage() }}</span><span class="text-slate-600">/{{ $products->lastPage() }}</span>
                    </div>
                    <div class="inline-flex rounded-lg shadow-2xs overflow-hidden border border-slate-200">
                        @if($products->onFirstPage())
                            <span class="w-9 h-8 bg-slate-100 text-slate-300 flex items-center justify-center cursor-not-allowed">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="w-9 h-8 bg-white hover:bg-slate-50 text-slate-700 flex items-center justify-center transition" title="Halaman Sebelumnya">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </a>
                        @endif

                        @if($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="w-9 h-8 bg-white hover:bg-slate-50 text-slate-700 border-l border-slate-200 flex items-center justify-center transition" title="Halaman Selanjutnya">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @else
                            <span class="w-9 h-8 bg-slate-100 text-slate-300 border-l border-slate-200 flex items-center justify-center cursor-not-allowed">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Active Filter Badges/Chips -->
            @if($hasActiveFilters)
                <div class="flex items-center gap-2 flex-wrap text-xs bg-slate-50 p-3 rounded-xl border border-slate-200/80">
                    <span class="font-bold text-slate-500">Filter Aktif:</span>
                    
                    @if(request('q'))
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 font-medium">
                            <span>Cari: "{{ request('q') }}"</span>
                            <a href="{{ request()->fullUrlWithQuery(['q' => null, 'page' => 1]) }}" class="text-rose-500 hover:text-rose-700 font-bold" title="Hapus">✕</a>
                        </span>
                    @endif

                    @if(request('category'))
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-sky-50 border border-sky-200 text-sky-800 font-medium">
                            <span>Kategori: {{ $activeCategory ? $activeCategory->name : ucfirst(request('category')) }}</span>
                            <a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => 1]) }}" class="text-sky-600 hover:text-rose-600 font-bold" title="Hapus">✕</a>
                        </span>
                    @endif

                    @if(request('type'))
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-cyan-50 border border-cyan-200 text-cyan-800 font-medium">
                            <span>Sirip: {{ ucwords(str_replace('_', ' ', request('type'))) }}</span>
                            <a href="{{ request()->fullUrlWithQuery(['type' => null, 'page' => 1]) }}" class="text-cyan-600 hover:text-rose-600 font-bold" title="Hapus">✕</a>
                        </span>
                    @endif

                    @if(request('gender'))
                        @php
                            $genderLabels = ['male' => 'Jantan (Male)', 'female' => 'Betina (Female)'];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-violet-50 border border-violet-200 text-violet-800 font-medium">
                            <span>Gender: {{ $genderLabels[request('gender')] ?? request('gender') }}</span>
                            <a href="{{ request()->fullUrlWithQuery(['gender' => null, 'page' => 1]) }}" class="text-violet-600 hover:text-rose-600 font-bold" title="Hapus">✕</a>
                        </span>
                    @endif

                    @if(request('care_level'))
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 font-medium">
                            <span>Perawatan: {{ ucfirst(request('care_level')) }}</span>
                            <a href="{{ request()->fullUrlWithQuery(['care_level' => null, 'page' => 1]) }}" class="text-emerald-600 hover:text-rose-600 font-bold" title="Hapus">✕</a>
                        </span>
                    @endif

                    @if(request('min_price') || request('max_price'))
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 font-medium">
                            <span>Harga: 
                                @if(request('min_price') && request('max_price'))
                                    Rp {{ number_format((float) request('min_price'), 0, ',', '.') }} - Rp {{ number_format((float) request('max_price'), 0, ',', '.') }}
                                @elseif(request('min_price'))
                                    &gt; Rp {{ number_format((float) request('min_price'), 0, ',', '.') }}
                                @else
                                    &lt; Rp {{ number_format((float) request('max_price'), 0, ',', '.') }}
                                @endif
                            </span>
                            <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null, 'page' => 1]) }}" class="text-amber-700 hover:text-rose-600 font-bold" title="Hapus">✕</a>
                        </span>
                    @endif

                    <a href="{{ route('catalog.index', ['sort' => $currentSort]) }}" class="ml-auto text-rose-600 hover:underline font-bold text-[11px]">
                        Hapus Semua Filter
                    </a>
                </div>
            @endif

            <!-- Products Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="aquatic-card overflow-hidden group flex flex-col justify-between">
                        <div>
                            <!-- Thumbnail / Image Container -->
                            <div class="h-56 relative overflow-hidden bg-slate-100 flex items-center justify-center border-b border-slate-100">
                                @if($product->thumbnail)
                                    <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null; this.src='{{ asset('images/bettas/pk-avatargordon.jpg') }}';">
                                @else
                                    <img src="{{ asset('images/bettas/pk-avatargordon.jpg') }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @endif

                                <!-- Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                    @if($product->has_discount)
                                        <span class="bg-rose-600 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-full shadow-md">
                                            HEMAT {{ $product->discount_percentage }}%
                                        </span>
                                    @endif
                                    <span class="bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-bold px-2 py-0.5 rounded-full capitalize">
                                        {{ str_replace('_', ' ', $product->betta_type) }}
                                    </span>
                                </div>
                                <div class="absolute top-3 right-3 flex items-center gap-1.5">
                                    @if($product->gender === 'female')
                                        <span class="bg-pink-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs">
                                            Betina
                                        </span>
                                    @else
                                        <span class="bg-emerald-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-xs capitalize">
                                            {{ $product->status }}
                                        </span>
                                    @endif

                                    <form method="POST" action="{{ route('wishlist.toggle', $product) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 rounded-full bg-white/90 hover:bg-white text-slate-500 hover:text-rose-600 shadow-md transition" title="Tambah ke Wishlist">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Specimen Details -->
                            <div class="p-5 space-y-3">
                                <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                                    <span class="uppercase tracking-wider font-bold text-sky-600">{{ $product->category->name }}</span>
                                    <span>BO: {{ $product->size_cm ?? '4.5' }} cm</span>
                                </div>

                                <a href="{{ route('catalog.show', $product->slug) }}" class="block">
                                    <h3 class="font-bold text-slate-900 text-base leading-snug group-hover:text-sky-600 transition line-clamp-2">
                                        {{ $product->name }}
                                    </h3>
                                </a>

                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span class="capitalize px-2 py-0.5 rounded {{ $product->gender === 'female' ? 'bg-pink-100 text-pink-700 font-bold' : 'bg-slate-100 text-slate-700 font-semibold' }}">
                                        {{ $product->gender === 'female' ? 'Betina (Female)' : 'Jantan (Male)' }}
                                    </span>
                                    @if($product->color_pattern)
                                        <span class="truncate">{{ $product->color_pattern }}</span>
                                    @endif
                                </div>

                                <div class="pt-2">
                                    @if($product->has_discount)
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-lg font-extrabold text-slate-900">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                            <span class="text-xs text-slate-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        </div>
                                    @else
                                        <div class="text-lg font-extrabold text-slate-900">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card Buttons Footer -->
                        <div class="p-5 pt-0 grid grid-cols-2 gap-2">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="px-3 py-2 text-center rounded-xl text-xs font-bold border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                                Lihat Detail
                            </a>
                            <form method="POST" action="{{ route('cart.add', $product) }}">
                                @csrf
                                <button type="submit" class="w-full px-3 py-2 text-center rounded-xl text-xs font-bold bg-sky-600 text-white hover:bg-sky-700 shadow-xs transition">
                                    + Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200 p-8 shadow-xs">
                        <div class="w-16 h-16 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Tidak ada spesimen cupang yang cocok</h3>
                        <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                            Kriteria filter yang Anda pilih saat ini belum memiliki spesimen. Coba ubah jenis kelamin, varietas sirip, atau reset filter Anda.
                        </p>
                        <div class="mt-4 flex items-center justify-center gap-3">
                            <a href="{{ route('catalog.index', ['sort' => $currentSort]) }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 transition shadow-xs">
                                Reset Semua Filter
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="pt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </main>
    </div>
</div>

<script>
    function handleFilterCategoryChange(select) {
        const typeSelect = document.getElementById('filter-type');
        // If selecting a category that specifies a distinct body/fin type, avoid contradictory selection
        if (select.value && ['halfmoon', 'plakat', 'crowntail', 'giant', 'double-tail', 'alien-wild'].includes(select.value)) {
            if (typeSelect) {
                typeSelect.value = '';
            }
        }
        document.getElementById('filter-form').submit();
    }

    function handleFilterTypeChange(select) {
        const catSelect = document.getElementById('filter-category');
        // If selecting a fin type, clear incompatible category so user never gets zero results
        if (select.value && catSelect && catSelect.value && !['koi-nemo', 'dumbo-ear'].includes(catSelect.value)) {
            catSelect.value = '';
        }
        document.getElementById('filter-form').submit();
    }

    function setQuickPrice(min, max) {
        const minInput = document.getElementById('min-price-input');
        const maxInput = document.getElementById('max-price-input');
        minInput.value = min !== '' ? min : '';
        maxInput.value = max !== '' ? max : '';
        document.getElementById('filter-form').submit();
    }

    function clearSearch() {
        const input = document.getElementById('filter-search-input');
        if (input) {
            input.value = '';
            document.getElementById('filter-form').submit();
        }
    }

    function togglePriceDropdown(event) {
        event.stopPropagation();
        const menu = document.getElementById('price-dropdown-menu');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }

    document.addEventListener('click', function(event) {
        const container = document.getElementById('price-dropdown-container');
        const menu = document.getElementById('price-dropdown-menu');
        if (container && menu && !container.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
</script>
@endsection
