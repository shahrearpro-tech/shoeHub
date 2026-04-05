<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id', 'image_path', 'is_featured', 'display_order', 'color',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}