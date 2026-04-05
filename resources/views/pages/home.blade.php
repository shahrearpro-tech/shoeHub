@extends('layouts.app')

@section('title', 'Home - ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- CSS for Swiper from home.php -->
<style>
    .hero-swiper { height: 450px; width: 100%; }
    @media (min-width: 1024px) { .hero-swiper { height: 750px; } }
    @media (min-width: 768px) and (max-width: 1023px) { .hero-swiper { height: 600px; } }
    .swiper-slide { overflow: hidden; }
    .slide-bg { position: absolute; inset: 0; background-size: cover; background-position: center; transition: transform 1s ease; }
    .swiper-slide-active .slide-bg { transform: scale(1.1); transition: transform 8s ease-out; }
    .glass-nav-btn { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; }
    .glass-nav-btn:hover { background: white; color: var(--secondary); }
    .reveal-card { height: 400px; transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
    .reveal-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
    .reveal-content { transform: translateY(20px); opacity: 0; transition: all 0.5s ease; }
    .reveal-card:hover .reveal-content { transform: translateY(0); opacity: 1; }
    
    @keyframes video-ping {
        0% { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(1.6); opacity: 0; }
    }
    .video-ping-animation { animation: video-ping 2s cubic-bezier(0, 0, 0.2, 1) infinite; }
    
    @keyframes modal-in {
        0% { transform: scale(0.9); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    .animate-modal-in { animation: modal-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); }
</style>
@endpush

@section('content')

<!-- Hero Slider -->
<section class="relative bg-dark overflow-hidden mt-0">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                <div class="swiper-slide relative">
                    <div class="slide-bg" style="background-image: url('{{ getSliderImage($slider->image_path) }}');"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>
                    
                    <div class="absolute inset-0 flex items-center pt-28 md:pt-0">
                        <div class="container mx-auto px-4">
                            <div class="max-w-2xl px-2 md:px-0 opacity-0 translate-y-10 transition-all duration-1000 delay-300 slide-content">
                                <span class="inline-block py-1 px-3 border border-white/30 rounded-full text-white/80 text-[10px] md:text-sm font-bold tracking-widest mb-4 md:mb-6 backdrop-blur-md">PREMIUM COLLECTION</span>
                                <h2 class="text-3xl md:text-7xl font-playfair font-black text-white mb-4 md:mb-6 leading-[1.1]">
                                    {{ $slider->title }}
                                </h2>
                                <p class="text-sm md:text-xl text-gray-200 mb-8 md:mb-10 leading-relaxed font-light line-clamp-2 md:line-clamp-none">
                                    {{ $slider->subtitle }}
                                </p>
                                @if ($slider->button_text)
                                    <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                                        <a href="{{ $slider->button_link }}" class="px-6 py-3 md:px-8 md:py-4 bg-white text-secondary text-sm md:text-base text-center font-bold uppercase tracking-widest hover:bg-primary hover:text-white transition-all duration-300 shadow-lg">
                                            {{ $slider->button_text }}
                                        </a>
                                        <a href="{{ route('shop') }}" class="px-6 py-3 md:px-8 md:py-4 border border-white/30 text-white text-sm md:text-base text-center font-bold uppercase tracking-widest hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
                                            View Collection
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
</section>

<!-- Trust Badges -->
<section class="py-12 bg-white relative z-20 -mt-10">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-[3rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.08)] border border-gray-100 p-10 md:p-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="flex items-center gap-6 group hover:translate-y-[-5px] transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center text-primary text-2xl group-hover:bg-primary group-hover:text-white transition-all duration-300 shadow-lg shadow-primary/5">
                        <i class="fas fa-truck-fast"></i>
                    </div>
                    <div>
                        <h4 class="text-secondary font-black text-sm uppercase tracking-widest mb-1">Free Logistics</h4>
                        <p class="text-gray-400 text-xs font-bold">Orders over ৳1,000</p>
                    </div>
                </div>
                <div class="flex items-center gap-6 group hover:translate-y-[-5px] transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-600 text-2xl group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 shadow-lg shadow-purple-500/5">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                        <h4 class="text-secondary font-black text-sm uppercase tracking-widest mb-1">Secure Settlement</h4>
                        <p class="text-gray-400 text-xs font-bold">256-bit SSL encrypted</p>
                    </div>
                </div>
                <div class="flex items-center gap-6 group hover:translate-y-[-5px] transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-accent/10 flex items-center justify-center text-accent text-2xl group-hover:bg-accent group-hover:text-white transition-all duration-300 shadow-lg shadow-accent/5">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div>
                        <h4 class="text-secondary font-black text-sm uppercase tracking-widest mb-1">Quality Manifest</h4>
                        <p class="text-gray-400 text-xs font-bold">Verified authenticity</p>
                    </div>
                </div>
                <div class="flex items-center gap-6 group hover:translate-y-[-5px] transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-[#05CD99]/10 flex items-center justify-center text-[#05CD99] text-2xl group-hover:bg-[#05CD99] group-hover:text-white transition-all duration-300 shadow-lg shadow-[#05CD99]/5">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <h4 class="text-secondary font-black text-sm uppercase tracking-widest mb-1">Omni Support</h4>
                        <p class="text-gray-400 text-xs font-bold">24/7 dedicated concierge</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- New Premium Weekend Flash Sale Section -->
<section class="py-24 bg-white overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="relative rounded-[4rem] overflow-hidden bg-[#050505] p-10 md:p-20 group border border-white/5 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.6)]">
            <!-- Dynamic Background Effects -->
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary/20 rounded-full blur-[120px] -mr-64 -mt-64 group-hover:bg-primary/30 transition-all duration-1000"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-accent/10 rounded-full blur-[100px] -ml-32 -mb-32 group-hover:bg-accent/20 transition-all duration-1000"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-16">
                <!-- Text Content -->
                <div class="lg:w-3/5 text-center lg:text-left">
                    <div class="inline-flex items-center gap-3 px-5 py-2 bg-white/5 backdrop-blur-xl border border-white/10 rounded-full mb-8 animate-bounce-slow">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-accent"></span>
                        </span>
                        <span class="text-white text-[10px] font-black uppercase tracking-[0.4em]">Limited Drop Available</span>
                    </div>
                    
                    <h2 class="text-5xl md:text-8xl font-playfair font-black text-white mb-8 leading-[0.9] tracking-tighter">
                        Weekend <br><span class="bg-gradient-to-r from-primary via-[#05CD99] to-accent bg-clip-text text-transparent italic">Flash Sale</span>
                    </h2>
                    
                    <p class="text-gray-400 font-medium text-lg md:text-xl mb-12 max-w-xl mx-auto lg:mx-0 leading-relaxed opacity-80">
                        Experience the peak of performance engineering. Elite signature series now accessible with exclusive weekend valuations.
                    </p>
                    
                    <!-- Premium Countdown -->
                    <div id="flash-sale-timer" class="flex gap-4 md:gap-6 justify-center lg:justify-start mb-12">
                        <div class="relative group/time">
                            <div class="w-16 h-16 md:w-24 md:h-24 bg-white/5 backdrop-blur-3xl rounded-[2rem] flex items-center justify-center text-white text-2xl md:text-4xl font-black border border-white/10 shadow-2xl group-hover/time:border-primary/50 transition-colors" id="days">00</div>
                            <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[9px] text-gray-500 font-black uppercase tracking-[0.3em]">Days</span>
                        </div>
                        <div class="relative group/time text-white/20 text-4xl font-light mt-4 hidden md:block">:</div>
                        <div class="relative group/time">
                            <div class="w-16 h-16 md:w-24 md:h-24 bg-white/5 backdrop-blur-3xl rounded-[2rem] flex items-center justify-center text-white text-2xl md:text-4xl font-black border border-white/10 shadow-2xl group-hover/time:border-primary/50 transition-colors" id="hours">00</div>
                            <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[9px] text-gray-500 font-black uppercase tracking-[0.3em]">Hours</span>
                        </div>
                        <div class="relative group/time text-white/20 text-4xl font-light mt-4 hidden md:block">:</div>
                        <div class="relative group/time">
                            <div class="w-16 h-16 md:w-24 md:h-24 bg-white/5 backdrop-blur-3xl rounded-[2rem] flex items-center justify-center text-white text-2xl md:text-4xl font-black border border-white/10 shadow-2xl group-hover/time:border-primary/50 transition-colors" id="minutes">00</div>
                            <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[9px] text-gray-500 font-black uppercase tracking-[0.3em]">Mins</span>
                        </div>
                        <div class="relative group/time text-white/20 text-4xl font-light mt-4 hidden md:block">:</div>
                        <div class="relative group/time">
                            <div class="w-16 h-16 md:w-24 md:h-24 bg-primary/10 backdrop-blur-3xl rounded-[2rem] flex items-center justify-center text-primary text-2xl md:text-4xl font-black border border-primary/20 shadow-2xl group-hover/time:border-primary transition-colors" id="seconds">00</div>
                            <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[9px] text-primary/60 font-black uppercase tracking-[0.3em]">Secs</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5 justify-center lg:justify-start mt-16 mt-8">
                        <a href="{{ route('shop', ['on_sale' => 1]) }}" class="group relative px-12 py-6 bg-primary text-white font-black text-xs uppercase tracking-[0.3em] rounded-2xl overflow-hidden shadow-2xl shadow-primary/40">
                            <span class="relative z-10 flex items-center gap-3">Secure Your Pair <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-2 transition-transform"></i></span>
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                        </a>
                        <a href="{{ route('shop') }}" class="px-12 py-6 border border-white/20 text-white font-black text-xs uppercase tracking-[0.3em] rounded-2xl hover:bg-white/5 transition-all backdrop-blur-sm">
                            View Catalog
                        </a>
                    </div>
                </div>

                <!-- Product Spotlight Area -->
                <div class="lg:w-2/5 relative flex items-center justify-center">
                    <!-- Floating Aura -->
                    <div class="absolute inset-0 bg-primary/30 blur-[150px] rounded-full scale-125 animate-pulse"></div>
                    
                    <div class="relative w-full max-w-lg group/shoe p-8">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=1200&auto=format&fit=crop" 
                             class="relative z-10 w-full transform -rotate-[25deg] group-hover:rotate-[-15deg] group-hover:scale-110 transition-all duration-1000 ease-out drop-shadow-[0_40px_50px_rgba(0,0,0,0.8)]" 
                             alt="Featured Sale Product">
                        
                        <!-- Floating Glass Labels -->
                        <div class="absolute top-10 -right-4 bg-white/10 backdrop-blur-2xl border border-white/10 p-5 rounded-3xl z-20 shadow-2xl transform hover:scale-110 transition-transform cursor-pointer">
                            <span class="text-[9px] text-primary font-black uppercase tracking-[0.2em] mb-1 block">Value drop</span>
                            <h4 class="text-white font-black text-xl leading-none">৳12,500</h4>
                            <p class="text-gray-500 line-through text-[10px] font-bold">৳18,000</p>
                        </div>
                        
                        <div class="absolute bottom-10 -left-4 bg-white/10 backdrop-blur-2xl border border-white/10 p-5 rounded-3xl z-20 shadow-2xl transform hover:scale-110 transition-transform cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 bg-[#05CD99] rounded-full animate-ping"></div>
                                <span class="text-white font-black text-xs uppercase tracking-[0.2em]">In Stock</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Subtle Info Bar -->
            <div class="absolute bottom-0 left-0 w-full py-6 px-12 md:px-20 border-t border-white/5 bg-white/[0.02] backdrop-blur-sm flex flex-wrap justify-between items-center gap-4 hidden md:flex">
                <div class="flex items-center gap-4 text-white/40 text-[10px] font-black uppercase tracking-[0.2em]">
                    <i class="fas fa-shipping-fast text-primary"></i> Priority Express Shipping
                </div>
                <div class="flex items-center gap-4 text-white/40 text-[10px] font-black uppercase tracking-[0.2em]">
                    <i class="fas fa-undo text-primary"></i> 30-Day Elite Returns
                </div>
                <div class="flex items-center gap-4 text-white/40 text-[10px] font-black uppercase tracking-[0.2em]">
                    <i class="fas fa-shield-alt text-primary"></i> Manifest Authenticity
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Collections -->
<section class="py-24 bg-white relative">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Curated For You</span>
            <h2 class="text-4xl md:text-5xl font-playfair font-bold text-secondary">Shop By Category</h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-8 h-auto md:h-[600px]">
             @foreach ($categories->take(3) as $i => $cat)
             @php
                $img = getCategoryThumb($cat->image);
                $colSpan = ($i === 0) ? 'md:col-span-2' : 'md:col-span-1';
             @endphp
                <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="relative block rounded-3xl overflow-hidden group reveal-card {{ $colSpan }} h-full">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style="background-image: url('{{ $img }}');"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 w-full p-8">
                        <h3 class="text-3xl font-playfair font-bold text-white mb-2">{{ $cat->name }}</h3>
                        <div class="reveal-content flex items-center text-white/90 font-bold uppercase tracking-widest text-sm">
                            Explore Collection <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </div>
                </a>
             @endforeach
        </div>
        
        <div class="mt-12 text-center">
            <a href="{{ route('shop') }}" class="inline-block border-b-2 border-secondary pb-1 text-secondary font-bold uppercase tracking-widest hover:text-primary hover:border-primary transition p-2">View All Categories</a>
        </div>
    </div>
</section>

<!-- Shop The Look (Lookbook) -->
<section class="py-24 bg-[#F8F9FB] relative overflow-hidden">
    <!-- Decorative Text -->
    <div class="absolute top-1/2 left-0 -translate-y-1/2 text-[15vw] font-black text-gray-200/20 pointer-events-none select-none whitespace-nowrap leading-none uppercase tracking-tighter">
        Style Manifest
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row gap-16 items-center">
            <!-- Main Look Image -->
            <div class="w-full lg:w-1/2 relative group">
                <div class="rounded-[3rem] overflow-hidden shadow-2xl relative">
                    <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=1200&auto=format&fit=crop" class="w-full h-[700px] object-cover transition-transform duration-[2s] group-hover:scale-110" decoding="async" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-secondary/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                </div>
                
                <!-- Hotspots -->
                <div class="absolute top-[45%] left-[55%] group/dot cursor-pointer">
                    <div class="w-5 h-5 bg-primary rounded-full animate-ping opacity-75"></div>
                    <div class="w-5 h-5 bg-primary rounded-full absolute inset-0 border-2 border-white shadow-xl"></div>
                    <div class="absolute top-[-100px] left-1/2 -translate-x-1/2 bg-white/90 backdrop-blur-md p-5 rounded-3xl shadow-[0_30px_60px_-15px_rgba(0,0,0,0.3)] opacity-0 group-hover/dot:opacity-100 transition-all duration-500 w-56 scale-90 group-hover/dot:scale-100 pointer-events-none border border-white/20">
                        <div class="flex items-center gap-4">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=100&auto=format" class="w-12 h-12 rounded-xl object-cover" decoding="async" loading="lazy">
                            <div>
                                <p class="text-[8px] font-black text-primary uppercase tracking-widest mb-1">Elite Tech</p>
                                <h4 class="text-xs font-black text-secondary">Air Max Zenith</h4>
                                <span class="text-[10px] font-black text-primary">৳12,500</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-[30%] left-[25%] group/dot cursor-pointer">
                    <div class="w-5 h-5 bg-accent rounded-full animate-ping opacity-75"></div>
                    <div class="w-5 h-5 bg-accent rounded-full absolute inset-0 border-2 border-white shadow-xl"></div>
                    <div class="absolute top-[-100px] left-1/2 -translate-x-1/2 bg-white/90 backdrop-blur-md p-5 rounded-3xl shadow-[0_30px_60px_-15px_rgba(0,0,0,0.3)] opacity-0 group-hover/dot:opacity-100 transition-all duration-500 w-56 scale-90 group-hover/dot:scale-100 pointer-events-none border border-white/20">
                        <div class="flex items-center gap-4 flex-row-reverse">
                            <img src="https://images.unsplash.com/photo-1620138546344-7b2c38516dee?q=80&w=100&auto=format" class="w-12 h-12 rounded-xl object-cover" decoding="async" loading="lazy">
                            <div class="text-right">
                                <p class="text-[8px] font-black text-accent uppercase tracking-widest mb-1">Urban Gear</p>
                                <h4 class="text-xs font-black text-secondary">Cargo Elite V2</h4>
                                <span class="text-[10px] font-black text-secondary">৳4,200</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="w-full lg:w-1/2 space-y-10">
                <div>
                    <span class="text-primary font-black tracking-[0.3em] uppercase text-xs mb-4 block">Seasonal Series</span>
                    <h2 class="text-5xl md:text-7xl font-playfair font-black text-secondary leading-tight mb-6">Manifest Your<br><span class="text-primary italic">Urban</span> Identity</h2>
                    <p class="text-gray-500 text-lg leading-relaxed max-w-lg">
                        Beyond protection. Our curations are designed to integrate seamlessly into the high-frequency urban landscape.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-6 md:gap-8">
                     <!-- The Sneaker Card -->
                     <div class="bg-white p-6 md:p-8 rounded-[2rem] shadow-[0_20px_50px_-15px_rgba(0,0,0,0.05)] hover:shadow-2xl transition-all duration-500 group/card relative overflow-hidden border border-gray-50">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 group-hover/card:scale-150 transition-transform duration-700"></div>
                        <h4 class="text-secondary font-black text-[10px] uppercase tracking-[0.2em] mb-4 relative z-10">The Sneaker</h4>
                        <div class="relative z-10 h-32 md:h-40 flex items-center justify-center mb-6">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=400&auto=format" class="w-full h-full object-contain transform -rotate-12 group-hover/card:rotate-0 group-hover/card:scale-110 transition-all duration-700 drop-shadow-2xl">
                        </div>
                        <a href="{{ route('shop') }}" class="text-primary font-bold text-[10px] uppercase tracking-widest flex items-center relative z-10 group/link">
                            Explore <i class="fas fa-arrow-right ml-2 group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                     </div>

                     <!-- The Utility Card -->
                     <div class="bg-white p-6 md:p-8 rounded-[2rem] shadow-[0_20px_50px_-15px_rgba(0,0,0,0.05)] hover:shadow-2xl transition-all duration-500 group/card relative overflow-hidden border border-gray-50">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-accent/5 rounded-full -mr-16 -mt-16 group-hover/card:scale-150 transition-transform duration-700"></div>
                        <h4 class="text-secondary font-black text-[10px] uppercase tracking-[0.2em] mb-4 relative z-10">The Utility</h4>
                        <div class="relative z-10 h-32 md:h-40 flex items-center justify-center mb-6">
                            <img src="https://images.unsplash.com/photo-1620138546344-7b2c38516dee?q=80&w=400&auto=format" class="w-full h-full object-contain group-hover/card:scale-110 transition-transform duration-700 drop-shadow-xl">
                        </div>
                        <a href="{{ route('shop') }}" class="text-primary font-bold text-[10px] uppercase tracking-widest flex items-center relative z-10 group/link">
                            Explore <i class="fas fa-arrow-right ml-2 group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                     </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tabbed Products -->
<section class="py-24 bg-light relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-3xl -mr-24 -mt-24 pointer-events-none"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div>
                <h2 class="text-4xl font-playfair font-bold text-secondary mb-4">Selected For You</h2>
                <div class="flex space-x-8 border-b border-gray-200">
                    <button class="collection-tab active pb-4 border-b-2 border-primary text-primary font-bold text-lg transition-all" data-target="trending">Trending</button>
                    <button class="collection-tab pb-4 border-b-2 border-transparent text-gray-500 font-bold text-lg hover:text-secondary transition-all" data-target="new-arrivals">New Arrivals</button>
                    <button class="collection-tab pb-4 border-b-2 border-transparent text-gray-500 font-bold text-lg hover:text-secondary transition-all" data-target="best-sellers">Best Sellers</button>
                </div>
            </div>
            <a href="{{ route('shop') }}" class="hidden md:flex items-center font-bold text-secondary hover:text-primary transition group uppercase tracking-widest text-xs mb-4">
                View All Products <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        
        <div class="min-h-[400px]">
            <!-- Trending -->
            <div id="trending" class="collection-content grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-8 animate-fade-in-up">
                @foreach ($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            
            <!-- New Arrivals -->
            <div id="new-arrivals" class="collection-content grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-8 hidden animate-fade-in-up">
                @foreach ($newArrivals as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            
             <!-- Best Sellers -->
            <div id="best-sellers" class="collection-content grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-8 hidden animate-fade-in-up">
                @foreach ($bestSellers as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
</section>

<!-- Signature Drop Spotlight -->
<section class="py-24 bg-white relative overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="relative rounded-[4rem] overflow-hidden bg-secondary min-h-[600px] flex items-center group">
            <!-- Background Image with Parallax Effect -->
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[10s] group-hover:scale-110" style="background-image: url('https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?q=80&w=1920&auto=format&fit=crop');"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-secondary via-secondary/60 to-transparent"></div>
            
            <!-- Content -->
            <div class="relative z-10 w-full md:w-1/2 p-12 md:p-24 text-white">
                <span class="inline-block py-1.5 px-4 bg-primary text-white text-[10px] font-black tracking-[0.3em] uppercase rounded-full mb-8 border border-white/20">Signature Spotlight</span>
                <h2 class="text-5xl md:text-7xl font-playfair font-black mb-8 leading-tight">
                    The Neon<br>Performance <span class="text-primary italic">X40</span>
                </h2>
                <p class="text-white/60 text-lg mb-12 max-w-md font-medium leading-relaxed">
                    Designed for extreme urban exploration. Engineered with responsive foam tech and a breathable manifest mesh.
                </p>
                <div class="flex flex-wrap gap-6">
                    <a href="{{ route('shop') }}" class="px-10 py-5 bg-white text-secondary font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-primary hover:text-white transition-all shadow-2xl hover:shadow-primary/30 transform hover:-translate-y-1">
                        Acquire Manifest
                    </a>
                    <div class="flex items-center gap-4">
                         <span class="text-3xl font-black text-white">৳12,500</span>
                         <span class="text-white/40 line-through text-sm font-bold">৳18,000</span>
                    </div>
                </div>
            </div>
            
            <!-- Hover Floating Elements -->
            <div class="absolute top-20 right-20 w-32 h-32 bg-primary/20 backdrop-blur-3xl rounded-full animate-bounce duration-[3s] hidden md:block"></div>
            <div class="absolute bottom-20 right-1/4 w-48 h-48 bg-purple-500/20 backdrop-blur-3xl rounded-full animate-pulse delay-700 hidden md:block"></div>
        </div>
    </div>
</section>

<!-- Promo Parallax -->
<section class="py-32 relative bg-fixed bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1511556532299-8f662fc26c06?q=80&w=1920&auto=format&fit=crop');">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <span class="text-accent font-bold tracking-[0.3em] uppercase mb-4 block animate-pulse">Limited Time Offer</span>
        <h2 class="text-5xl md:text-7xl font-playfair font-black text-white mb-8">Flash Sale Ends Soon</h2>
        <a href="{{ route('shop', ['on_sale' => 1]) }}" class="px-10 py-5 bg-white text-secondary text-lg font-bold uppercase tracking-widest rounded-full hover:bg-primary hover:text-white transition-all shadow-xl hover:shadow-primary/50 transform hover:-translate-y-1">
            Shop The Sale
        </a>
    </div>
</section>

<!-- Video Testimonials -->
<section class="py-24 bg-white relative overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Customer Stories</span>
            <h2 class="text-4xl md:text-5xl font-playfair font-bold text-secondary">Happy Customers</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($videos as $video)
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
            @endforeach
        </div>
        
        <div class="mt-12 text-center">
            <a href="{{ route('happy.customers') }}" class="inline-block px-8 py-4 border-2 border-secondary text-secondary font-bold uppercase tracking-widest hover:bg-secondary hover:text-white transition-all rounded-full">View All Stories</a>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="py-24 bg-light">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-end mb-16">
            <div>
                <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">The Journal</span>
                <h2 class="text-4xl md:text-5xl font-playfair font-bold text-secondary">Latest From Blog</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="hidden md:block font-bold text-secondary hover:text-primary transition uppercase tracking-widest text-xs border-b-2 border-secondary hover:border-primary pb-1">Read All Posts</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($blogPosts as $post)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ $post->image }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-[10px] font-bold uppercase tracking-widest py-1 px-3 bg-primary/10 text-primary rounded-full">Community</span>
                            <span class="text-gray-400 text-xs">{{ $post->created_at->format('M d, Y') }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-secondary mb-4 group-hover:text-primary transition-colors cursor-pointer">
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6">{{ Str::limit($post->excerpt, 100) }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="font-bold text-secondary text-xs uppercase tracking-widest flex items-center group-hover:gap-2 transition-all">Read More <i class="fas fa-arrow-right ml-2 opacity-0 group-hover:opacity-100 transition-all"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Community Social Grid -->
<section class="py-24 bg-white relative overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute top-1/2 left-0 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -ml-48"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent/5 rounded-full blur-[100px] -mr-48"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.5em] mb-4">ShoeHub Community</h2>
            <h3 class="text-4xl md:text-5xl font-playfair font-black text-secondary">Vibe Check <span class="text-primary italic">#ShoeHubLife</span></h3>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @if($instagramWidget)
                <div class="col-span-full">
                    {!! $instagramWidget !!}
                </div>
            @elseif(isset($apiPosts) && $apiPosts->count() > 0)
                @foreach($apiPosts as $post)
                    <a href="{{ $post['permalink'] ?? '#' }}" target="_blank" class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer shadow-sm hover:shadow-2xl transition-all duration-500">
                        <img src="{{ $post['media_type'] === 'VIDEO' ? ($post['thumbnail_url'] ?? $post['media_url']) : $post['media_url'] }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-125">
                        <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <i class="fab fa-instagram text-white text-3xl transform scale-50 group-hover:scale-100 transition-transform"></i>
                        </div>
                    </a>
                @endforeach
            @elseif($socialPosts->count() > 0)
                @foreach($socialPosts as $post)
                    <a href="{{ $post->link ?? '#' }}" target="_blank" class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer shadow-sm hover:shadow-2xl transition-all duration-500">
                        <img src="{{ asset('storage/' . $post->image) }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-125">
                        <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <i class="fab fa-instagram text-white text-3xl transform scale-50 group-hover:scale-100 transition-transform"></i>
                        </div>
                    </a>
                @endforeach
            @else
                @php
                    $socialImages = [
                        'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
                        'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a',
                        'https://images.unsplash.com/photo-1560769629-975ec94e6a86',
                        'https://images.unsplash.com/photo-1512374382149-4332c6c021f1',
                        'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77',
                        'https://images.unsplash.com/photo-1549298916-b41d501d3772'
                    ];
                @endphp
                @foreach($socialImages as $img)
                    <div class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer shadow-sm hover:shadow-2xl transition-all duration-500">
                        <img src="{{ $img }}?q=80&w=400&auto=format&fit=crop" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-125">
                        <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <i class="fab fa-instagram text-white text-3xl transform scale-50 group-hover:scale-100 transition-transform"></i>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Brands -->
<section class="py-12 bg-light border-t border-gray-100">
    <div class="container mx-auto px-4">
        <p class="text-center text-gray-400 text-xs font-bold tracking-[0.2em] uppercase mb-8">Trusted by Global Brands</p>
        <div class="flex flex-wrap justify-center items-center gap-12 md:gap-20 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
            @foreach ($brands as $brand)
                <a href="{{ route('shop', ['brand' => $brand->id]) }}" class="hover:opacity-100 transition hover:scale-110 transform duration-300">
                    @if ($brand->logo)
                        <img src="{{ asset('storage/brands/' . $brand->logo) }}" alt="{{ $brand->name }}" loading="lazy" decoding="async" class="h-8 md:h-12 w-auto object-contain">
                    @else
                        <span class="font-bold text-xl text-secondary">{{ $brand->name }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
     </div>
</section>

@include('layouts.partials.video-modal')

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const heroSwiper = new Swiper('.hero-swiper', {
        loop: true, speed: 1000, parallax: true,
        autoplay: { delay: 6000, disableOnInteraction: false },
        navigation: { nextEl: '.swiper-button-next-custom', prevEl: '.swiper-button-prev-custom' },
        pagination: { 
            el: '.swiper-pagination-custom', clickable: true,
            renderBullet: function (index, className) {
                return '<span class="' + className + ' w-3 h-3 bg-white/50 rounded-full mx-1 cursor-pointer transition-all duration-300 hover:bg-white !opacity-100"></span>';
            }
        },
        on: {
            init: function () { this.slides[this.activeIndex].querySelector('.slide-content').classList.remove('opacity-0', 'translate-y-10'); },
            slideChangeTransitionStart: function () { document.querySelectorAll('.slide-content').forEach(el => { el.classList.add('opacity-0', 'translate-y-10'); }); },
            slideChangeTransitionEnd: function () { this.slides[this.activeIndex].querySelector('.slide-content').classList.remove('opacity-0', 'translate-y-10'); }
        }
    });

    const tabs = document.querySelectorAll('.collection-tab');
    const contents = document.querySelectorAll('.collection-content');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => { t.classList.remove('active', 'border-primary', 'text-primary'); t.classList.add('border-transparent', 'text-gray-500'); });
            tab.classList.add('active', 'border-primary', 'text-primary'); tab.classList.remove('border-transparent', 'text-gray-500');
            contents.forEach(c => c.classList.add('hidden'));
            document.getElementById(tab.dataset.target).classList.remove('hidden');
        });
    });

    // Flash Sale Timer
    const countdownDate = new Date();
    countdownDate.setDate(countdownDate.getDate() + 2); // 2 Days from now

    const updateTimer = () => {
        const now = new Date().getTime();
        const distance = countdownDate - now;

        const d = Math.floor(distance / (1000 * 60 * 60 * 24));
        const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const s = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('days').innerText = d.toString().padStart(2, '0');
        document.getElementById('hours').innerText = h.toString().padStart(2, '0');
        document.getElementById('minutes').innerText = m.toString().padStart(2, '0');
        document.getElementById('seconds').innerText = s.toString().padStart(2, '0');
    };

    setInterval(updateTimer, 1000);
    updateTimer();

    // Comparison Slider
    const slider = document.getElementById('comparison-slider');
    const overlay = document.getElementById('slider-overlay');
    const handle = document.getElementById('slider-handle');

    if (slider) {
        const move = (e) => {
            let x = e.type.includes('touch') ? e.touches[0].clientX : e.clientX;
            let rect = slider.getBoundingClientRect();
            let pos = ((x - rect.left) / rect.width) * 100;
            if (pos < 0) pos = 0;
            if (pos > 100) pos = 100;
            overlay.style.width = pos + '%';
            handle.style.left = pos + '%';
        };

        slider.addEventListener('mousemove', move);
        slider.addEventListener('touchmove', move);
    }
});

function openVideoLightbox(url) {
    const lightbox = document.getElementById('video-lightbox');
    const container = document.getElementById('video-container');
    const wrapper = document.getElementById('video-content-wrapper');
    
    // Auto-convert YouTube/Vimeo URLs to embed if necessary
    let embedUrl = url;
    if (url.includes('youtube.com/watch?v=')) {
        embedUrl = url.replace('watch?v=', 'embed/');
    } else if (url.includes('youtu.be/')) {
        embedUrl = 'https://www.youtube.com/embed/' + url.split('/').pop();
    }
    
    container.innerHTML = `<iframe src="${embedUrl}?autoplay=1" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
    lightbox.classList.remove('hidden');
    lightbox.classList.add('flex');
    
    // Add animation
    wrapper.classList.remove('animate-modal-in');
    void wrapper.offsetWidth; // Force reflow
    wrapper.classList.add('animate-modal-in');

    // Add close listener for overlay
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