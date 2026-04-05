@extends('layouts.admin')

@section('title', 'Social Feedback')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="glass-card rounded-[32px] p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8 border border-white/20">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-600 text-white rounded-[24px] flex items-center justify-center text-3xl shadow-xl shadow-red-500/20">
                <i class="fas fa-video"></i>
            </div>
            <div>
                <h1 class="text-secondary text-3xl font-black tracking-tight">Social Intel</h1>
                <p class="text-gray-400 text-xs font-black uppercase tracking-widest mt-1">Manage ({{ $videos->total() }}) Customer Testimonials</p>
            </div>
        </div>
        <button onclick="document.getElementById('add-video-modal').classList.remove('hidden')" class="bg-primary hover:bg-brand-600 text-white text-[11px] font-black uppercase tracking-widest px-8 py-4 rounded-2xl transition shadow-xl shadow-primary/25 flex items-center gap-3 transform hover:-translate-y-1">
            <i class="fas fa-plus"></i> New Broadcast
        </button>
    </div>

    <!-- Video Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($videos as $video)
        <div class="glass-card rounded-[40px] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 group flex flex-col h-full bg-white/50 backdrop-blur-sm">
            <!-- Preview -->
            <div class="relative aspect-video bg-gray-900 overflow-hidden">
                @php
                    $thumbSrc = $video->thumbnail_url ? (str_contains($video->thumbnail_url, 'http') ? $video->thumbnail_url : asset('storage/' . $video->thumbnail_url)) : null;
                @endphp
                @if($thumbSrc)
                    <img src="{{ $thumbSrc }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900">
                        <i class="fas fa-video text-4xl text-white/10"></i>
                    </div>
                @endif
                
                <div class="absolute top-4 left-4 flex flex-col gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/90 backdrop-blur-md rounded-xl text-[9px] font-black uppercase tracking-widest text-secondary shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full {{ $video->status === 'active' ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></span>
                        {{ $video->status }}
                    </span>
                    @if($video->is_featured)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-yellow-400 text-yellow-900 rounded-xl text-[9px] font-black uppercase tracking-widest shadow-sm">
                            <i class="fas fa-star text-[8px]"></i> Featured
                        </span>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="p-8 flex-1 flex flex-col">
                <div class="mb-4">
                    <h3 class="font-black text-secondary text-lg">{{ $video->customer_name }}</h3>
                </div>
                <p class="text-gray-500 text-xs font-bold leading-relaxed line-clamp-3 italic flex-1">"{{ $video->comment }}"</p>
                
                <div class="flex items-center justify-between pt-6 mt-6 border-t border-gray-100/50">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.videos.toggleStatus', $video->id) }}" class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-tighter transition-all {{ $video->status === 'active' ? 'bg-indigo-50 text-indigo-600' : 'bg-green-50 text-green-600' }}">
                            {{ $video->status === 'active' ? 'Suspend' : 'Approve' }}
                        </a>
                        <a href="{{ route('admin.videos.toggleFeatured', $video->id) }}" class="w-9 h-9 flex items-center justify-center rounded-xl transition-all {{ $video->is_featured ? 'bg-yellow-50 text-yellow-600' : 'bg-gray-50 text-gray-400' }}">
                            <i class="fas fa-star text-xs"></i>
                        </a>
                    </div>
                    <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Purge this asset?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 transition border border-transparent hover:border-red-100">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Add Video Modal -->
<div id="add-video-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-secondary/80 backdrop-blur-md">
    <div class="bg-white rounded-[40px] shadow-2xl w-full max-w-xl overflow-hidden transform animate-scale-in">
        <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-white relative">
            <h3 class="text-xl font-black text-secondary tracking-tight uppercase">Transmit Social Intelligence</h3>
            <button onclick="document.getElementById('add-video-modal').classList.add('hidden')" class="text-gray-400 hover:text-red-500 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Identity Label *</label>
                    <input type="text" name="customer_name" required placeholder="Full Name"
                           class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none text-secondary font-black transition">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Stream Endpoint *</label>
                    <input type="url" name="video_url" required placeholder="YouTube/CDN URL"
                           class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none text-secondary font-black transition">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Visual Poster (Thumbnail)</label>
                <input type="file" name="thumbnail_file" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none text-secondary font-black transition">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Manifesto (Comment)</label>
                <textarea name="comment" rows="3" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none text-secondary font-black transition resize-none"></textarea>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="button" onclick="document.getElementById('add-video-modal').classList.add('hidden')" class="flex-1 py-4 rounded-2xl font-black text-gray-400 text-[10px] uppercase tracking-widest hover:bg-gray-50 transition">Abort</button>
                <button type="submit" class="flex-[1.5] py-4 bg-secondary text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-xl hover:bg-black transition-all">Commit Asset</button>
            </div>
        </form>
    </div>
</div>
@endsection
