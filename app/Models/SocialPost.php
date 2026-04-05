<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    protected $fillable = [
        'image', 'link', 'display_order', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orderBy('display_order');
    }
}
