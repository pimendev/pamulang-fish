<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppearanceSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppearanceController extends Controller
{
    public function index(): View
    {
        $setting = AppearanceSetting::current();

        return view('admin.appearance.index', compact('setting'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'theme_mode' => 'required|in:light,dark,system',
            'primary_color' => 'required|string|max:20',
            'secondary_color' => 'required|string|max:20',
            'accent_color' => 'required|string|max:20',
            'background_color' => 'required|string|max:20',
            'surface_color' => 'required|string|max:20',
            'text_color' => 'required|string|max:20',
            'muted_text_color' => 'required|string|max:20',
            'border_color' => 'required|string|max:20',
            'font_family' => 'required|string|max:50',
            'body_font_size' => 'required|string|max:10',
            'heading_font_size' => 'required|string|max:10',
            'button_font_size' => 'required|string|max:10',
            'heading_font_weight' => 'required|string|max:10',
            'body_font_weight' => 'required|string|max:10',
            'border_radius' => 'required|string|max:10',
            'button_style' => 'required|in:solid,outline,ghost,soft,gradient',
            'navbar_style' => 'required|in:default,minimal,transparent,floating',
            'site_title' => 'nullable|string|max:100',
            'site_tagline' => 'nullable|string|max:150',
            'whatsapp_number' => 'nullable|string|max:30',
            'whatsapp_button_text' => 'nullable|string|max:50',
            'announcement_active' => 'nullable',
            'announcement_text' => 'nullable|string|max:500',
            'announcement_link' => 'nullable|string|max:255',
            'hero_badge' => 'nullable|string|max:150',
            'hero_title' => 'nullable|string|max:200',
            'hero_subtitle' => 'nullable|string|max:1000',
            'hero_btn_primary_text' => 'nullable|string|max:50',
            'hero_btn_primary_link' => 'nullable|string|max:255',
            'hero_btn_secondary_text' => 'nullable|string|max:50',
            'hero_btn_secondary_link' => 'nullable|string|max:255',
            'trust_badge_1_val' => 'nullable|string|max:50',
            'trust_badge_1_lbl' => 'nullable|string|max:100',
            'trust_badge_2_val' => 'nullable|string|max:50',
            'trust_badge_2_lbl' => 'nullable|string|max:100',
            'trust_badge_3_val' => 'nullable|string|max:50',
            'trust_badge_3_lbl' => 'nullable|string|max:100',
            'footer_about' => 'nullable|string|max:1000',
            'footer_copyright' => 'nullable|string|max:255',
            'guarantee_box_title' => 'nullable|string|max:150',
            'guarantee_box_text' => 'nullable|string|max:1000',
        ]);

        $validated['announcement_active'] = $request->boolean('announcement_active');

        $setting = AppearanceSetting::current();
        $setting->update($validated);

        return redirect()->route('admin.appearance.index')->with('success', 'Pengaturan tema, konten, & tampilan live berhasil diperbarui!');
    }

    public function reset(): RedirectResponse
    {
        $setting = AppearanceSetting::current();
        $setting->update([
            'theme_mode' => 'light',
            'primary_color' => '#0284c7',
            'secondary_color' => '#059669',
            'accent_color' => '#06b6d4',
            'background_color' => '#f8fafc',
            'surface_color' => '#ffffff',
            'text_color' => '#0f172a',
            'muted_text_color' => '#64748b',
            'border_color' => '#e2e8f0',
            'font_family' => 'Plus Jakarta Sans',
            'body_font_size' => '15px',
            'heading_font_size' => '30px',
            'button_font_size' => '14px',
            'heading_font_weight' => '700',
            'body_font_weight' => '400',
            'border_radius' => '12px',
            'button_style' => 'solid',
            'navbar_style' => 'default',
            'site_title' => 'PAMULANGFISH',
            'site_tagline' => 'Khusus Ikan Cupang',
            'whatsapp_number' => '6281234567890',
            'whatsapp_button_text' => 'Tanya Spesimen',
            'announcement_active' => true,
            'announcement_text' => '🔥 Garansi Hidup 100% D.O.A (Death On Arrival) • Pengiriman Cepat Packing Oksigen 24 Jam • Khusus Spesimen Cupang Asli',
            'announcement_link' => '/catalog',
            'hero_badge' => '100% Spesialis Koleksi Ikan Cupang Hias & Kontes',
            'hero_title' => 'Toko Spesialis Khusus Ikan Cupang Hias',
            'hero_subtitle' => 'Pusat lelang & jual beli 100% khusus jenis ikan cupang pilihan: Halfmoon, Plakat, Crowntail (Serit), Giant, Double Tail, hingga Wild Betta. Murni spesialis Betta Fish berkualitas kontes dengan garansi hidup sampai tujuan.',
            'hero_btn_primary_text' => 'Belanja Sekarang',
            'hero_btn_primary_link' => '/catalog',
            'hero_btn_secondary_text' => 'Panduan Perawatan',
            'hero_btn_secondary_link' => '/articles',
            'trust_badge_1_val' => '100%',
            'trust_badge_1_lbl' => 'Garansi Hidup',
            'trust_badge_2_val' => 'Grade A+',
            'trust_badge_2_lbl' => 'Genetik Pilihan',
            'trust_badge_3_val' => '24 Jam',
            'trust_badge_3_lbl' => 'Packing Oksigen',
            'footer_about' => 'Platform e-commerce 100% spesialis ikan cupang hias (Betta Fish) terlengkap di Pamulang dengan kualitas genetik kontes dan garansi hidup selamat sampai tujuan (D.O.A 100%).',
            'footer_copyright' => '© 2026 Pamulang Fish Store. 100% Khusus Ikan Cupang Hias.',
            'guarantee_box_title' => 'Live Fish Guarantee (D.O.A)',
            'guarantee_box_text' => 'Garansi 100% penggantian ikan jika mati saat perjalanan via ekspedisi kilat (JNE YES / TIKI ONS) dengan video unboxing utuh tanpa jeda.',
        ]);

        return redirect()->route('admin.appearance.index')->with('success', 'Tema & konten tampilan berhasil direset ke Aquatic Modern default!');
    }
}
