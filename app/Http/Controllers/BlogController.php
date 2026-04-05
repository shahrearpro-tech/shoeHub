<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::active()->latest()->paginate(9);
        return view('pages.blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->active()->firstOrFail();
        $recentPosts = BlogPost::active()->where('id', '!=', $post->id)->latest()->take(3)->get();
        return view('pages.blog.show', compact('post', 'recentPosts'));
    }
}
