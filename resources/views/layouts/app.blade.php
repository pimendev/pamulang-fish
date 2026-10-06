<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pamulang Fish Store — Toko Online Khusus Ikan Cupang Hias (Betta Fish)' }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite Bundled Assets (Fast & Optimized) -->

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        $appTheme = \App\Models\AppearanceSetting::current();
    @endphp

    <!-- Dynamic Theme Engine / Design Tokens -->
    <style>
        :root {
            {!! $appTheme->toCssVariables() !!}
        }

        body {
            font-family: var(--font-family, 'Plus Jakarta Sans', sans-serif);
            background-color: var(--color-background, #f8fafc);
            color: var(--color-text, #0f172a);
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        .bg-primary { background-color: var(--color-primary, #0284c7); }
        .text-primary { color: var(--color-primary, #0284c7); }
        .border-primary { border-color: var(--color-primary, #0284c7); }
        .btn-primary {
            background-color: var(--color-primary, #0284c7);
            color: #ffffff;
            border-radius: var(--border-radius, 12px);
            font-size: var(--button-font-size, 14px);
            padding: 0.65rem 1.4rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
            text-decoration: none;
            border: 1px solid transparent;
        }
        .btn-primary:hover {
            opacity: 0.92;
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(2, 132, 199, 0.25);
        }
        .btn-outline {
            background-color: transparent;
            color: var(--color-primary, #0284c7);
            border: 1.5px solid var(--color-primary, #0284c7);
            border-radius: var(--border-radius, 12px);
            font-size: var(--button-font-size, 14px);
            padding: 0.65rem 1.4rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
            text-decoration: none;
        }
        .btn-outline:hover {
            background-color: var(--color-primary, #0284c7);
            color: #ffffff;
        }
        .aquatic-card {
            background: var(--color-surface, #ffffff);
            border-radius: var(--border-radius, 16px);
            border: 1px solid var(--color-border, #e2e8f0);
            transition: all 0.3s ease;
        }
        .aquatic-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.08);
            border-color: rgba(2, 132, 199, 0.4);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

    <!-- Top Announcement Bar (Dynamic from Admin Customizer) -->
    @if(($appTheme->announcement_active ?? true) && !empty($appTheme->announcement_text))
        <div class="bg-gradient-to-r from-sky-700 via-sky-600 to-cyan-600 text-white text-xs font-semibold py-2 px-4 shadow-xs">
            <div class="max-w-7xl mx-auto flex items-center justify-center gap-2 text-center flex-wrap">
                <span>{{ $appTheme->announcement_text }}</span>
                @if(!empty($appTheme->announcement_link))
                    <a href="{{ $appTheme->announcement_link }}" class="underline hover:text-cyan-200 font-bold ml-1 transition">Lihat &rarr;</a>
                @endif
            </div>
        </div>
    @endif

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                <!-- Brand Logo & Navigation Links Grouped Together -->
                <div class="flex items-center gap-5 xl:gap-8 shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 text-decoration-none group shrink-0">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-tr from-sky-600 to-cyan-400 flex items-center justify-center text-white shadow-md shadow-sky-500/20 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-lg sm:text-xl font-bold tracking-tight text-slate-900 block leading-tight">{{ $appTheme->site_title ?? 'PAMULANGFISH' }}</span>
                            <span class="text-[9px] sm:text-[10px] font-bold text-sky-600 uppercase tracking-widest block">{{ $appTheme->site_tagline ?? 'Khusus Ikan Cupang' }}</span>
                        </div>
                    </a>

                    <!-- Desktop Navigation Links (Cleanly spaced for desktop screens >= 1024px) -->
                    <nav class="hidden lg:flex items-center gap-4 xl:gap-6 2xl:gap-8 text-xs xl:text-sm font-semibold text-slate-700 whitespace-nowrap shrink-0">
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-sky-600 font-bold' : 'hover:text-sky-600' }} transition">Beranda</a>
                        <a href="{{ route('catalog.index') }}" class="{{ request()->routeIs('catalog.*') ? 'text-sky-600 font-bold' : 'hover:text-sky-600' }} transition">Katalog Cupang</a>
                        <a href="{{ route('articles.index') }}" class="{{ request()->routeIs('articles.*') ? 'text-sky-600 font-bold' : 'hover:text-sky-600' }} transition flex items-center gap-1.5">
                            <span>Panduan Cupang</span>
                            <span class="text-[10px] bg-sky-100 text-sky-700 font-bold px-1.5 py-0.5 rounded-full">Edukasi</span>
                        </a>
                        <a href="{{ route('tracking.index') }}" class="{{ request()->routeIs('tracking.*') ? 'text-sky-600 font-bold' : 'hover:text-sky-600' }} transition">Lacak Pengiriman</a>
                    </nav>
                </div>

                <!-- Action Buttons & Auth -->
                <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">
                    @php
                        $wishlistCount = auth()->check()
                            ? \App\Models\Wishlist::where('user_id', auth()->id())->count()
                            : count(session()->get('wishlist', []));
                        $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity'));
                    @endphp

                    <!-- Wishlist Icon Link -->
                    <a href="{{ route('wishlist.index') }}" class="relative p-2 rounded-xl text-slate-600 hover:text-rose-600 hover:bg-slate-100 transition" title="Wishlist Koleksi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        @if($wishlistCount > 0)
                            <span class="absolute top-1 right-1 w-4 h-4 rounded-full bg-rose-500 text-white text-[10px] font-bold flex items-center justify-center animate-pulse">
                                {{ $wishlistCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Cart Icon Link -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-xl text-slate-600 hover:text-sky-600 hover:bg-slate-100 transition" title="Keranjang Belanja">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        @if($cartCount > 0)
                            <span class="absolute top-1 right-1 w-4 h-4 rounded-full bg-sky-600 text-white text-[10px] font-bold flex items-center justify-center shadow-xs">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-bold bg-slate-900 text-white px-3 py-2 rounded-xl hover:bg-slate-800 transition shadow-xs">
                                <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                <span>Admin Panel</span>
                            </a>
                        @else
                            <a href="{{ route('orders.index') }}" class="hidden sm:inline-block text-xs font-bold text-slate-700 hover:text-sky-600 px-2 py-1">
                                Pesanan Saya
                            </a>
                        @endif
                        <span class="text-xs font-semibold text-slate-700 hidden 2xl:inline max-w-[130px] truncate" title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700 border border-rose-200 hover:border-rose-300 bg-rose-50 px-2.5 py-1.5 sm:py-2 rounded-xl transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-700 hover:text-sky-600 px-2.5 py-2 transition hidden sm:inline-block">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary text-xs hidden sm:inline-flex">
                            Daftar
                        </a>
                    @endauth

                    <!-- Mobile & Tablet Menu Hamburger Button (visible on screens < 1024px) -->
                    <button type="button" onclick="document.getElementById('mobile-drawer').classList.toggle('hidden')" class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 transition" aria-label="Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile & Tablet Drawer Navigation (for screens < 1024px) -->
        <div id="mobile-drawer" class="hidden lg:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('home') ? 'bg-sky-50 text-sky-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                🏠 Beranda
            </a>
            <a href="{{ route('catalog.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('catalog.*') ? 'bg-sky-50 text-sky-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                🐠 Katalog Spesimen Cupang
            </a>
            <a href="{{ route('articles.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('articles.*') ? 'bg-sky-50 text-sky-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                📖 Panduan & Edukasi Perawatan
            </a>
            <a href="{{ route('tracking.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('tracking.*') ? 'bg-sky-50 text-sky-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                📦 Lacak Ekspedisi Ikan Hidup
            </a>
            <a href="{{ route('wishlist.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 flex items-center justify-between">
                <span>♡ Wishlist Koleksi</span>
                @if($wishlistCount > 0)<span class="bg-rose-500 text-white text-xs px-2 py-0.5 rounded-full font-bold">{{ $wishlistCount }}</span>@endif
            </a>
            <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 flex items-center justify-between">
                <span>🛒 Keranjang Belanja</span>
                @if($cartCount > 0)<span class="bg-sky-600 text-white text-xs px-2 py-0.5 rounded-full font-bold">{{ $cartCount }}</span>@endif
            </a>

            <div class="pt-3 border-t border-slate-100">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block w-full text-center px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold mb-2">
                            ⚙️ Masuk Admin Panel
                        </a>
                    @else
                        <a href="{{ route('orders.index') }}" class="block w-full text-center px-4 py-2.5 rounded-xl bg-sky-50 text-sky-700 text-xs font-bold mb-2">
                            📋 Riwayat Pesanan Saya
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-center py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl">
                            Keluar (Logout)
                        </button>
                    </form>
                @else
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('login') }}" class="text-center py-2.5 border rounded-xl text-xs font-bold text-slate-700">Masuk</a>
                        <a href="{{ route('register') }}" class="text-center py-2.5 rounded-xl text-xs font-bold bg-sky-600 text-white">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Floating Toast Notifications (Non-disruptive & Auto-dismissing) -->
    @include('partials.toast-notifications')

    <!-- Main Dynamic Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Floating WhatsApp Customer Care Button -->
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $appTheme->whatsapp_number ?? '6281234567890') }}?text={{ urlencode('Halo Admin ' . ($appTheme->site_title ?? 'Pamulang Fish Store') . ', saya ingin tanya seputar koleksi spesimen ikan cupang.') }}" target="_blank" class="fixed bottom-6 right-6 z-40 bg-emerald-500 hover:bg-emerald-600 text-white p-3.5 rounded-full shadow-xl shadow-emerald-500/30 flex items-center gap-2 group transition-all duration-300 hover:scale-105" title="Chat WhatsApp Breeder">
        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-300 text-xs font-bold pr-1">{{ $appTheme->whatsapp_button_text ?? 'Tanya Spesimen' }}</span>
    </a>

    <!-- Modern Aquatic Footer -->
    <footer class="bg-slate-950 text-slate-400 pt-16 pb-8 border-t border-slate-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-sky-600 flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                        </div>
                        <span class="text-lg font-bold text-white tracking-tight">{{ $appTheme->site_title ?? 'PAMULANGFISH' }}</span>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">
                        {{ $appTheme->footer_about ?? 'Platform e-commerce 100% spesialis ikan cupang hias (Betta Fish) terlengkap di Pamulang dengan kualitas genetik kontes dan garansi hidup selamat sampai tujuan (D.O.A 100%).' }}
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Varian Cupang Populer</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('catalog.index', ['type' => 'halfmoon']) }}" class="hover:text-sky-400 transition">Cupang Halfmoon (HM 180°)</a></li>
                        <li><a href="{{ route('catalog.index', ['type' => 'plakat']) }}" class="hover:text-sky-400 transition">Cupang Plakat (Avatar & Samurai)</a></li>
                        <li><a href="{{ route('catalog.index', ['type' => 'crowntail']) }}" class="hover:text-sky-400 transition">Cupang Crowntail (Serit Asli Indo)</a></li>
                        <li><a href="{{ route('catalog.index', ['type' => 'giant']) }}" class="hover:text-sky-400 transition">Cupang Giant (Raksasa BO 6-7 cm)</a></li>
                        <li><a href="{{ route('catalog.index', ['type' => 'double_tail']) }}" class="hover:text-sky-400 transition">Cupang Double Tail (Cagak Ganda)</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Layanan & Panduan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('articles.index') }}" class="hover:text-sky-400 transition">Pusat Edukasi & Perawatan Cupang</a></li>
                        <li><a href="{{ route('tracking.index') }}" class="hover:text-sky-400 transition">Pelacakan Ekspedisi Ikan Hidup</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-sky-400 transition">Koleksi Spesimen Kontes (WYSIWYG)</a></li>
                        <li><a href="{{ route('wishlist.index') }}" class="hover:text-sky-400 transition">Wishlist Koleksi Impian</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Keamanan Pembelian</h4>
                    <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 text-xs space-y-2">
                        <div class="flex items-center gap-2 text-emerald-400 font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>{{ $appTheme->guarantee_box_title ?? 'Live Fish Guarantee (D.O.A)' }}</span>
                        </div>
                        <p class="text-slate-400 leading-normal">
                            {{ $appTheme->guarantee_box_text ?? 'Garansi 100% penggantian ikan jika mati saat perjalanan via ekspedisi kilat (JNE YES / TIKI ONS) dengan video unboxing utuh tanpa jeda.' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-800/80 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>{{ $appTheme->footer_copyright ?? '© 2026 Pamulang Fish Store. 100% Khusus Ikan Cupang Hias.' }}</p>
                <div class="flex gap-6">
                    <a href="{{ route('articles.index') }}" class="hover:text-slate-400">Tips Perawatan</a>
                    <a href="{{ route('tracking.index') }}" class="hover:text-slate-400">Garansi Pengiriman</a>
                    <a href="{{ route('catalog.index') }}" class="hover:text-slate-400">Katalog Toko</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Image Error Handler (Anti Broken Images) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('img').forEach(function (img) {
                img.addEventListener('error', function () {
                    if (!this.dataset.triedFallback) {
                        this.dataset.triedFallback = '1';
                        this.src = '{{ asset('images/bettas/pk-avatargordon.jpg') }}';
                    }
                });
            });
        });
    </script>
</body>
</html>
