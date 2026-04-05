<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'image_path', 'button_text', 'button_link',
        'display_order', 'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orderBy('display_order');
    }
}