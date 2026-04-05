@extends('layouts.admin')

@section('title', 'Add Social Post')

@section('content')
<div class="max-w-2xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex items-end justify-between">
        <div>
             <h2 class="text-3xl font-black text-secondary tracking-tight">Add New Post</h2>
             <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Share a new vibe with the community</p>
        </div>
        <a href="{{ route('admin.social-posts.index') }}" class="text-[#A3AED0] hover:text-secondary font-bold text-sm flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to Feed
        </a>
    </div>

    <form action="{{ route('admin.social-posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[40px] shadow-2xl border border-white/20 p-10 space-y-8">
        @csrf
        
        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 px-1">Post Image (Instagram Square Recommended)</label>
            <div class="relative group">
                <input type="file" name="image" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <div class="w-full h-64 rounded-3xl bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center group-hover:bg-gray-100 group-hover:border-primary/50 transition-all">
                    <i class="fas fa-image text-4xl text-gray-300 mb-4 group-hover:text-primary transition-colors"></i>
                    <p class="text-gray-500 font-bold text-sm">Click or drag image to upload</p>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Instagram Link (Optional)</label>
            <input type="url" name="link" placeholder="https://instagram.com/p/..." class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Display Order</label>
                <input type="number" name="display_order" value="0" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Status</label>
                <select name="status" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-5 bg-primary text-white rounded-[24px] font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/30 hover:bg-brand-600 transition-all transform hover:-translate-y-1">
                Share Post
            </button>
        </div>
    </form>
</div>
@endsection
