<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'image', 'author_name', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getUrlAttribute()
    {
        return route('blog.show', $this->slug);
    }
}
