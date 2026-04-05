@extends('layouts.app')

@section('title', 'Happy Customers - ' . config('app.name'))

@section('content')
<div class="bg-[#f4f7fe] min-h-screen py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Testimonials</span>
            <h1 class="text-4xl md:text-5xl font-display font-black text-secondary">What They Say</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($videos as $video)
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm hover:shadow-xl transition duration-500 hover:-translate-y-2 relative overflow-hidden group">
                <i class="fas fa-quote-left text-4xl text-primary/10 absolute top-8 right-8"></i>
                
                @if($video->video_url)
                <div class="mb-6 rounded-2xl overflow-hidden aspect-video bg-black relative group-hover:shadow-lg transition">
                    @php
                        $thumbSrc = $video->thumbnail_url ? (str_contains($video->thumbnail_url, 'http') ? $video->thumbnail_url : asset('storage/' . $video->thumbnail_url)) : 'https://placehold.co/600x400/000/fff?text=Watch+Video';
                    @endphp
                    <img src="{{ $thumbSrc }}" class="w-full h-full object-cover">
                    <button onclick="openVideoLightbox('{{ $video->video_url }}')" class="absolute inset-0 flex items-center justify-center bg-black/20 hover:bg-black/40 transition w-full h-full cursor-pointer">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-xl group-hover:scale-110 transition">
                            <i class="fas fa-play text-primary ml-1"></i>
                        </div>
                    </button>
                </div>
                @endif

                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center font-black text-primary uppercase">
                        {{ substr($video->customer_name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-secondary">{{ $video->customer_name }}</h4>
                        <div class="flex text-yellow-400 text-xs">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-500 leading-relaxed italic text-sm">"{{ $video->comment }}"</p>
            </div>
            @empty
            <div class="col-span-full py-20 text-center opacity-40">
                <i class="fas fa-video-slash text-4xl mb-4 block"></i>
                <p class="font-black uppercase tracking-widest text-xs">No active testimonials found</p>
            </div>
            @endforelse
        </div>
    </div>
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
