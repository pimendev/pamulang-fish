@extends('layouts.admin')

@section('content')
<style>
    /* Styling scrollbar agar konsisten, empuk & enak dilihat di kedua panel */
    #controls-scroll-box::-webkit-scrollbar,
    #preview-box::-webkit-scrollbar,
    .scroll-container::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }
    #controls-scroll-box::-webkit-scrollbar-track,
    #preview-box::-webkit-scrollbar-track,
    .scroll-container::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 9999px;
    }
    #controls-scroll-box::-webkit-scrollbar-thumb,
    #preview-box::-webkit-scrollbar-thumb,
    .scroll-container::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 9999px;
        border: 2px solid #f1f5f9;
    }
    #controls-scroll-box::-webkit-scrollbar-thumb:hover,
    #preview-box::-webkit-scrollbar-thumb:hover,
    .scroll-container::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }
    #controls-scroll-box,
    #preview-box,
    .scroll-container {
        scrollbar-width: thin;
        scrollbar-color: #94a3b8 #f1f5f9;
    }

    @media (min-width: 1024px) {
        body {
            overflow: hidden !important;
        }
        main {
            overflow: hidden !important;
            height: 100vh !important;
            max-height: 100vh !important;
            display: flex !important;
            flex-direction: column !important;
            padding: 1rem 1.5rem !important;
        }
    }
</style>

<div class="pb-2.5 mb-2.5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shrink-0">
    <div>
        <div class="flex items-center gap-2">
            <span class="px-2 py-0.5 rounded-full text-[10.5px] font-bold bg-sky-100 text-sky-800">Kustomisasi Frontend & Tema</span>
            <span class="text-[11px] text-slate-400">Dynamic UI & Content Manager</span>
        </div>
        <h1 class="text-lg font-extrabold text-slate-900 tracking-tight mt-0.5">Live Appearance & Content Customizer</h1>
        <p class="text-[11px] text-slate-500">Edit konten homepage, banner pengumuman, nomor WhatsApp, warna, dan tipografi toko secara live.</p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <form method="POST" action="{{ route('admin.appearance.reset') }}" onsubmit="return confirm('Reset tema dan konten ke pengaturan awal default?');">
            @csrf
            <button type="submit" class="px-3.5 py-1.5 rounded-xl text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition">
                Reset Default
            </button>
        </form>
        <button type="submit" form="appearance-form" class="px-4 py-1.5 rounded-xl text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 shadow-md shadow-sky-500/20 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</div>

