<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'content',
        'meta_title', 'meta_description', 'meta_keywords',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}