<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_province',
        'shipping_city',
        'shipping_district',
        'shipping_address',
        'shipping_postal_code',
        'shipping_courier',
        'special_live_fish_packing',
        'subtotal',
        'shipping_cost',
        'discount',
        'total_amount',
        'payment_method',
        'payment_proof',
        'payment_status',
        'order_status',
        'tracking_number',
        'notes',
    ];

    protected $casts = [
        'special_live_fish_packing' => 'boolean',
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'BTC-'.date('Ymd').'-'.strtoupper(substr(uniqid(), -5));
    }
}
