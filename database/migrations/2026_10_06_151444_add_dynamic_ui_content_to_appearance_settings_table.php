<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appearance_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('appearance_settings', 'site_title')) {
                $table->string('site_title')->default('PAMULANGFISH');
            }
            if (! Schema::hasColumn('appearance_settings', 'site_tagline')) {
                $table->string('site_tagline')->default('Khusus Ikan Cupang');
            }
            if (! Schema::hasColumn('appearance_settings', 'whatsapp_number')) {
                $table->string('whatsapp_number')->default('6281234567890');
            }
            if (! Schema::hasColumn('appearance_settings', 'whatsapp_button_text')) {
                $table->string('whatsapp_button_text')->default('Tanya Spesimen');
            }
            if (! Schema::hasColumn('appearance_settings', 'announcement_active')) {
                $table->boolean('announcement_active')->default(true);
            }
            if (! Schema::hasColumn('appearance_settings', 'announcement_text')) {
                $table->string('announcement_text')->default('🔥 Garansi Hidup 100% D.O.A (Death On Arrival) • Pengiriman Cepat Packing Oksigen 24 Jam • Khusus Spesimen Cupang Asli');
            }
            if (! Schema::hasColumn('appearance_settings', 'announcement_link')) {
                $table->string('announcement_link')->nullable();
            }
            if (! Schema::hasColumn('appearance_settings', 'hero_badge')) {
                $table->string('hero_badge')->default('100% Spesialis Koleksi Ikan Cupang Hias & Kontes');
            }
            if (! Schema::hasColumn('appearance_settings', 'hero_title')) {
                $table->string('hero_title')->default('Toko Spesialis Khusus Ikan Cupang Hias');
            }
            if (! Schema::hasColumn('appearance_settings', 'hero_subtitle')) {
                $table->text('hero_subtitle')->nullable();
            }
            if (! Schema::hasColumn('appearance_settings', 'hero_btn_primary_text')) {
                $table->string('hero_btn_primary_text')->default('Belanja Sekarang');
            }
            if (! Schema::hasColumn('appearance_settings', 'hero_btn_primary_link')) {
                $table->string('hero_btn_primary_link')->default('/catalog');
            }
            if (! Schema::hasColumn('appearance_settings', 'hero_btn_secondary_text')) {
                $table->string('hero_btn_secondary_text')->default('Panduan Perawatan');
            }
            if (! Schema::hasColumn('appearance_settings', 'hero_btn_secondary_link')) {
                $table->string('hero_btn_secondary_link')->default('/articles');
            }
            if (! Schema::hasColumn('appearance_settings', 'trust_badge_1_val')) {
                $table->string('trust_badge_1_val')->default('100%');
            }
            if (! Schema::hasColumn('appearance_settings', 'trust_badge_1_lbl')) {
                $table->string('trust_badge_1_lbl')->default('Garansi Hidup');
            }
            if (! Schema::hasColumn('appearance_settings', 'trust_badge_2_val')) {
                $table->string('trust_badge_2_val')->default('Grade A+');
            }
            if (! Schema::hasColumn('appearance_settings', 'trust_badge_2_lbl')) {
                $table->string('trust_badge_2_lbl')->default('Genetik Pilihan');
            }
            if (! Schema::hasColumn('appearance_settings', 'trust_badge_3_val')) {
                $table->string('trust_badge_3_val')->default('24 Jam');
            }
            if (! Schema::hasColumn('appearance_settings', 'trust_badge_3_lbl')) {
                $table->string('trust_badge_3_lbl')->default('Packing Oksigen');
            }
            if (! Schema::hasColumn('appearance_settings', 'footer_about')) {
                $table->text('footer_about')->nullable();
            }
            if (! Schema::hasColumn('appearance_settings', 'footer_copyright')) {
                $table->string('footer_copyright')->default('© 2026 Pamulang Fish Store. 100% Khusus Ikan Cupang Hias.');
            }
            if (! Schema::hasColumn('appearance_settings', 'guarantee_box_title')) {
                $table->string('guarantee_box_title')->default('Live Fish Guarantee (D.O.A)');
            }
            if (! Schema::hasColumn('appearance_settings', 'guarantee_box_text')) {
                $table->text('guarantee_box_text')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appearance_settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_title',
                'site_tagline',
                'whatsapp_number',
                'whatsapp_button_text',
                'announcement_active',
                'announcement_text',
                'announcement_link',
                'hero_badge',
                'hero_title',
                'hero_subtitle',
                'hero_btn_primary_text',
                'hero_btn_primary_link',
                'hero_btn_secondary_text',
                'hero_btn_secondary_link',
                'trust_badge_1_val',
                'trust_badge_1_lbl',
                'trust_badge_2_val',
                'trust_badge_2_lbl',
                'trust_badge_3_val',
                'trust_badge_3_lbl',
                'footer_about',
                'footer_copyright',
                'guarantee_box_title',
                'guarantee_box_text',
            ]);
        });
    }
};
