<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppearanceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'theme_mode',
        'primary_color',
        'secondary_color',
        'accent_color',
        'background_color',
        'surface_color',
        'text_color',
        'muted_text_color',
        'border_color',
        'font_family',
        'body_font_size',
        'heading_font_size',
        'button_font_size',
        'heading_font_weight',
        'body_font_weight',
        'border_radius',
        'button_style',
        'navbar_style',
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
        'logo_url',
        'favicon_url',
        'is_published',
        'draft_settings',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'announcement_active' => 'boolean',
        'draft_settings' => 'array',
    ];

    public static function current(): self
    {
        $setting = static::where('is_published', true)->latest()->first();

        if (! $setting) {
            $setting = static::first() ?? new static([
                'theme_mode' => 'light',
                'primary_color' => '#0ea5e9',
                'secondary_color' => '#10b981',
                'accent_color' => '#8b5cf6',
                'background_color' => '#f8fafc',
                'surface_color' => '#ffffff',
                'text_color' => '#0f172a',
                'muted_text_color' => '#64748b',
                'border_color' => '#e2e8f0',
                'font_family' => 'Inter',
                'body_font_size' => '16px',
                'heading_font_size' => '32px',
                'button_font_size' => '14px',
                'heading_font_weight' => '700',
                'body_font_weight' => '400',
                'border_radius' => '12px',
                'button_style' => 'solid',
                'navbar_style' => 'default',
                'is_published' => true,
            ]);
        }

        return $setting;
    }

    public function toCssVariables(): string
    {
        return "
            --color-primary: {$this->primary_color};
            --color-secondary: {$this->secondary_color};
            --color-accent: {$this->accent_color};
            --color-background: {$this->background_color};
            --color-surface: {$this->surface_color};
            --color-text: {$this->text_color};
            --color-muted: {$this->muted_text_color};
            --color-border: {$this->border_color};
            --font-family: '{$this->font_family}', sans-serif;
            --body-font-size: {$this->body_font_size};
            --heading-font-size: {$this->heading_font_size};
            --button-font-size: {$this->button_font_size};
            --heading-weight: {$this->heading_font_weight};
            --body-weight: {$this->body_font_weight};
            --border-radius: {$this->border_radius};
        ";
    }
}
