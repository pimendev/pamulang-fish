@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium">
        <a href="{{ route('home') }}" class="hover:text-sky-600 transition">Beranda</a>
        <span>/</span>
        <a href="{{ route('catalog.index') }}" class="hover:text-sky-600 transition">Katalog Cupang</a>
        <span>/</span>
        <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="hover:text-sky-600 transition">{{ $product->category->name }}</a>
        <span>/</span>
        <span class="text-slate-800 font-bold truncate max-w-xs">{{ $product->name }}</span>
    </nav>

    <!-- Product Showcase Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Left: Image Gallery (6 cols) -->
        <div class="lg:col-span-6 space-y-4">
            <!-- Main Showcase Photo -->
            <div class="w-full aspect-square bg-slate-900 rounded-3xl overflow-hidden border border-slate-200/90 shadow-md relative group flex items-center justify-center">
                @if($product->thumbnail)
                    <img id="main-product-image" src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='{{ asset('images/bettas/pk-avatargordon.jpg') }}';">
                @else
                    <img id="main-product-image" src="{{ asset('images/bettas/pk-avatargordon.jpg') }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @endif

                <!-- Badges Overlay -->
                <div class="absolute top-4 left-4 flex flex-col gap-2">
                    <span class="bg-sky-600/90 backdrop-blur-md text-white text-xs font-extrabold px-3 py-1 rounded-full shadow-md uppercase">
                        {{ $product->betta_type }}
                    </span>
                    @if($product->has_discount)
                        <span class="bg-rose-600 text-white text-xs font-extrabold px-3 py-1 rounded-full shadow-md">
                            DISKON {{ $product->discount_percentage }}%
                        </span>
                    @endif
                </div>

                <div class="absolute top-4 right-4">
                    <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md capitalize">
                        {{ $product->status }}
                    </span>
                </div>
            </div>

            <!-- Thumbnail Selector (if multiple images) -->
            @if($product->images->count() > 1)
                <div class="flex items-center gap-3 overflow-x-auto pb-2">
                    @foreach($product->images as $img)
                        <button type="button" onclick="document.getElementById('main-product-image').src='{{ $img->image_url }}'" class="w-16 h-16 rounded-xl border-2 border-slate-200 hover:border-sky-500 overflow-hidden flex-shrink-0 transition">
                            <img src="{{ $img->image_url }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif

            <!-- WYSIWYG Guarantee Card -->
            <div class="p-5 rounded-2xl bg-sky-50/70 border border-sky-200/80 space-y-2 text-xs">
                <div class="flex items-center gap-2 font-bold text-sky-900">
                    <svg class="w-4 h-4 text-sky-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>Jaminan WYSIWYG (What You See Is What You Get)</span>
                </div>
                <p class="text-sky-800/80 leading-relaxed">
                    Setiap ikan cupang kontes memiliki keunikan sisik dan bukaan sirip tersendiri. Kami memotret dan mengirim spesimen spesifik sesuai foto yang Anda pilih (1 Ikan = 1 Stok Eksklusif).
                </p>
            </div>
        </div>

        <!-- Right: Spec Sheet & Purchase (6 cols) -->
        <div class="lg:col-span-6 space-y-6">
            <div>
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium mb-1">
                    <span class="uppercase tracking-widest font-extrabold text-sky-600">{{ $product->category->name }}</span>
                    <span class="font-mono">SKU: {{ $product->sku }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $product->name }}
                </h1>
                
                <!-- Pricing & Wishlist -->
                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-baseline gap-3">
                        @if($product->has_discount)
                            <span class="text-3xl font-extrabold text-slate-900">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            <span class="text-base text-slate-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @else
                            <span class="text-3xl font-extrabold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('wishlist.toggle', $product) }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50 transition" title="Simpan ke Wishlist">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            <span>Favorit</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Betta Physical Spec Sheet (Tabel Morfologi) -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden text-xs">
                <div class="bg-slate-50 px-4 py-2.5 border-b border-slate-200 font-bold text-slate-700 uppercase tracking-wider text-[11px]">
                    Spesifikasi Fisik Spesimen
                </div>
                <div class="grid grid-cols-2 divide-x divide-y divide-slate-100">
                    <div class="p-3">
                        <span class="text-slate-400 block text-[10px]">Tipe Sirip</span>
                        <span class="font-bold text-slate-800 capitalize">{{ $product->betta_type }}</span>
                    </div>
                    <div class="p-3">
                        <span class="text-slate-400 block text-[10px]">Jenis Kelamin</span>
                        <span class="font-bold text-slate-800 capitalize">{{ $product->gender === 'female' ? 'Betina (Female)' : 'Jantan (Male)' }}</span>
                    </div>
                    <div class="p-3">
                        <span class="text-slate-400 block text-[10px]">Ukuran Badan (Body Only)</span>
                        <span class="font-bold text-slate-800">{{ $product->size_cm ?? '4.5' }} cm</span>
                    </div>
                    <div class="p-3">
                        <span class="text-slate-400 block text-[10px]">Estimasi Umur</span>
                        <span class="font-bold text-slate-800">{{ $product->age_months ?? '3.5' }} Bulan</span>
                    </div>
                    <div class="p-3">
                        <span class="text-slate-400 block text-[10px]">Pola & Corak Warna</span>
                        <span class="font-bold text-slate-800">{{ $product->color_pattern ?? 'Mutasi Multicolor' }}</span>
                    </div>
                    <div class="p-3">
                        <span class="text-slate-400 block text-[10px]">Tingkat Perawatan</span>
                        <span class="font-bold text-slate-800 capitalize">{{ $product->care_level }}</span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="text-xs text-slate-600 space-y-2 leading-relaxed">
                <h4 class="font-bold text-slate-900 text-sm">Deskripsi Spesimen</h4>
                <p>{{ $product->description ?? 'Ikan cupang kontes pilihan dengan mental tarung aktif, bukaan ekor simetris, dan sisik mengkilap.' }}</p>
            </div>

            <!-- Care Guide Section -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-2">
                <h4 class="font-bold text-slate-800 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Panduan Perawatan & Kualitas Air Akuarium</span>
                </h4>
                <p class="text-slate-600 leading-relaxed">
                    {{ $product->care_guide ?? 'Gunakan wadah soliter kaca minimal 15x15x20 cm dengan air endapan 24 jam. Berikan ekstrak daun ketapang olahan dan pakan bergizi (jentik nyamuk / pelet spirulina) 2x sehari.' }}
                </p>
            </div>

            <!-- Purchase Form -->
            <form method="POST" action="{{ route('cart.add', $product) }}" class="space-y-4 pt-2">
                @csrf
                <div class="flex items-center gap-4">
                    <div class="w-32">
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Jumlah (Ekor)</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-full px-3 py-2 border rounded-xl font-bold text-slate-900 text-sm text-center">
                    </div>
                    <div class="flex-1">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Status Ketersediaan</span>
                        <div class="text-xs font-semibold text-slate-700 py-2">
                            Tersedia <strong class="text-emerald-600 font-extrabold">{{ $product->stock }} ekor</strong> di farm Pamulang
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-xs bg-sky-600 hover:bg-sky-700 text-white shadow-md shadow-sky-500/20 transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>+ Tambah ke Keranjang</span>
                    </button>
                    
                    <button type="submit" name="buy_now" value="1" class="w-full py-3.5 rounded-xl font-bold text-xs bg-slate-900 hover:bg-slate-800 text-white shadow-md transition flex items-center justify-center gap-2">
                        <span>Beli Sekarang &rarr;</span>
                    </button>
                </div>
            </form>

            <!-- Live Animal Shipping Guarantee Box -->
            <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50 text-xs space-y-1.5 text-emerald-950">
                <div class="font-bold flex items-center gap-2 text-emerald-800">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>Garansi D.O.A (Death on Arrival) 100% Bergaransi</span>
                </div>
                <p class="text-emerald-900/80 leading-normal">
                    Pengiriman menggunakan kantong oksigen ganda & sterofoam tebal anti guncangan. Jika ikan mati saat perjalanan, kami ganti 100% dengan melampirkan video unboxing tanpa jeda.
                </p>
            </div>
        </div>
    </div>

    <!-- Customer Reviews Section -->
    <div class="mt-16 pt-10 border-t border-slate-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 gap-4">
            <div>
                <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Ulasan Pembeli & Testimoni Spesimen</h3>
                <p class="text-xs text-slate-500 mt-0.5">Pengalaman kolektor cupang yang telah mengadopsi spesimen dari farm kami.</p>
            </div>
            @auth
                <button type="button" onclick="document.getElementById('review-form-box').classList.toggle('hidden')" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition">
                    + Tulis Ulasan
                </button>
            @else
                <a href="{{ route('login') }}" class="text-xs font-bold text-sky-600 hover:underline">
                    Login untuk memberi ulasan &rarr;
                </a>
            @endauth
        </div>

        <!-- Add Review Form (Hidden by default) -->
        @auth
            <div id="review-form-box" class="hidden mb-8 p-6 rounded-2xl bg-white border border-slate-200 shadow-xs max-w-xl">
                <form method="POST" action="{{ route('reviews.store', $product) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Rating Bintang (1 - 5) *</label>
                        <select name="rating" required class="w-full px-3 py-2 border rounded-xl text-xs bg-white">
                            <option value="5">★★★★★ (5 Bintang - Sangat Memuaskan)</option>
                            <option value="4">★★★★☆ (4 Bintang - Bagus)</option>
                            <option value="3">★★★☆☆ (3 Bintang - Cukup)</option>
                            <option value="2">★★☆☆☆ (2 Bintang - Kurang)</option>
                            <option value="1">★☆☆☆☆ (1 Bintang - Buruk)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ulasan Anda *</label>
                        <textarea name="review" rows="3" required placeholder="Ceritakan kondisi ikan saat tiba, keaktifan, dan keindahan warnanya..." class="w-full px-3 py-2 border rounded-xl text-xs focus:outline-none focus:border-sky-500"></textarea>
                    </div>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 transition">
                        Kirim Ulasan Spesimen
                    </button>
                </form>
            </div>
        @endauth

        <!-- Reviews List -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($product->reviews as $rev)
                <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-xs space-y-2 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-900">{{ $rev->user->name ?? 'Kolektor Cupang' }}</span>
                        <span class="text-amber-500 font-bold">
                            {{ str_repeat('★', $rev->rating) }}{{ str_repeat('☆', 5 - $rev->rating) }}
                        </span>
                    </div>
                    <p class="text-slate-600 leading-relaxed">{{ $rev->review }}</p>
                    <span class="text-[10px] text-slate-400 block">{{ $rev->created_at->format('d M Y') }}</span>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-slate-400 text-xs bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    Belum ada ulasan untuk spesimen ini. Jadilah kolektor pertama yang mengadopsi spesimen cupang ini!
                </div>
            @endforelse
        </div>
    </div>

    <!-- Related Products Cross-Selling -->
    @if($relatedProducts->count() > 0)
        <div class="mt-16 pt-10 border-t border-slate-200">
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight mb-6">Spesimen Cupang Serupa</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="aquatic-card overflow-hidden group flex flex-col justify-between">
                        <div>
                            <div class="h-44 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                                @if($rel->thumbnail)
                                    <img src="{{ $rel->thumbnail }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                @else
                                    <span class="text-[10px] text-slate-400">WYSIWYG Betta</span>
                                @endif
                                <span class="absolute top-2 left-2 bg-slate-900/80 text-white text-[9px] font-bold px-2 py-0.5 rounded-full capitalize">
                                    {{ $rel->betta_type }}
                                </span>
                            </div>
                            <div class="p-4 space-y-1 text-xs">
                                <span class="text-[10px] font-bold text-sky-600 uppercase">{{ $rel->category->name }}</span>
                                <h4 class="font-bold text-slate-900 truncate">{{ $rel->name }}</h4>
                                <span class="font-extrabold text-slate-900 block mt-1">Rp {{ number_format($rel->effective_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{ route('catalog.show', $rel->slug) }}" class="block w-full text-center py-2 rounded-xl text-xs font-bold border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                                Lihat Spesimen
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
