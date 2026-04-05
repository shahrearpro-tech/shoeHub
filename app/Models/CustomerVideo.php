<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerVideo extends Model
{
    protected $fillable = [
        'customer_name',
        'video_url',
        'thumbnail_url',
        'comment',
        'is_featured',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
