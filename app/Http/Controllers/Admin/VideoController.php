<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = CustomerVideo::latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'video_url' => 'required|url',
            'thumbnail_file' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('thumbnail_file')) {
            $data['thumbnail_url'] = $request->file('thumbnail_file')->store('videos/thumbnails', 'public');
        }

        CustomerVideo::create($data);

        return back()->with('success', 'Video testimonial added!');
    }

    public function update(Request $request, $id)
    {
        $video = CustomerVideo::findOrFail($id);
        
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'video_url' => 'required|url',
        ]);

        $data = $request->all();

        if ($request->hasFile('thumbnail_file')) {
            if ($video->thumbnail_url) {
                Storage::disk('public')->delete($video->thumbnail_url);
            }
            $data['thumbnail_url'] = $request->file('thumbnail_file')->store('videos/thumbnails', 'public');
        }

        $video->update($data);

        return back()->with('success', 'Video updated!');
    }

    public function destroy($id)
    {
        $video = CustomerVideo::findOrFail($id);
        if ($video->thumbnail_url) {
            Storage::disk('public')->delete($video->thumbnail_url);
        }
        $video->delete();
        return back()->with('success', 'Video deleted!');
    }

    public function toggleStatus($id)
    {
        $video = CustomerVideo::findOrFail($id);
        $video->status = ($video->status === 'active') ? 'inactive' : 'active';
        $video->save();
        return back()->with('success', 'Status updated!');
    }

    public function toggleFeatured($id)
    {
        $video = CustomerVideo::findOrFail($id);
        $video->is_featured = !$video->is_featured;
        $video->save();
        return back()->with('success', 'Featured status updated!');
    }
}
