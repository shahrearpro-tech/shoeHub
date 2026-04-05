@extends('layouts.admin')

@section('title', 'Social Feed')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex items-end justify-between">
        <div>
             <h2 class="text-3xl font-black text-secondary tracking-tight">Social Feed</h2>
             <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Manage Instagram-style posts</p>
        </div>
        <div class="flex items-center gap-4">
            @if(App\Models\Setting::getValue('instagram_access_token'))
                <div class="px-6 py-4 bg-green-50 rounded-[20px] flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-xs"><i class="fas fa-check"></i></div>
                    <div>
                        <p class="text-[10px] font-black text-green-600 uppercase tracking-widest">Automatic Feed Connected</p>
                        <a href="{{ route('admin.settings') }}" class="text-[10px] font-bold text-gray-400 hover:text-secondary uppercase tracking-widest transition">Settings <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            @else
                <a href="{{ route('admin.settings') }}" class="px-6 py-4 bg-gray-50 rounded-[20px] flex items-center gap-3 hover:bg-gray-100 transition">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs"><i class="fab fa-instagram"></i></div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Feed Not Connected</p>
                        <p class="text-[10px] font-black text-primary uppercase tracking-widest">Connect API <i class="fas fa-arrow-right ml-1"></i></p>
                    </div>
                </a>
            @endif
            <a href="{{ route('admin.social-posts.create') }}" class="px-8 py-4 bg-primary text-white rounded-[20px] font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-105 transition-all transform active:scale-95 flex items-center gap-2">
                <i class="fas fa-plus"></i> Add Post
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Posts</p>
            <h3 class="text-3xl font-black text-secondary">{{ $posts->count() }}</h3>
        </div>
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Active Posts</p>
            <h3 class="text-3xl font-black text-secondary text-green-500">{{ $posts->where('status', 'active')->count() }}</h3>
        </div>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($posts as $post)
            <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 overflow-hidden group">
                <div class="aspect-square relative overflow-hidden">
                    <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4">
                        <a href="{{ route('admin.social-posts.edit', $post->id) }}" class="w-12 h-12 rounded-2xl bg-white text-secondary flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-xl">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.social-posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-12 h-12 rounded-2xl bg-white text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-xl">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Order: {{ $post->display_order }}</span>
                        <a href="{{ route('admin.social-posts.toggleStatus', $post->id) }}" class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $post->status === 'active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            {{ $post->status }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
