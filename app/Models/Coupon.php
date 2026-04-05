<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'discount_type', 'discount_value',
        'min_purchase_amount', 'max_discount_amount',
        'usage_limit', 'usage_limit_per_customer',
        'valid_from', 'valid_to',
        'applicable_products', 'applicable_categories',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'valid_from' => 'datetime',
            'valid_to' => 'datetime',
        ];
    }

    public function usage()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}