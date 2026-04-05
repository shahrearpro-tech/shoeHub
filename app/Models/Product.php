<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'sku', 'category_id', 'brand_id',
        'short_description', 'description',
        'regular_price', 'sale_price', 'tax_class',
        'stock_quantity', 'stock_status', 'low_stock_threshold',
        'weight', 'length', 'width', 'height',
        'is_featured', 'is_new', 'is_best_seller',
        'status', 'views_count',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $appends = ['price', 'featured_image'];

    protected function casts(): array
    {
        return [
            'regular_price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_best_seller' => 'boolean',
        ];
    }

    /**
     * Boot method for model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Cascade delete related records when product is deleted
        static::deleting(function ($product) {
            // Delete all product images
            $product->images()->delete();
            
            // Delete all product attributes
            $product->attributes()->delete();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('display_order');
    }

    public function featuredImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_featured', true);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getEffectivePriceAttribute()
    {
        return $this->sale_price ?? $this->regular_price;
    }

    public function getFeaturedImageAttribute()
    {
        $image = $this->images->where('is_featured', true)->first() ?? $this->images->first();
        return $image ? $image->image_path : null;
    }

    public function getPriceAttribute()
    {
        return ($this->sale_price && $this->sale_price > 0 && $this->sale_price < $this->regular_price) 
            ? $this->sale_price 
            : $this->regular_price;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}