<form id="appearance-form" method="POST" action="{{ route('admin.appearance.update') }}" class="flex-1 min-h-0 flex flex-col">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch flex-1 min-h-0">
        <!-- Controls Column (7 cols) -->
        <div class="lg:col-span-7 h-[550px] lg:h-full flex flex-col rounded-2xl border border-slate-200/90 bg-white shadow-xs overflow-hidden min-h-0">

            <!-- Panel Header: Quick Jump Anchor Bar -->
            <div class="px-4 py-2.5 bg-gradient-to-r from-slate-50 to-white border-b border-slate-200/80 flex items-center justify-between gap-3 shrink-0">
                <div class="flex items-center gap-2 shrink-0">
                    <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                    <span class="text-xs font-black uppercase tracking-wider text-slate-800">Konten & Tema</span>
                </div>
                <div class="flex items-center gap-1.5 overflow-x-auto pb-0.5 text-[11px] font-bold scroll-container">
                    <a href="#sec-brand" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 hover:text-sky-600 hover:border-sky-300 shadow-2xs transition shrink-0">1. Brand</a>
                    <a href="#sec-announcement" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 hover:text-cyan-600 hover:border-cyan-300 shadow-2xs transition shrink-0">2. Promo</a>
                    <a href="#sec-hero" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 hover:text-indigo-600 hover:border-indigo-300 shadow-2xs transition shrink-0">3. Hero</a>
                    <a href="#sec-trust" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 hover:text-emerald-600 hover:border-emerald-300 shadow-2xs transition shrink-0">4. Garansi</a>
                    <a href="#sec-colors" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 hover:text-pink-600 hover:border-pink-300 shadow-2xs transition shrink-0">5. Warna</a>
                    <a href="#sec-typography" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 hover:text-violet-600 hover:border-violet-300 shadow-2xs transition shrink-0">6. Tipografi</a>
                    <a href="#sec-footer" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700 hover:text-amber-600 hover:border-amber-300 shadow-2xs transition shrink-0">7. Footer</a>
                </div>
            </div>

            <!-- Scrollable Controls Box with Dedicated Scrollbar -->
            <div id="controls-scroll-box" class="flex-1 overflow-y-auto p-4 space-y-6 scroll-smooth scroll-container bg-slate-50/20">

                <!-- 1. Identitas & Kontak Toko -->
                <div id="sec-brand" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden transition hover:shadow-md hover:border-slate-300 scroll-mt-6">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/80 to-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center font-black text-xs border border-sky-200/80 shadow-2xs">
                            01
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">1. Identitas Brand & Kontak Toko</h3>
                            <p class="text-[11px] text-slate-500">Header navigasi brand dan floating WhatsApp</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-sky-50 text-sky-700 border border-sky-200/60">Poin 1</span>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Toko (Header Brand)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 font-bold text-xs">PF</div>
                            <input type="text" name="site_title" id="input-site-title" value="{{ old('site_title', $setting->site_title ?? 'PAMULANGFISH') }}" class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10 focus:outline-none transition shadow-2xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tagline / Sub-nama</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">🏷️</div>
                            <input type="text" name="site_tagline" id="input-site-tagline" value="{{ old('site_tagline', $setting->site_tagline ?? 'Khusus Ikan Cupang') }}" class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10 focus:outline-none transition shadow-2xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp Toko (Awali 62)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">📞</div>
                            <input type="text" name="whatsapp_number" id="input-wa-number" value="{{ old('whatsapp_number', $setting->whatsapp_number ?? '6281234567890') }}" placeholder="Contoh: 6281234567890" class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10 focus:outline-none transition shadow-2xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teks Tombol WhatsApp Melayang</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">💬</div>
                            <input type="text" name="whatsapp_button_text" id="input-wa-btn-text" value="{{ old('whatsapp_button_text', $setting->whatsapp_button_text ?? 'Tanya Spesimen') }}" class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10 focus:outline-none transition shadow-2xs">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Pita Pengumuman / Announcement Bar -->
            <div id="sec-announcement" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden transition hover:shadow-md hover:border-slate-300 scroll-mt-24">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/80 to-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-cyan-50 text-cyan-700 flex items-center justify-center font-black text-xs border border-cyan-200/80 shadow-2xs">
                            02
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">2. Pita Pengumuman Promo (Top Announcement Bar)</h3>
                            <p class="text-[11px] text-slate-500">Banner pengumuman dan penawaran di posisi paling atas</p>
                        </div>
                    </div>
                    <!-- Sleek iOS Style Toggle -->
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="announcement_active" id="input-announcement-toggle" value="1" {{ ($setting->announcement_active ?? true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-600"></div>
                        <span class="ml-2 text-xs font-bold text-slate-700">Tampilkan</span>
                    </label>
                </div>
                <div class="p-5 space-y-4 text-xs">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teks Pengumuman Promo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">🔥</div>
                            <input type="text" name="announcement_text" id="input-announcement-text" value="{{ old('announcement_text', $setting->announcement_text ?? '🔥 Garansi Hidup 100% D.O.A (Death On Arrival) • Pengiriman Cepat Packing Oksigen 24 Jam • Khusus Spesimen Cupang Asli') }}" class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-800 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none transition shadow-2xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Link Tujuan Pengumuman (Opsional)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">🔗</div>
                            <input type="text" name="announcement_link" id="input-announcement-link" value="{{ old('announcement_link', $setting->announcement_link ?? '/catalog') }}" placeholder="/catalog" class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-800 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none transition shadow-2xs">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Banner Utama Hero Beranda -->
            <div id="sec-hero" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden transition hover:shadow-md hover:border-slate-300 scroll-mt-24">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/80 to-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center font-black text-xs border border-indigo-200/80 shadow-2xs">
                            03
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">3. Banner Utama Beranda (Hero Section)</h3>
                            <p class="text-[11px] text-slate-500">Headline utama, deskripsi pengantar, dan tombol aksi (CTA)</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200/60">Poin 3</span>
                </div>
                <div class="p-5 space-y-4 text-xs">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Label Tagline Kecil Atas</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">✨</div>
                            <input type="text" name="hero_badge" id="input-hero-badge" value="{{ old('hero_badge', $setting->hero_badge ?? '100% Spesialis Koleksi Ikan Cupang Hias & Kontes') }}" class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:outline-none transition shadow-2xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Utama (Headline Besar)</label>
                        <input type="text" name="hero_title" id="input-hero-title" value="{{ old('hero_title', $setting->hero_title ?? 'Toko Spesialis Khusus Ikan Cupang Hias') }}" class="w-full px-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-extrabold text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:outline-none transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Sub-headline</label>
                        <textarea name="hero_subtitle" id="input-hero-subtitle" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 leading-relaxed focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:outline-none transition shadow-2xs">{{ old('hero_subtitle', $setting->hero_subtitle ?? 'Pusat lelang & jual beli 100% khusus jenis ikan cupang pilihan: Halfmoon, Plakat, Crowntail (Serit), Giant, Double Tail, hingga Wild Betta. Murni spesialis Betta Fish berkualitas kontes dengan garansi hidup sampai tujuan.') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                        <div class="p-3.5 bg-slate-50/60 rounded-xl border border-slate-200/80 space-y-2">
                            <span class="block text-[11px] font-bold text-slate-800 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Tombol Utama (CTA 1)
                            </span>
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-1">Teks Tombol</label>
                                <input type="text" name="hero_btn_primary_text" id="input-hero-btn-primary" value="{{ old('hero_btn_primary_text', $setting->hero_btn_primary_text ?? 'Belanja Sekarang') }}" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-900 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-1">Link Tujuan</label>
                                <input type="text" name="hero_btn_primary_link" value="{{ old('hero_btn_primary_link', $setting->hero_btn_primary_link ?? '/catalog') }}" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-mono font-bold text-slate-700 focus:border-indigo-500 focus:outline-none">
                            </div>
                        </div>
                        <div class="p-3.5 bg-slate-50/60 rounded-xl border border-slate-200/80 space-y-2">
                            <span class="block text-[11px] font-bold text-slate-800 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span> Tombol Kedua (CTA 2)
                            </span>
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-1">Teks Tombol</label>
                                <input type="text" name="hero_btn_secondary_text" id="input-hero-btn-secondary" value="{{ old('hero_btn_secondary_text', $setting->hero_btn_secondary_text ?? 'Panduan Perawatan') }}" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-900 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-1">Link Tujuan</label>
                                <input type="text" name="hero_btn_secondary_link" value="{{ old('hero_btn_secondary_link', $setting->hero_btn_secondary_link ?? '/articles') }}" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-mono font-bold text-slate-700 focus:border-indigo-500 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Poin Keunggulan / Trust Badges -->
            <div id="sec-trust" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden transition hover:shadow-md hover:border-slate-300 scroll-mt-24">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/80 to-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-xs border border-emerald-200/80 shadow-2xs">
                            04
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">4. Tiga Poin Garansi & Keunggulan (Trust Badges)</h3>
                            <p class="text-[11px] text-slate-500">Statistik kepercayaan pelanggan di bawah banner hero</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60">Poin 4</span>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-3.5 text-xs">
                    <!-- Badge 1 -->
                    <div class="p-3.5 bg-slate-50/80 rounded-xl border border-slate-200/80 space-y-2 hover:border-emerald-300 transition">
                        <div class="flex items-center justify-between">
                            <span class="font-extrabold text-slate-800 text-[11px]">Badge 1</span>
                            <span class="text-[9px] px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold">Garansi</span>
                        </div>
                        <div>
                            <label class="block text-[10px] text-slate-400 mb-1">Nilai / Statistik</label>
                            <input type="text" name="trust_badge_1_val" id="input-trust-1-val" value="{{ old('trust_badge_1_val', $setting->trust_badge_1_val ?? '100%') }}" placeholder="100%" class="w-full px-3 py-2 border rounded-lg text-xs font-black text-slate-900 bg-white focus:border-emerald-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] text-slate-400 mb-1">Label Keterangan</label>
                            <input type="text" name="trust_badge_1_lbl" id="input-trust-1-lbl" value="{{ old('trust_badge_1_lbl', $setting->trust_badge_1_lbl ?? 'Garansi Hidup') }}" placeholder="Garansi Hidup" class="w-full px-3 py-2 border rounded-lg text-xs font-semibold text-slate-700 bg-white focus:border-emerald-500 focus:outline-none">
                        </div>
                    </div>
                    <!-- Badge 2 -->
                    <div class="p-3.5 bg-slate-50/80 rounded-xl border border-slate-200/80 space-y-2 hover:border-emerald-300 transition">
                        <div class="flex items-center justify-between">
                            <span class="font-extrabold text-slate-800 text-[11px]">Badge 2</span>
                            <span class="text-[9px] px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold">Kualitas</span>
                        </div>
                        <div>
                            <label class="block text-[10px] text-slate-400 mb-1">Nilai / Statistik</label>
                            <input type="text" name="trust_badge_2_val" id="input-trust-2-val" value="{{ old('trust_badge_2_val', $setting->trust_badge_2_val ?? 'Grade A+') }}" placeholder="Grade A+" class="w-full px-3 py-2 border rounded-lg text-xs font-black text-slate-900 bg-white focus:border-emerald-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] text-slate-400 mb-1">Label Keterangan</label>
                            <input type="text" name="trust_badge_2_lbl" id="input-trust-2-lbl" value="{{ old('trust_badge_2_lbl', $setting->trust_badge_2_lbl ?? 'Genetik Pilihan') }}" placeholder="Genetik Pilihan" class="w-full px-3 py-2 border rounded-lg text-xs font-semibold text-slate-700 bg-white focus:border-emerald-500 focus:outline-none">
                        </div>
                    </div>
                    <!-- Badge 3 -->
                    <div class="p-3.5 bg-slate-50/80 rounded-xl border border-slate-200/80 space-y-2 hover:border-emerald-300 transition">
                        <div class="flex items-center justify-between">
                            <span class="font-extrabold text-slate-800 text-[11px]">Badge 3</span>
                            <span class="text-[9px] px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold">Ekspedisi</span>
                        </div>
                        <div>
                            <label class="block text-[10px] text-slate-400 mb-1">Nilai / Statistik</label>
                            <input type="text" name="trust_badge_3_val" id="input-trust-3-val" value="{{ old('trust_badge_3_val', $setting->trust_badge_3_val ?? '24 Jam') }}" placeholder="24 Jam" class="w-full px-3 py-2 border rounded-lg text-xs font-black text-slate-900 bg-white focus:border-emerald-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] text-slate-400 mb-1">Label Keterangan</label>
                            <input type="text" name="trust_badge_3_lbl" id="input-trust-3-lbl" value="{{ old('trust_badge_3_lbl', $setting->trust_badge_3_lbl ?? 'Packing Oksigen') }}" placeholder="Packing Oksigen" class="w-full px-3 py-2 border rounded-lg text-xs font-semibold text-slate-700 bg-white focus:border-emerald-500 focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Palet Warna & Mode Tampilan -->
            <div id="sec-colors" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden transition hover:shadow-md hover:border-slate-300 scroll-mt-24">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/80 to-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-pink-50 text-pink-700 flex items-center justify-center font-black text-xs border border-pink-200/80 shadow-2xs">
                            05
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">5. Mode & Palet Warna (Color Palette)</h3>
                            <p class="text-[11px] text-slate-500">Kustomisasi tema warna global toko aquatic</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-pink-50 text-pink-700 border border-pink-200/60">Poin 5</span>
                </div>

                <div class="p-5 space-y-5 text-xs">
                    <!-- Theme Mode -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2">Mode Tema Tampilan</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/50 flex flex-col items-center gap-1.5 cursor-pointer hover:border-sky-500 transition has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/60 has-[:checked]:ring-2 has-[:checked]:ring-sky-500/20 shadow-2xs">
                                <input type="radio" name="theme_mode" value="light" class="sr-only theme-mode-radio" {{ $setting->theme_mode === 'light' ? 'checked' : '' }}>
                                <span class="text-lg">☀️</span>
                                <span class="font-extrabold text-slate-900">Light Mode</span>
                                <span class="text-[9.5px] text-slate-400 text-center leading-tight">Terang bersih aquatic</span>
                            </label>
                            <label class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/50 flex flex-col items-center gap-1.5 cursor-pointer hover:border-sky-500 transition has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/60 has-[:checked]:ring-2 has-[:checked]:ring-sky-500/20 shadow-2xs">
                                <input type="radio" name="theme_mode" value="dark" class="sr-only theme-mode-radio" {{ $setting->theme_mode === 'dark' ? 'checked' : '' }}>
                                <span class="text-lg">🌙</span>
                                <span class="font-extrabold text-slate-900">Dark Mode</span>
                                <span class="text-[9.5px] text-slate-400 text-center leading-tight">Deep ocean elegan</span>
                            </label>
                            <label class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/50 flex flex-col items-center gap-1.5 cursor-pointer hover:border-sky-500 transition has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/60 has-[:checked]:ring-2 has-[:checked]:ring-sky-500/20 shadow-2xs">
                                <input type="radio" name="theme_mode" value="system" class="sr-only theme-mode-radio" {{ $setting->theme_mode === 'system' ? 'checked' : '' }}>
                                <span class="text-lg">💻</span>
                                <span class="font-extrabold text-slate-900">System Auto</span>
                                <span class="text-[9.5px] text-slate-400 text-center leading-tight">Sesuai OS browser</span>
                            </label>
                        </div>
                    </div>

                    <!-- Color Pickers Grid -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2.5">Sampel Warna Aktif</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Primary -->
                            <div class="p-3 rounded-xl bg-slate-50/60 border border-slate-200/80 hover:border-slate-300 transition flex items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="relative w-8 h-8 rounded-lg overflow-hidden shadow-2xs ring-1 ring-slate-300/80 shrink-0 cursor-pointer">
                                        <input type="color" id="picker-primary" value="{{ $setting->primary_color }}" class="absolute -inset-2 w-12 h-12 cursor-pointer border-0 p-0">
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[11px] font-bold text-slate-800 truncate">Primary Color</span>
                                        <span class="block text-[9.5px] text-slate-400 truncate">Tombol & Aksen Utama</span>
                                    </div>
                                </div>
                                <input type="text" name="primary_color" id="input-primary" value="{{ $setting->primary_color }}" class="w-24 px-2 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs text-center font-bold text-slate-800 uppercase focus:border-sky-500 focus:outline-none">
                            </div>

                            <!-- Secondary -->
                            <div class="p-3 rounded-xl bg-slate-50/60 border border-slate-200/80 hover:border-slate-300 transition flex items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="relative w-8 h-8 rounded-lg overflow-hidden shadow-2xs ring-1 ring-slate-300/80 shrink-0 cursor-pointer">
                                        <input type="color" id="picker-secondary" value="{{ $setting->secondary_color }}" class="absolute -inset-2 w-12 h-12 cursor-pointer border-0 p-0">
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[11px] font-bold text-slate-800 truncate">Secondary Color</span>
                                        <span class="block text-[9.5px] text-slate-400 truncate">Badge / Status Sukses</span>
                                    </div>
                                </div>
                                <input type="text" name="secondary_color" id="input-secondary" value="{{ $setting->secondary_color }}" class="w-24 px-2 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs text-center font-bold text-slate-800 uppercase focus:border-sky-500 focus:outline-none">
                            </div>

                            <!-- Accent -->
                            <div class="p-3 rounded-xl bg-slate-50/60 border border-slate-200/80 hover:border-slate-300 transition flex items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="relative w-8 h-8 rounded-lg overflow-hidden shadow-2xs ring-1 ring-slate-300/80 shrink-0 cursor-pointer">
                                        <input type="color" id="picker-accent" value="{{ $setting->accent_color }}" class="absolute -inset-2 w-12 h-12 cursor-pointer border-0 p-0">
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[11px] font-bold text-slate-800 truncate">Accent Color</span>
                                        <span class="block text-[9.5px] text-slate-400 truncate">Sorotan Cyan Spesimen</span>
                                    </div>
                                </div>
                                <input type="text" name="accent_color" id="input-accent" value="{{ $setting->accent_color }}" class="w-24 px-2 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs text-center font-bold text-slate-800 uppercase focus:border-sky-500 focus:outline-none">
                            </div>

                            <!-- Background -->
                            <div class="p-3 rounded-xl bg-slate-50/60 border border-slate-200/80 hover:border-slate-300 transition flex items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="relative w-8 h-8 rounded-lg overflow-hidden shadow-2xs ring-1 ring-slate-300/80 shrink-0 cursor-pointer">
                                        <input type="color" id="picker-bg" value="{{ $setting->background_color }}" class="absolute -inset-2 w-12 h-12 cursor-pointer border-0 p-0">
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[11px] font-bold text-slate-800 truncate">Background Color</span>
                                        <span class="block text-[9.5px] text-slate-400 truncate">Warna Latar Halaman</span>
                                    </div>
                                </div>
                                <input type="text" name="background_color" id="input-bg" value="{{ $setting->background_color }}" class="w-24 px-2 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs text-center font-bold text-slate-800 uppercase focus:border-sky-500 focus:outline-none">
                            </div>

                            <!-- Surface -->
                            <div class="p-3 rounded-xl bg-slate-50/60 border border-slate-200/80 hover:border-slate-300 transition flex items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="relative w-8 h-8 rounded-lg overflow-hidden shadow-2xs ring-1 ring-slate-300/80 shrink-0 cursor-pointer">
                                        <input type="color" id="picker-surface" value="{{ $setting->surface_color }}" class="absolute -inset-2 w-12 h-12 cursor-pointer border-0 p-0">
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[11px] font-bold text-slate-800 truncate">Surface / Card Color</span>
                                        <span class="block text-[9.5px] text-slate-400 truncate">Latar Kartu & Header</span>
                                    </div>
                                </div>
                                <input type="text" name="surface_color" id="input-surface" value="{{ $setting->surface_color }}" class="w-24 px-2 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs text-center font-bold text-slate-800 uppercase focus:border-sky-500 focus:outline-none">
                            </div>

                            <!-- Text Utama -->
                            <div class="p-3 rounded-xl bg-slate-50/60 border border-slate-200/80 hover:border-slate-300 transition flex items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="relative w-8 h-8 rounded-lg overflow-hidden shadow-2xs ring-1 ring-slate-300/80 shrink-0 cursor-pointer">
                                        <input type="color" id="picker-text" value="{{ $setting->text_color }}" class="absolute -inset-2 w-12 h-12 cursor-pointer border-0 p-0">
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[11px] font-bold text-slate-800 truncate">Text Color Utama</span>
                                        <span class="block text-[9.5px] text-slate-400 truncate">Warna Teks Judul & Harga</span>
                                    </div>
                                </div>
                                <input type="text" name="text_color" id="input-text" value="{{ $setting->text_color }}" class="w-24 px-2 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs text-center font-bold text-slate-800 uppercase focus:border-sky-500 focus:outline-none">
                            </div>

                            <!-- Muted Text -->
                            <div class="p-3 rounded-xl bg-slate-50/60 border border-slate-200/80 hover:border-slate-300 transition flex items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="relative w-8 h-8 rounded-lg overflow-hidden shadow-2xs ring-1 ring-slate-300/80 shrink-0 cursor-pointer">
                                        <input type="color" id="picker-muted" value="{{ $setting->muted_text_color }}" class="absolute -inset-2 w-12 h-12 cursor-pointer border-0 p-0">
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[11px] font-bold text-slate-800 truncate">Muted Text Color</span>
                                        <span class="block text-[9.5px] text-slate-400 truncate">Keterangan & Subtitle</span>
                                    </div>
                                </div>
                                <input type="text" name="muted_text_color" id="input-muted" value="{{ $setting->muted_text_color }}" class="w-24 px-2 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs text-center font-bold text-slate-800 uppercase focus:border-sky-500 focus:outline-none">
                            </div>

                            <!-- Border Color -->
                            <div class="p-3 rounded-xl bg-slate-50/60 border border-slate-200/80 hover:border-slate-300 transition flex items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="relative w-8 h-8 rounded-lg overflow-hidden shadow-2xs ring-1 ring-slate-300/80 shrink-0 cursor-pointer">
                                        <input type="color" id="picker-border" value="{{ $setting->border_color }}" class="absolute -inset-2 w-12 h-12 cursor-pointer border-0 p-0">
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[11px] font-bold text-slate-800 truncate">Border Color</span>
                                        <span class="block text-[9.5px] text-slate-400 truncate">Garis Batas Kartu & Divider</span>
                                    </div>
                                </div>
                                <input type="text" name="border_color" id="input-border" value="{{ $setting->border_color }}" class="w-24 px-2 py-1.5 bg-white border border-slate-200 rounded-lg font-mono text-xs text-center font-bold text-slate-800 uppercase focus:border-sky-500 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. Tipografi & Sudut Lengkung -->
            <div id="sec-typography" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden transition hover:shadow-md hover:border-slate-300 scroll-mt-24">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/80 to-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-violet-50 text-violet-700 flex items-center justify-center font-black text-xs border border-violet-200/80 shadow-2xs">
                            06
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">6. Tipografi & Sudut Lengkung (Typography & Styling)</h3>
                            <p class="text-[11px] text-slate-500">Keluarga font, ukuran teks, radius sudut, gaya tombol & navbar</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-violet-50 text-violet-700 border border-violet-200/60">Poin 6</span>
                </div>
                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Font Family</label>
                        <select name="font_family" id="select-font" class="w-full px-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:border-violet-500 focus:outline-none transition shadow-2xs">
                            @foreach(['Plus Jakarta Sans', 'Inter', 'Poppins', 'Roboto', 'Montserrat', 'Open Sans'] as $font)
                                <option value="{{ $font }}" {{ $setting->font_family === $font ? 'selected' : '' }}>{{ $font }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Border Radius Sudut</label>
                        <select name="border_radius" id="select-radius" class="w-full px-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:border-violet-500 focus:outline-none transition shadow-2xs">
                            @foreach(['4px' => 'Kecil (4px)', '8px' => 'Sedang (8px)', '12px' => 'Modern Rounded (12px)', '16px' => 'Ekstra Rounded (16px)', '24px' => 'Pill Style (24px)'] as $val => $lbl)
                                <option value="{{ $val }}" {{ $setting->border_radius === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ukuran Font Body</label>
                        <input type="text" name="body_font_size" id="input-body-font-size" value="{{ $setting->body_font_size }}" class="w-full px-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:border-violet-500 focus:outline-none transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ukuran Font Heading</label>
                        <input type="text" name="heading_font_size" id="input-heading-font-size" value="{{ $setting->heading_font_size }}" class="w-full px-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:border-violet-500 focus:outline-none transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ukuran Font Tombol</label>
                        <input type="text" name="button_font_size" id="input-button-font-size" value="{{ $setting->button_font_size }}" class="w-full px-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-mono font-bold text-slate-900 focus:border-violet-500 focus:outline-none transition shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Gaya Tombol (Button Style)</label>
                        <select name="button_style" id="select-button-style" class="w-full px-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:border-violet-500 focus:outline-none transition shadow-2xs">
                            @foreach(['solid' => 'Solid (Penuh)', 'outline' => 'Outline (Garis Tepi)', 'soft' => 'Soft (Lembut)'] as $bVal => $bLbl)
                                <option value="{{ $bVal }}" {{ $setting->button_style === $bVal ? 'selected' : '' }}>{{ $bLbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Gaya Navbar</label>
                        <select name="navbar_style" id="select-navbar-style" class="w-full px-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:border-violet-500 focus:outline-none transition shadow-2xs">
                            @foreach(['default' => 'Default Sticky (Header Menempel Atas)', 'minimal' => 'Minimal Clean (Tanpa Shadow)', 'floating' => 'Floating Card (Kartu Melayang Modern)'] as $nVal => $nLbl)
                                <option value="{{ $nVal }}" {{ $setting->navbar_style === $nVal ? 'selected' : '' }}>{{ $nLbl }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" name="heading_font_weight" value="{{ $setting->heading_font_weight ?? '700' }}">
                <input type="hidden" name="body_font_weight" value="{{ $setting->body_font_weight ?? '400' }}">
            </div>

            <!-- 7. Footer & Kebijakan Garansi -->
            <div id="sec-footer" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden transition hover:shadow-md hover:border-slate-300 scroll-mt-24">
                <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50/80 to-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-black text-xs border border-amber-200/80 shadow-2xs">
                            07
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 tracking-tight">7. Informasi Footer & Kotak Garansi (Footer & Guarantees)</h3>
                            <p class="text-[11px] text-slate-500">Profil singkat toko, teks garansi D.O.A, dan hak cipta</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200/60">Poin 7</span>
                </div>
                <div class="p-5 space-y-4 text-xs">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat Tentang Toko di Footer</label>
                        <textarea name="footer_about" id="input-footer-about" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 leading-relaxed focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 focus:outline-none transition shadow-2xs">{{ old('footer_about', $setting->footer_about ?? 'Platform e-commerce 100% spesialis ikan cupang hias (Betta Fish) terlengkap di Pamulang dengan kualitas genetik kontes dan garansi hidup selamat sampai tujuan (D.O.A 100%).') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Kotak Garansi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">🛡️</div>
                                <input type="text" name="guarantee_box_title" id="input-guarantee-title" value="{{ old('guarantee_box_title', $setting->guarantee_box_title ?? 'Live Fish Guarantee (D.O.A)') }}" class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 focus:outline-none transition shadow-2xs">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teks Hak Cipta (Copyright)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">©️</div>
                                <input type="text" name="footer_copyright" id="input-footer-copyright" value="{{ old('footer_copyright', $setting->footer_copyright ?? '© 2026 Pamulang Fish Store. 100% Khusus Ikan Cupang Hias.') }}" class="w-full pl-9 pr-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 focus:outline-none transition shadow-2xs">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Penjelasan Kebijakan Garansi Toko</label>
                        <textarea name="guarantee_box_text" id="input-guarantee-text" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-xl text-xs font-normal text-slate-800 leading-relaxed focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 focus:outline-none transition shadow-2xs">{{ old('guarantee_box_text', $setting->guarantee_box_text ?? 'Garansi 100% penggantian ikan jika mati saat perjalanan via ekspedisi kilat (JNE YES / TIKI ONS) dengan video unboxing utuh tanpa jeda.') }}</textarea>
                    </div>
                </div>
            </div>

            </div>
            <!-- /#controls-scroll-box -->

            <!-- Left Panel Footer -->
            <div class="px-4 py-2.5 bg-slate-50 border-t border-slate-200/80 flex items-center justify-between text-[11px] text-slate-500 shrink-0">
                <span class="font-bold text-slate-700">7 Poin Kustomisasi</span>
                <span class="text-[10px] text-slate-400 font-mono">Tersinkronisasi Real-Time</span>
            </div>
        </div>
        <!-- /.lg:col-span-7 -->

        <!-- Live Preview Column (5 cols) -->
        <div class="lg:col-span-5 h-[550px] lg:h-full flex flex-col rounded-2xl border border-slate-300/80 bg-slate-900 shadow-2xl shadow-slate-900/15 overflow-hidden ring-1 ring-slate-950/5 min-h-0">

            <!-- Browser Chrome Header Bar (matching left panel header height) -->
            <div class="px-4 py-2.5 bg-slate-900 border-b border-slate-800 flex items-center justify-between gap-2 shrink-0">
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500/90 inline-block"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500/90 inline-block"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500/90 inline-block"></span>
                </div>
                <div class="flex-1 max-w-[210px] bg-slate-800/90 rounded-md px-2.5 py-1 flex items-center justify-center gap-1.5 text-[10px] font-mono text-slate-300 border border-slate-700/60 shadow-inner">
                    <svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                    <span class="truncate">pamulangfish.id</span>
                </div>
                <div class="flex items-center gap-1 text-[10px] text-slate-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-ping"></span>
                    <span class="text-[9px] font-mono text-cyan-400 font-bold hidden sm:inline">LIVE</span>
                </div>
            </div>

            <!-- Storefront Canvas (Seamless Real Website Flow) -->
            <div class="relative flex-1 min-h-0 overflow-hidden flex flex-col">
                <div id="preview-box" class="flex-1 overflow-y-auto transition-all duration-300 text-left scroll-container" style="background-color: {{ $setting->background_color }}; font-family: '{{ $setting->font_family }}', sans-serif;">

                            <!-- [POIN 2] Top Announcement Bar -->
                            <div id="preview-announcement" class="py-2 px-3 text-[10.5px] font-semibold text-center text-white transition-all flex items-center justify-center gap-1.5 shadow-xs" style="background-color: {{ $setting->primary_color }}; display: {{ ($setting->announcement_active ?? true) ? 'flex' : 'none' }};">
                                <span id="preview-announcement-text" class="line-clamp-1">{{ $setting->announcement_text ?? '🔥 Garansi Hidup 100% D.O.A (Death On Arrival) • Pengiriman Cepat Packing Oksigen 24 Jam • Khusus Spesimen Cupang Asli' }}</span>
                                <span id="preview-announcement-link" class="underline font-bold text-cyan-200 shrink-0 ml-1">({{ $setting->announcement_link ?? '/catalog' }}) &rarr;</span>
                            </div>

                            <!-- [POIN 1 & 6] Header Navbar -->
                            <div id="preview-card" class="p-3.5 border-b transition-all flex items-center justify-between" style="background-color: {{ $setting->surface_color }}; border-color: {{ $setting->border_color }};">
                                <div class="flex items-center gap-2.5">
                                    <div id="preview-logo-bg" class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-black text-xs shadow-xs" style="background-color: {{ $setting->primary_color }}; border-radius: calc({{ $setting->border_radius }} * 0.7);">
                                        PF
                                    </div>
                                    <div>
                                        <span id="preview-title" class="font-black text-xs block leading-tight tracking-tight" style="color: {{ $setting->text_color }};">{{ $setting->site_title ?? 'PAMULANGFISH' }}</span>
                                        <span id="preview-tagline" class="text-[9px] uppercase tracking-wider font-extrabold block" style="color: {{ $setting->primary_color }};">{{ $setting->site_tagline ?? 'Khusus Ikan Cupang' }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-medium hidden sm:inline" style="color: {{ $setting->muted_text_color }};">Katalog</span>
                                    <span id="preview-badge" class="px-2.5 py-0.5 rounded-full text-[9px] font-bold text-white shadow-2xs" style="background-color: {{ $setting->secondary_color }};">
                                        LIVE FISH
                                    </span>
                                </div>
                            </div>

                            <!-- [POIN 3] Hero Section Banner -->
                            <div id="preview-hero-box" class="p-4 bg-gradient-to-br from-slate-950 via-sky-950 to-slate-900 text-white space-y-2.5 relative overflow-hidden transition-all">
                                <span id="preview-hero-badge" class="inline-block px-2.5 py-0.5 rounded-full text-[9px] font-bold bg-sky-500/20 text-sky-300 border border-sky-400/30">
                                    {{ $setting->hero_badge ?? '100% Spesialis Koleksi Ikan Cupang Hias & Kontes' }}
                                </span>
                                <h3 id="preview-hero-title" class="font-extrabold leading-snug tracking-tight" style="font-size: {{ $setting->heading_font_size ? intval($setting->heading_font_size) * 0.52 . 'px' : '16px' }};">
                                    {{ $setting->hero_title ?? 'Toko Spesialis Khusus Ikan Cupang Hias' }}
                                </h3>
                                <p id="preview-hero-subtitle" class="text-slate-300 text-[10.5px] leading-relaxed line-clamp-3" style="font-size: {{ $setting->body_font_size ? intval($setting->body_font_size) * 0.72 . 'px' : '11px' }};">
                                    {{ $setting->hero_subtitle ?? 'Pusat lelang & jual beli 100% khusus jenis ikan cupang pilihan: Halfmoon, Plakat, Crowntail (Serit), Giant, Double Tail, hingga Wild Betta. Murni spesialis Betta Fish berkualitas kontes dengan garansi hidup sampai tujuan.' }}
                                </p>
                                <div class="flex items-center gap-2 pt-1">
                                    <span id="preview-hero-btn" class="px-3.5 py-1.5 font-bold text-white shadow-sm transition-all inline-block" style="background-color: {{ $setting->primary_color }}; border-radius: {{ $setting->border_radius }}; font-size: {{ $setting->button_font_size ?? '12px' }};">
                                        {{ $setting->hero_btn_primary_text ?? 'Belanja Sekarang' }}
                                    </span>
                                    <span id="preview-hero-btn2" class="px-3.5 py-1.5 font-semibold text-slate-200 border border-slate-700 bg-slate-800/80 transition-all inline-block" style="border-radius: {{ $setting->border_radius }}; font-size: {{ $setting->button_font_size ?? '12px' }};">
                                        {{ $setting->hero_btn_secondary_text ?? 'Panduan Perawatan' }}
                                    </span>
                                </div>
                            </div>

                            <!-- [POIN 4] Tiga Poin Garansi & Keunggulan (Trust Badges Bar) -->
                            <div class="p-3 border-b grid grid-cols-3 gap-2 text-center transition-all" style="background-color: {{ $setting->surface_color }}; border-color: {{ $setting->border_color }};">
                                <div id="preview-trust-card-1" class="p-2 rounded-xl border text-center transition-all shadow-2xs" style="background-color: {{ $setting->surface_color }}; border-color: {{ $setting->border_color }}; border-radius: calc({{ $setting->border_radius }} * 0.75);">
                                    <span id="preview-trust-1-val" class="block font-black text-xs" style="color: {{ $setting->primary_color }};">{{ $setting->trust_badge_1_val ?? '100%' }}</span>
                                    <span id="preview-trust-1-lbl" class="block text-[9px] font-semibold" style="color: {{ $setting->muted_text_color }};">{{ $setting->trust_badge_1_lbl ?? 'Garansi Hidup' }}</span>
                                </div>
                                <div id="preview-trust-card-2" class="p-2 rounded-xl border text-center transition-all shadow-2xs" style="background-color: {{ $setting->surface_color }}; border-color: {{ $setting->border_color }}; border-radius: calc({{ $setting->border_radius }} * 0.75);">
                                    <span id="preview-trust-2-val" class="block font-black text-xs" style="color: {{ $setting->primary_color }};">{{ $setting->trust_badge_2_val ?? 'Grade A+' }}</span>
                                    <span id="preview-trust-2-lbl" class="block text-[9px] font-semibold" style="color: {{ $setting->muted_text_color }};">{{ $setting->trust_badge_2_lbl ?? 'Genetik Pilihan' }}</span>
                                </div>
                                <div id="preview-trust-card-3" class="p-2 rounded-xl border text-center transition-all shadow-2xs" style="background-color: {{ $setting->surface_color }}; border-color: {{ $setting->border_color }}; border-radius: calc({{ $setting->border_radius }} * 0.75);">
                                    <span id="preview-trust-3-val" class="block font-black text-xs" style="color: {{ $setting->primary_color }};">{{ $setting->trust_badge_3_val ?? '24 Jam' }}</span>
                                    <span id="preview-trust-3-lbl" class="block text-[9px] font-semibold" style="color: {{ $setting->muted_text_color }};">{{ $setting->trust_badge_3_lbl ?? 'Packing Oksigen' }}</span>
                                </div>
                            </div>

                            <!-- [POIN 5 & 6] Featured Betta Showcase (Demo Warna & Gaya Tombol) -->
                            <div class="p-3.5 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black uppercase tracking-wider" style="color: {{ $setting->text_color }};">Spesimen Cupang Pilihan</span>
                                    <span class="text-[9px] font-bold" style="color: {{ $setting->accent_color }};">Lihat Semua &rarr;</span>
                                </div>
                                <div id="preview-product-card" class="rounded-xl border overflow-hidden shadow-xs transition-all" style="background-color: {{ $setting->surface_color }}; border-color: {{ $setting->border_color }}; border-radius: {{ $setting->border_radius }};">
                                    <div class="relative h-32 bg-slate-900 overflow-hidden">
                                        <img src="{{ asset('images/bettas/hm-superred.jpg') }}" alt="Betta Specimen" class="w-full h-full object-cover">
                                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-wider bg-slate-950/80 text-cyan-300 backdrop-blur-xs">
                                            Spesimen Asli (WYSIWYG)
                                        </span>
                                    </div>
                                    <div class="p-3 space-y-1.5">
                                        <span id="preview-category-badge" class="text-[9px] uppercase font-black tracking-wider block" style="color: {{ $setting->accent_color }};">Cupang Halfmoon</span>
                                        <h4 id="preview-product-name" class="font-bold text-xs" style="color: {{ $setting->text_color }};">Halfmoon Super Red Bukaan 180°</h4>
                                        <p id="preview-muted-text" class="text-[9.5px] line-clamp-1" style="color: {{ $setting->muted_text_color }};">Ekor 180° sempurna mekar merah pekat tanpa noda.</p>
                                        <div class="flex items-center justify-between pt-2 border-t" style="border-color: {{ $setting->border_color }};">
                                            <div>
                                                <span class="text-[8.5px] block font-medium" style="color: {{ $setting->muted_text_color }};">Harga Spesimen</span>
                                                <span id="preview-price" class="font-extrabold text-xs" style="color: {{ $setting->text_color }};">Rp 250.000</span>
                                            </div>
                                            <button type="button" id="preview-btn" class="px-3.5 py-1.5 font-bold transition shadow-xs" style="background-color: {{ $setting->primary_color }}; color: #ffffff; border-radius: {{ $setting->border_radius }}; font-size: {{ $setting->button_font_size ?? '12px' }};">
                                                + Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- [POIN 7] Footer & Kotak Garansi -->
                            <div id="preview-footer-box" class="p-4 bg-slate-950 text-slate-300 space-y-3 border-t border-slate-900 transition-all">
                                <div>
                                    <span class="text-[9px] uppercase tracking-wider text-sky-400 font-extrabold block">Tentang Pamulang Fish</span>
                                    <p id="preview-footer-about" class="text-[9.5px] text-slate-400 leading-relaxed mt-0.5">
                                        {{ $setting->footer_about ?? 'Platform e-commerce 100% spesialis ikan cupang hias (Betta Fish) terlengkap di Pamulang dengan kualitas genetik kontes dan garansi hidup selamat sampai tujuan (D.O.A 100%).' }}
                                    </p>
                                </div>

                                <div id="preview-guarantee-card" class="p-2.5 rounded-lg bg-slate-900/90 border border-slate-800 space-y-1">
                                    <div class="flex items-center gap-1.5 text-emerald-400 font-bold text-[10px]">
                                        <span class="text-xs">🛡️</span>
                                        <span id="preview-guarantee-title">{{ $setting->guarantee_box_title ?? 'Live Fish Guarantee (D.O.A)' }}</span>
                                    </div>
                                    <p id="preview-guarantee-text" class="text-[8.5px] text-slate-400 leading-relaxed">
                                        {{ $setting->guarantee_box_text ?? 'Garansi 100% penggantian ikan jika mati saat perjalanan via ekspedisi kilat (JNE YES / TIKI ONS) dengan video unboxing utuh tanpa jeda.' }}
                                    </p>
                                </div>

                                <div class="border-t border-slate-900 pt-2 text-center">
                                    <span id="preview-footer-copyright" class="text-[8.5px] text-slate-500 block">
                                        {{ $setting->footer_copyright ?? '© 2026 Pamulang Fish Store. 100% Khusus Ikan Cupang Hias.' }}
                                    </span>
                                </div>
                            </div>

                        </div>

                        <!-- [POIN 1] Floating WhatsApp Widget (Pill anchored at bottom right) -->
                        <div class="absolute bottom-3 right-3 z-30 flex items-center gap-1.5 shadow-lg shadow-emerald-950/40">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-bold transition-all shadow-md cursor-pointer hover:scale-105">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                <span id="preview-wa-pill">{{ $setting->whatsapp_button_text ?? 'Tanya Spesimen' }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.relative.flex-1 -->

                    <!-- Bottom Status Bar: WA Store Number & Active Color Palette Dots -->
                    <div id="preview-swatches-box" class="px-4 py-2.5 bg-slate-900 border-t border-slate-800 flex items-center justify-between text-[10px] text-slate-400 shrink-0">
                        <div class="flex items-center gap-1.5">
                            <span class="text-slate-500 font-medium">WA Toko:</span>
                            <span id="preview-wa-number" class="font-mono font-bold text-slate-200">{{ $setting->whatsapp_number ?? '6281234567890' }}</span>
                        </div>
                        <!-- [POIN 5] Live Palette Dots Strip -->
                        <div class="flex items-center gap-1.5" title="Palet Warna Aktif (Primary, Secondary, Accent, BG, Surface, Text, Muted, Border)">
                            <div id="swatch-primary" class="w-3.5 h-3.5 rounded-full border border-white/20 shadow-xs" style="background-color: {{ $setting->primary_color }};"></div>
                            <div id="swatch-secondary" class="w-3.5 h-3.5 rounded-full border border-white/20 shadow-xs" style="background-color: {{ $setting->secondary_color }};"></div>
                            <div id="swatch-accent" class="w-3.5 h-3.5 rounded-full border border-white/20 shadow-xs" style="background-color: {{ $setting->accent_color }};"></div>
                            <div id="swatch-bg" class="w-3.5 h-3.5 rounded-full border border-white/20 shadow-xs" style="background-color: {{ $setting->background_color }};"></div>
                            <div id="swatch-surface" class="w-3.5 h-3.5 rounded-full border border-white/20 shadow-xs" style="background-color: {{ $setting->surface_color }};"></div>
                            <div id="swatch-text" class="w-3.5 h-3.5 rounded-full border border-white/20 shadow-xs" style="background-color: {{ $setting->text_color }};"></div>
                            <div id="swatch-muted" class="w-3.5 h-3.5 rounded-full border border-white/20 shadow-xs" style="background-color: {{ $setting->muted_text_color }};"></div>
                            <div id="swatch-border" class="w-3.5 h-3.5 rounded-full border border-white/20 shadow-xs" style="background-color: {{ $setting->border_color }};"></div>
                        </div>
                    </div>
                </div>
                <!-- /.lg:col-span-5 -->
            </div>
        </form>

@push('scripts')
<script>
    // Live Color Pickers Sync
    const bindPicker = (pickerId, inputId, swatchId, hexId, callback) => {
        const picker = document.getElementById(pickerId);
        const input = document.getElementById(inputId);
        const swatch = swatchId ? document.getElementById(swatchId) : null;
        const hex = hexId ? document.getElementById(hexId) : null;
        if (!picker || !input) return;

        const updateAll = (val) => {
            if (swatch) swatch.style.backgroundColor = val;
            if (hex) hex.textContent = val;
            if (callback) callback(val);
        };

        picker.addEventListener('input', (e) => {
            input.value = e.target.value;
            updateAll(e.target.value);
        });

        input.addEventListener('input', (e) => {
            if (/^#[0-9A-F]{6}$/i.test(e.target.value)) {
                picker.value = e.target.value;
            }
            updateAll(e.target.value);
        });
    };

    bindPicker('picker-primary', 'input-primary', 'swatch-primary', 'swatch-primary-hex', (val) => {
        document.getElementById('preview-logo-bg').style.backgroundColor = val;
        document.getElementById('preview-btn').style.backgroundColor = val;
        document.getElementById('preview-hero-btn').style.backgroundColor = val;
        document.getElementById('preview-announcement').style.backgroundColor = val;
        document.getElementById('preview-tagline').style.color = val;
        document.getElementById('preview-trust-1-val').style.color = val;
        document.getElementById('preview-trust-2-val').style.color = val;
        document.getElementById('preview-trust-3-val').style.color = val;
    });

    bindPicker('picker-secondary', 'input-secondary', 'swatch-secondary', 'swatch-secondary-hex', (val) => {
        document.getElementById('preview-badge').style.backgroundColor = val;
    });

    bindPicker('picker-accent', 'input-accent', 'swatch-accent', 'swatch-accent-hex', (val) => {
        document.getElementById('preview-category-badge').style.color = val;
    });

    bindPicker('picker-bg', 'input-bg', 'swatch-bg', 'swatch-bg-hex', (val) => {
        document.getElementById('preview-box').style.backgroundColor = val;
    });

    bindPicker('picker-surface', 'input-surface', 'swatch-surface', 'swatch-surface-hex', (val) => {
        const targets = [
            document.getElementById('preview-card'),
            document.getElementById('preview-product-card'),
            document.getElementById('preview-swatches-box'),
            document.getElementById('preview-trust-card-1'),
            document.getElementById('preview-trust-card-2'),
            document.getElementById('preview-trust-card-3'),
        ];
        targets.forEach(el => { if (el) el.style.backgroundColor = val; });
    });

    bindPicker('picker-text', 'input-text', 'swatch-text', 'swatch-text-hex', (val) => {
        document.getElementById('preview-title').style.color = val;
        document.getElementById('preview-product-name').style.color = val;
        document.getElementById('preview-price').style.color = val;
        document.getElementById('preview-wa-number').style.color = val;
    });

    bindPicker('picker-muted', 'input-muted', 'swatch-muted', 'swatch-muted-hex', (val) => {
        document.getElementById('preview-muted-text').style.color = val;
        document.getElementById('preview-trust-1-lbl').style.color = val;
        document.getElementById('preview-trust-2-lbl').style.color = val;
        document.getElementById('preview-trust-3-lbl').style.color = val;
    });

    bindPicker('picker-border', 'input-border', 'swatch-border', 'swatch-border-hex', (val) => {
        document.getElementById('preview-box').style.borderColor = val;
        const targets = [
            document.getElementById('preview-card'),
            document.getElementById('preview-product-card'),
            document.getElementById('preview-swatches-box'),
            document.getElementById('preview-trust-card-1'),
            document.getElementById('preview-trust-card-2'),
            document.getElementById('preview-trust-card-3'),
        ];
        targets.forEach(el => { if (el) el.style.borderColor = val; });
    });

    // Font family change
    document.getElementById('select-font')?.addEventListener('change', (e) => {
        document.getElementById('preview-box').style.fontFamily = `'${e.target.value}', sans-serif`;
    });

    // Border radius change
    document.getElementById('select-radius')?.addEventListener('change', (e) => {
        const rad = e.target.value;
        const radiusElements = [
            document.getElementById('preview-card'),
            document.getElementById('preview-hero-box'),
            document.getElementById('preview-product-card'),
            document.getElementById('preview-swatches-box'),
            document.getElementById('preview-footer-box'),
            document.getElementById('preview-btn'),
            document.getElementById('preview-hero-btn'),
            document.getElementById('preview-hero-btn2'),
            document.getElementById('preview-trust-card-1'),
            document.getElementById('preview-trust-card-2'),
            document.getElementById('preview-trust-card-3'),
        ];
        radiusElements.forEach(el => { if (el) el.style.borderRadius = rad; });
    });

    // Font size changes
    document.getElementById('input-heading-font-size')?.addEventListener('input', (e) => {
        const val = parseInt(e.target.value);
        if (val) {
            document.getElementById('preview-hero-title').style.fontSize = Math.round(val * 0.55) + 'px';
        }
    });

    document.getElementById('input-body-font-size')?.addEventListener('input', (e) => {
        const val = parseInt(e.target.value);
        if (val) {
            document.getElementById('preview-hero-subtitle').style.fontSize = Math.round(val * 0.75) + 'px';
            const mutedText = document.getElementById('preview-muted-text');
            if (mutedText) mutedText.style.fontSize = Math.round(val * 0.70) + 'px';
        }
    });

    document.getElementById('input-button-font-size')?.addEventListener('input', (e) => {
        const val = e.target.value;
        if (val) {
            document.getElementById('preview-btn').style.fontSize = val;
            document.getElementById('preview-hero-btn').style.fontSize = val;
            document.getElementById('preview-hero-btn2').style.fontSize = val;
        }
    });

    // Button Style Change
    document.getElementById('select-button-style')?.addEventListener('change', (e) => {
        const btn = document.getElementById('preview-btn');
        const heroBtn = document.getElementById('preview-hero-btn');
        const primaryColor = document.getElementById('picker-primary').value;
        if (!btn) return;
        if (e.target.value === 'outline') {
            btn.style.backgroundColor = 'transparent';
            btn.style.color = primaryColor;
            btn.style.border = `1.5px solid ${primaryColor}`;
            if (heroBtn) {
                heroBtn.style.backgroundColor = 'transparent';
                heroBtn.style.color = '#ffffff';
                heroBtn.style.border = '1.5px solid #ffffff';
            }
        } else if (e.target.value === 'soft') {
            btn.style.backgroundColor = primaryColor + '25';
            btn.style.color = primaryColor;
            btn.style.border = 'none';
            if (heroBtn) {
                heroBtn.style.backgroundColor = 'rgba(255, 255, 255, 0.15)';
                heroBtn.style.color = '#ffffff';
                heroBtn.style.border = 'none';
            }
        } else {
            btn.style.backgroundColor = primaryColor;
            btn.style.color = '#ffffff';
            btn.style.border = 'none';
            if (heroBtn) {
                heroBtn.style.backgroundColor = primaryColor;
                heroBtn.style.color = '#ffffff';
                heroBtn.style.border = 'none';
            }
        }
    });

    // Navbar Style Change
    document.getElementById('select-navbar-style')?.addEventListener('change', (e) => {
        const card = document.getElementById('preview-card');
        const label = document.getElementById('preview-navbar-style-lbl');
        if (label) label.textContent = 'Gaya: ' + e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
        if (!card) return;
        if (e.target.value === 'minimal') {
            card.style.boxShadow = 'none';
            card.style.borderStyle = 'none';
        } else if (e.target.value === 'floating') {
            card.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
            card.style.borderStyle = 'solid';
        } else {
            card.style.boxShadow = '0 1px 2px 0 rgba(0, 0, 0, 0.05)';
            card.style.borderStyle = 'solid';
        }
    });

    // Theme Mode Radio Sync
    document.querySelectorAll('.theme-mode-radio').forEach(radio => {
        radio.addEventListener('change', (e) => {
            const previewBox = document.getElementById('preview-box');
            const modeLbl = document.getElementById('preview-theme-mode-lbl');
            if (modeLbl) modeLbl.textContent = 'Mode: ' + e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
            if (e.target.value === 'dark') {
                previewBox.style.backgroundColor = '#0f172a';
                previewBox.style.borderColor = '#1e293b';
            } else if (e.target.value === 'light') {
                previewBox.style.backgroundColor = '#f8fafc';
                previewBox.style.borderColor = '#e2e8f0';
            }
        });
    });

    // Live Text Inputs Sync
    const bindLiveText = (inputId, targetId) => {
        const input = document.getElementById(inputId);
        const target = document.getElementById(targetId);
        if (!input || !target) return;
        input.addEventListener('input', (e) => {
            target.textContent = e.target.value || '';
        });
    };

    // Poin 1
    bindLiveText('input-site-title', 'preview-title');
    bindLiveText('input-site-tagline', 'preview-tagline');
    bindLiveText('input-wa-number', 'preview-wa-number');
    bindLiveText('input-wa-btn-text', 'preview-wa-pill');

    // Poin 2
    bindLiveText('input-announcement-text', 'preview-announcement-text');
    document.getElementById('input-announcement-link')?.addEventListener('input', (e) => {
        const el = document.getElementById('preview-announcement-link');
        if (el) el.textContent = e.target.value ? `(${e.target.value}) →` : 'Lihat →';
    });
    document.getElementById('input-announcement-toggle')?.addEventListener('change', (e) => {
        document.getElementById('preview-announcement').style.display = e.target.checked ? 'flex' : 'none';
        const st = document.getElementById('preview-announcement-status');
        if (st) st.textContent = e.target.checked ? 'Status: Aktif' : 'Status: Nonaktif';
    });

    // Poin 3
    bindLiveText('input-hero-badge', 'preview-hero-badge');
    bindLiveText('input-hero-title', 'preview-hero-title');
    bindLiveText('input-hero-subtitle', 'preview-hero-subtitle');
    bindLiveText('input-hero-btn-primary', 'preview-hero-btn');
    bindLiveText('input-hero-btn-secondary', 'preview-hero-btn2');

    // Poin 4
    bindLiveText('input-trust-1-val', 'preview-trust-1-val');
    bindLiveText('input-trust-1-lbl', 'preview-trust-1-lbl');
    bindLiveText('input-trust-2-val', 'preview-trust-2-val');
    bindLiveText('input-trust-2-lbl', 'preview-trust-2-lbl');
    bindLiveText('input-trust-3-val', 'preview-trust-3-val');
    bindLiveText('input-trust-3-lbl', 'preview-trust-3-lbl');

    // Poin 7
    bindLiveText('input-footer-about', 'preview-footer-about');
    bindLiveText('input-guarantee-title', 'preview-guarantee-title');
    bindLiveText('input-guarantee-text', 'preview-guarantee-text');
    bindLiveText('input-footer-copyright', 'preview-footer-copyright');

    // Smooth scroll for Quick Jump Tabs inside #controls-scroll-box
    document.querySelectorAll('a[href^="#sec-"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetEl = document.getElementById(targetId);
            const container = document.getElementById('controls-scroll-box');
            if (targetEl && container) {
                const targetRect = targetEl.getBoundingClientRect();
                const containerRect = container.getBoundingClientRect();
                const currentScrollTop = container.scrollTop;
                const offset = targetRect.top - containerRect.top + currentScrollTop;
                container.scrollTo({ top: Math.max(0, offset - 12), behavior: 'smooth' });
            }
        });
    });
</script>
@endpush
@endsection
