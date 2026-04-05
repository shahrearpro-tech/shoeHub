<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SocialPostController extends Controller
{
    public function index()
    {
        $posts = SocialPost::orderBy('display_order')->get();
        return view('admin.social-posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.social-posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|url',
            'display_order' => 'integer',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = $request->file('image')->store('social-posts', 'public');

        SocialPost::create([
            'image' => $imagePath,
            'link' => $request->link,
            'display_order' => $request->display_order ?? 0,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.social-posts.index')->with('success', 'Social post created successfully!');
    }

    public function edit($id)
    {
        $post = SocialPost::findOrFail($id);
        return view('admin.social-posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = SocialPost::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|url',
            'display_order' => 'integer',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('social-posts', 'public');
        }

        $post->link = $request->link;
        $post->display_order = $request->display_order ?? 0;
        $post->status = $request->status;
        $post->save();

        return redirect()->route('admin.social-posts.index')->with('success', 'Social post updated successfully!');
    }

    public function destroy($id)
    {
        $post = SocialPost::findOrFail($id);
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('admin.social-posts.index')->with('success', 'Social post deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $post = SocialPost::findOrFail($id);
        $post->status = $post->status === 'active' ? 'inactive' : 'active';
        $post->save();

        return back()->with('success', 'Status updated successfully!');
    }
}
