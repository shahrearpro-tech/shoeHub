<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\CustomerVideo;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::active()->latest()->paginate(9);
        $videos = CustomerVideo::active()->latest()->take(6)->get(); // Show all active, not just featured
        return view('pages.blog.index', compact('posts', 'videos'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->active()->firstOrFail();
        $recentPosts = BlogPost::active()->where('id', '!=', $post->id)->latest()->take(3)->get();
        $videos = CustomerVideo::active()->latest()->take(6)->get(); // Show all active, not just featured
        return view('pages.blog.show', compact('post', 'recentPosts', 'videos'));
    }
}
