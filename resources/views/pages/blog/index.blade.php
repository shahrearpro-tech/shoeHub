@extends('layouts.app')

@section('title', 'The Journal - ShoeHub Blog')

@section('content')
<div class="bg-light min-h-screen py-16 relative overflow-hidden">
    <!-- Decorative Accents -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px] -mr-48 -mt-48 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-accent/5 rounded-full blur-[100px] -ml-24 -mb-24 pointer-events-none"></div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-20 animate-fade-in">
            <span class="text-primary font-black uppercase tracking-[0.4em] text-xs mb-4 block">Store News & Insights</span>
            <h1 class="text-5xl md:text-7xl font-playfair font-black text-secondary mb-8 leading-tight">The Journal</h1>
            <p class="text-gray-500 text-lg md:text-xl font-medium leading-relaxed">
                Explore the latest sneaker trends, styling guides, and expert maintenance tips curated just for you.
            </p>
        </div>

        <!-- Featured Post (Optional: First post) -->
        @if($posts->isNotEmpty())
            @php $featured = $posts->first(); @endphp
            <div class="mb-20 animate-fade-in-up">
                <div class="bg-white rounded-[3rem] overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.08)] border border-white flex flex-col lg:flex-row group h-auto lg:h-[550px]">
                    <div class="lg:w-3/5 overflow-hidden relative">
                        <img src="{{ $featured->image }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-transparent"></div>
                    </div>
                    <div class="lg:w-2/5 p-12 md:p-16 flex flex-col justify-center">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="px-4 py-1.5 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest rounded-full">Featured Story</span>
                            <span class="text-gray-400 text-xs font-bold">{{ $featured->created_at->format('M d, Y') }}</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-playfair font-black text-secondary mb-6 leading-tight group-hover:text-primary transition-colors cursor-pointer">
                            <a href="{{ route('blog.show', $featured->slug) }}">{{ $featured->title }}</a>
                        </h2>
                        <p class="text-gray-500 text-lg mb-8 line-clamp-3">
                            {{ $featured->excerpt }}
                        </p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-light flex items-center justify-center font-black text-secondary text-xs">
                                {{ substr($featured->author_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-secondary font-black text-sm">{{ $featured->author_name }}</p>
                                <p class="text-gray-400 text-xs font-bold">Editor in Chief</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($posts->skip(1) as $post)
                <article class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 group border border-white h-full flex flex-col transform hover:-translate-y-2">
                    <div class="aspect-[16/10] overflow-hidden relative">
                        <img src="{{ $post->image }}" class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="p-8 flex flex-col flex-grow">
                        <div class="flex items-center gap-4 text-gray-400 font-bold text-[10px] uppercase tracking-widest mb-4">
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span>{{ $post->author_name }}</span>
                        </div>
                        <h3 class="text-2xl font-playfair font-black text-secondary mb-4 leading-snug group-hover:text-primary transition-colors">
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-8 flex-grow">
                            {{ Str::limit($post->excerpt, 120) }}
                        </p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="flex items-center gap-3 text-secondary font-black text-xs uppercase tracking-widest group/btn">
                            Read Full Story 
                            <span class="w-8 h-8 rounded-full bg-light flex items-center justify-center group-hover/btn:bg-primary group-hover/btn:text-white transition-all transform group-hover/btn:translate-x-2">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-20">
            {{ $posts->links() }}
    </div>

    <!-- Video Testimonials -->
    <section class="py-24 bg-white relative overflow-hidden mt-20">
        <div class="container mx-auto px-4">
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
