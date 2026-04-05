@extends('layouts.admin')

@section('title', 'Edit Social Post')

@section('content')
<div class="max-w-2xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex items-end justify-between">
        <div>
             <h2 class="text-3xl font-black text-secondary tracking-tight">Edit Post</h2>
             <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Refine your community vibe</p>
        </div>
        <a href="{{ route('admin.social-posts.index') }}" class="text-[#A3AED0] hover:text-secondary font-bold text-sm flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to Feed
        </a>
    </div>

    <form action="{{ route('admin.social-posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[40px] shadow-2xl border border-white/20 p-10 space-y-8">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 px-1">Change Image (Optional)</label>
            <div class="relative group">
                <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <div class="w-full h-64 rounded-3xl bg-gray-50 border-2 border-dashed border-gray-200 overflow-hidden relative group-hover:bg-gray-100 group-hover:border-primary/50 transition-all">
                    <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-image text-4xl text-white mb-4"></i>
                        <p class="text-white font-bold text-sm">Click to change image</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Instagram Link (Optional)</label>
            <input type="url" name="link" value="{{ $post->link }}" placeholder="https://instagram.com/p/..." class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Display Order</label>
                <input type="number" name="display_order" value="{{ $post->display_order }}" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Status</label>
                <select name="status" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                    <option value="active" {{ $post->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $post->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-5 bg-primary text-white rounded-[24px] font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/30 hover:bg-brand-600 transition-all transform hover:-translate-y-1">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
