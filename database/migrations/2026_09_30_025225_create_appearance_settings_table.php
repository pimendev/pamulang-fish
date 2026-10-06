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
        Schema::create('appearance_settings', function (Blueprint $table) {
            $table->id();
            $table->string('theme_mode')->default('light'); // light, dark, system
            $table->string('primary_color')->default('#0ea5e9');
            $table->string('secondary_color')->default('#10b981');
            $table->string('accent_color')->default('#8b5cf6');
            $table->string('background_color')->default('#f8fafc');
            $table->string('surface_color')->default('#ffffff');
            $table->string('text_color')->default('#0f172a');
            $table->string('muted_text_color')->default('#64748b');
            $table->string('border_color')->default('#e2e8f0');
            $table->string('font_family')->default('Inter');
            $table->string('body_font_size')->default('16px');
            $table->string('heading_font_size')->default('32px');
            $table->string('button_font_size')->default('14px');
            $table->string('heading_font_weight')->default('700');
            $table->string('body_font_weight')->default('400');
            $table->string('border_radius')->default('12px');
            $table->string('button_style')->default('solid'); // solid, outline, ghost, soft, gradient
            $table->string('navbar_style')->default('default'); // default, minimal, transparent, floating
            $table->string('logo_url')->nullable();
            $table->string('favicon_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->json('draft_settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appearance_settings');
    }
};
