@extends('layouts.app')

@section('title', $post->title . ' - ShoeHub Blog')

@section('content')
<div class="bg-white min-h-screen pb-24">
    <!-- Hero Header -->
    <div class="relative h-[60vh] min-h-[500px] overflow-hidden">
        <img src="{{ $post->image }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
        
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="container mx-auto px-4 text-center">
                <div class="max-w-4xl mx-auto">
                    <div class="flex items-center justify-center gap-6 text-white/80 font-black uppercase tracking-[0.3em] text-[10px] mb-8 animate-fade-in-up">
                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                        <span class="w-1 h-1 bg-primary rounded-full"></span>
                        <span>{{ $post->author_name }}</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-playfair font-black text-white mb-10 leading-tight animate-fade-in-up delay-100">
                        {{ $post->title }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="container mx-auto px-4 -mt-24 relative z-10">
        <div class="flex flex-col lg:flex-row gap-16">
            <!-- Main Content -->
            <article class="lg:w-2/3">
                <div class="bg-white p-10 md:p-20 rounded-[3rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.05)] border border-gray-100 prose prose-lg md:prose-xl max-w-none">
                    {!! $post->content !!}
                    
                    <!-- Share & Tags Placeholder -->
                    <div class="mt-20 pt-10 border-t border-gray-100 flex flex-wrap justify-between items-center gap-8">
                        <div class="flex items-center gap-4">
                            <span class="text-secondary font-black text-xs uppercase tracking-widest">Share this story:</span>
                            <div class="flex gap-3">
                                <a href="#" class="w-10 h-10 rounded-full bg-light flex items-center justify-center text-secondary hover:bg-primary hover:text-white transition-all"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="w-10 h-10 rounded-full bg-light flex items-center justify-center text-secondary hover:bg-primary hover:text-white transition-all"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="w-10 h-10 rounded-full bg-light flex items-center justify-center text-secondary hover:bg-primary hover:text-white transition-all"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <span class="px-4 py-2 bg-light text-gray-500 text-xs font-bold rounded-lg cursor-pointer hover:bg-gray-100 transition">#SneakerHead</span>
                            <span class="px-4 py-2 bg-light text-gray-500 text-xs font-bold rounded-lg cursor-pointer hover:bg-gray-100 transition">#Trends2024</span>
                        </div>
                    </div>
                </div>

                <!-- Author Box -->
                <div class="mt-12 bg-light p-10 rounded-[3rem] flex items-center gap-8 flex-col md:flex-row text-center md:text-left">
                    <div class="w-24 h-24 rounded-3xl bg-white shadow-xl flex items-center justify-center text-3xl font-black text-primary">
                        {{ substr($post->author_name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-secondary mb-2">{{ $post->author_name }}</h4>
                        <p class="text-gray-500 leading-relaxed italic">
                            A passionate storyteller and footwear expert dedicated to bringing you the finest insights from the world of premium sneakers and urban lifestyle.
                        </p>
                    </div>
                </div>
            </article>

            <!-- Sidebar -->
            <aside class="lg:w-1/3">
                <div class="sticky top-28 space-y-12">
                    <!-- Recent Posts -->
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50">
                        <h3 class="text-xl font-black text-secondary mb-8 flex items-center gap-3">
                            <i class="fas fa-bolt text-primary"></i> Latest Stories
                        </h3>
                        <div class="space-y-8">
                            @foreach($recentPosts as $recent)
                                <a href="{{ route('blog.show', $recent->slug) }}" class="flex gap-4 group">
                                    <div class="w-24 h-24 rounded-2xl overflow-hidden flex-shrink-0 shadow-sm">
                                        <img src="{{ $recent->image }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">{{ $recent->created_at->format('M d') }}</p>
                                        <h4 class="text-sm font-bold text-secondary group-hover:text-primary transition-colors leading-snug line-clamp-2">
                                            {{ $recent->title }}
                                        </h4>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Promo Banner -->
                    <div class="bg-secondary rounded-[2.5rem] p-10 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-primary/20 transition-transform duration-[3s] group-hover:scale-125 pointer-events-none"></div>
                        <div class="relative z-10 text-center">
                            <h3 class="text-2xl font-playfair font-black text-white mb-4">Limited Edition Drops</h3>
                            <p class="text-white/60 text-sm mb-8">Get exclusive access to our most sought-after collections.</p>
                            <a href="{{ route('shop') }}" class="inline-block w-full py-4 bg-primary text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-white hover:text-secondary transition-all shadow-xl">
                                Explore Shop
                            </a>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
    <!-- Video Testimonials -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="container mx-auto px-4 border-t border-gray-100 pt-24">
            <div class="text-center mb-16">
                <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Customer Stories</span>
                <h2 class="text-4xl md:text-5xl font-playfair font-bold text-secondary">Happy Customers</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($videos as $video)
                    <div class="group relative rounded-[2.5rem] overflow-hidden bg-light aspect-[4/5] shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100">
                        <img src="{{ $video->thumbnail_url ? (str_starts_with($video->thumbnail_url, 'http') ? $video->thumbnail_url : asset('storage/' . $video->thumbnail_url)) : 'https://placehold.co/600x800/000/fff?text=' . urlencode($video->customer_name) }}" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity"></div>
                        
                        <button onclick="openVideoLightbox('{{ $video->video_url }}')" class="absolute inset-0 flex items-center justify-center transition-all duration-300">
                            <div class="relative transform group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-white rounded-full video-ping-animation opacity-40"></div>
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-2xl relative z-10 transition-all duration-300">
                                    <i class="fas fa-play text-primary ml-1 text-2xl"></i>
                                </div>
                            </div>
                        </button>

                        <div class="absolute bottom-0 left-0 w-full p-10 translate-y-6 group-hover:translate-y-0 transition-all duration-500">
                            <div class="flex items-center gap-3 mb-3 opacity-0 group-hover:opacity-100 transition-opacity delay-100">
                                <div class="w-1 h-6 bg-primary rounded-full"></div>
                                <span class="text-[10px] font-black text-white/50 uppercase tracking-[0.3em]">Verified Customer</span>
                            </div>
                            <h4 class="text-2xl font-black text-white mb-2 font-display">{{ $video->customer_name }}</h4>
                            <p class="text-white/60 text-sm italic font-medium line-clamp-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">"{{ $video->comment }}"</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center opacity-40">
                        <i class="fas fa-video-slash text-4xl mb-4 block"></i>
                        <p class="font-black uppercase tracking-widest text-xs">No active testimonials found</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('happy.customers') }}" class="inline-block px-8 py-4 border-2 border-secondary text-secondary font-bold uppercase tracking-widest hover:bg-secondary hover:text-white transition-all rounded-full">View All Stories</a>
            </div>
        </div>
    </section>
</div>

<!-- Video Lightbox Modal -->
@include('layouts.partials.video-modal')

@endsection

@push('scripts')
<script>
function openVideoLightbox(url) {
    const lightbox = document.getElementById('video-lightbox');
    const container = document.getElementById('video-container');
    const wrapper = document.getElementById('video-content-wrapper');
    
    let embedUrl = url;
    if (url.includes('youtube.com/watch?v=')) {
        embedUrl = url.replace('watch?v=', 'embed/');
    } else if (url.includes('youtu.be/')) {
        embedUrl = 'https://www.youtube.com/embed/' + url.split('/').pop();
    }
    
    container.innerHTML = `<iframe src="${embedUrl}?autoplay=1" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
    lightbox.classList.remove('hidden');
    lightbox.classList.add('flex');
    
    wrapper.classList.remove('animate-modal-in');
    void wrapper.offsetWidth;
    wrapper.classList.add('animate-modal-in');

    const overlay = lightbox.querySelector('.absolute.inset-0');
    overlay.onclick = closeVideoLightbox;
}

function closeVideoLightbox() {
    const lightbox = document.getElementById('video-lightbox');
    const container = document.getElementById('video-container');
    container.innerHTML = '';
    lightbox.classList.add('hidden');
    lightbox.classList.remove('flex');
}
</script>
@endpush
