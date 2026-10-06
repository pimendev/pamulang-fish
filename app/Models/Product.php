<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'price',
        'discount_price',
        'stock',
        'status',
        'gender',
        'betta_type',
        'color_pattern',
        'size_cm',
        'age_months',
        'care_level',
        'description',
        'care_guide',
        'is_featured',
        'views_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock' => 'integer',
        'size_cm' => 'decimal:1',
        'age_months' => 'decimal:1',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ProductImage::class)->where('is_primary', true);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_products')->withPivot('sort_order');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->discount_price && $this->discount_price > 0 ? $this->discount_price : $this->price);
    }

    public function getHasDiscountAttribute(): bool
    {
        return ! empty($this->discount_price) && $this->discount_price < $this->price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (! $this->has_discount || $this->price <= 0) {
            return 0;
        }

        return (int) round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    public function getThumbnailAttribute(): ?string
    {
        $primary = $this->images->firstWhere('is_primary', true);
        if ($primary && ! empty($primary->image_url)) {
            $url = $primary->image_url;

            return (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) ? $url : asset(ltrim($url, '/'));
        }

        $first = $this->images->first();
        if ($first && ! empty($first->image_url)) {
            $url = $first->image_url;

            return (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) ? $url : asset(ltrim($url, '/'));
        }

        return asset('images/bettas/pk-avatargordon.jpg');
    }
}
