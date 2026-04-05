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
    </div>
</div>
@endsection
