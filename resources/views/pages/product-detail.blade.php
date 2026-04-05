@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .swiper-slide-thumb-active {
        border-color: var(--color-primary) !important;
        opacity: 1 !important;
    }
</style>
@endpush

@section('content')
<div class="bg-white min-h-screen pb-24 md:pb-0 relative overflow-hidden">
    <!-- Fluid background accents -->
    <div class="absolute top-0 right-0 w-[300px] h-[300px] bg-primary/5 rounded-full blur-[100px] -mr-24 -mt-24 pointer-events-none"></div>
    
    <div class="container mx-auto px-4 md:px-6 relative z-10 pt-4 md:pt-12">
        <!-- Breadcrumb - Hidden on small mobile to reduce clutter -->
        <nav class="hidden md:block mb-8 text-[10px] uppercase tracking-[0.2em] font-bold text-gray-400">
             <a href="{{ route('home') }}" class="hover:text-primary transition">Home</a> / 
             <a href="{{ route('shop') }}" class="hover:text-primary transition">Shop</a> / 
             <span class="text-secondary">{{ $product->name }}</span>
        </nav>
        
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-16">
            <!-- Gallery (Mobile First: Top) -->
            <div class="w-full lg:w-[55%] product-gallery sticky top-24">
                <div class="relative group">
                    <div class="swiper mainSwiper gallery-main rounded-[2rem] overflow-hidden bg-white border border-gray-100 aspect-square md:aspect-[4/3] shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                        <div class="swiper-wrapper">
                            @if($product->images->isNotEmpty())
                                @foreach($product->images as $img)
                                    <div class="swiper-slide cursor-crosshair">
                                        <img src="{{ getProductImage($img->image_path) }}" data-zoom="{{ getProductImage($img->image_path) }}" class="w-full h-full object-cover zoomable" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            @elseif($product->featured_image)
                                <div class="swiper-slide cursor-crosshair">
                                    <img src="{{ getProductImage($product->featured_image) }}" data-zoom="{{ getProductImage($product->featured_image) }}" class="w-full h-full object-cover zoomable" alt="{{ $product->name }}">
                                </div>
                            @endif
                            
                            <!-- Demo Images for Slider Verification -->
                            @php 
                                $demoImages = [
                                    ['url' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?auto=format&fit=crop&w=800&q=80', 'color' => 'red'],
                                    ['url' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=800&q=80', 'color' => 'green'],
                                    ['url' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=800&q=80', 'color' => 'brown']
                                ];
                            @endphp
                            @foreach($demoImages as $demo)
                                <div class="swiper-slide cursor-crosshair" data-color="{{ $demo['color'] }}">
                                    <img src="{{ $demo['url'] }}" data-zoom="{{ $demo['url'] }}" class="w-full h-full object-cover zoomable" alt="Demo View">
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination md:hidden p-4"></div>
                        <div class="swiper-button-next after:!text-sm !w-10 !h-10 !bg-white !rounded-full !shadow-md !text-gray-900 hover:!bg-primary hover:!text-white transition-all hidden md:flex items-center justify-center !right-4 !z-10"></div>
                        <div class="swiper-button-prev after:!text-sm !w-10 !h-10 !bg-white !rounded-full !shadow-md !text-gray-900 hover:!bg-primary hover:!text-white transition-all hidden md:flex items-center justify-center !left-4 !z-10"></div>
                    </div>
                    
                    @if($product->product_views && $product->product_views->count() > 0 || true) <!-- Always show for demo -->
                        <button onclick="open360View()" class="absolute top-4 right-4 z-20 w-10 h-10 bg-white/80 backdrop-blur-md text-secondary rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all transform hover:scale-110" title="360 View">
                            <i class="fas fa-cube"></i>
                        </button>
                    @endif
                    
                    @if($product->sale_price < $product->regular_price)
                        <div class="absolute top-4 left-4 z-20 px-4 py-2 bg-accent text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-accent/20">
                            -{{ round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100) }}% SALE
                        </div>
                    @endif
                </div>

                <!-- Thumbnails Slider -->
                <div class="hidden md:block mt-6 px-1">
                    <div thumbsSlider="" class="swiper thumbsSwiper">
                        <div class="swiper-wrapper">
                             @foreach($product->images as $img)
                                <div class="swiper-slide rounded-xl overflow-hidden border border-gray-100 hover:border-secondary transition-all cursor-pointer bg-white h-24 p-2 box-border">
                                    <img src="{{ getProductImage($img->image_path) }}" class="w-full h-full object-cover rounded-lg">
                                </div>
                             @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Zoom Pane Host (Absolute to relative parent) -->
            <div class="hidden lg:block absolute left-[57%] top-0 w-[43%] h-[600px] z-50 pointer-events-none drift-host"></div>
            
            <!-- Info -->
            <div class="w-full lg:w-[45%] flex flex-col pt-0 md:pt-4">
                <div class="mb-2 flex items-center gap-2">
                    <div class="flex text-yellow-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">(4.9/5 Rating)</span>
                </div>
                
                <h1 class="text-3xl md:text-5xl font-playfair font-black text-secondary mb-4 leading-tight">{{ $product->name }}</h1>
                
                <div class="flex items-baseline gap-4 mb-6">
                    @if ($product->sale_price && $product->sale_price < $product->regular_price)
                        <span class="text-4xl font-display font-black text-primary">৳{{ number_format($product->price, 0) }}</span>
                        <span class="text-lg text-gray-300 line-through font-bold">৳{{ number_format($product->regular_price, 0) }}</span>
                    @else
                        <span class="text-4xl font-display font-black text-secondary">৳{{ number_format($product->price, 0) }}</span>
                    @endif
                </div>
                
                <p class="text-gray-500 leading-relaxed text-sm md:text-base mb-8 font-medium">
                    {{ $product->short_description }}
                </p>

                <!-- Urgency Bar -->
                <div class="mb-8 p-4 bg-orange-50 rounded-2xl border border-orange-100 flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></div>
                    <span class="text-[11px] font-black text-orange-700 uppercase tracking-widest">
                        Only {{ $product->stock_quantity }} items left in inventory!
                    </span>
                </div>
                
                <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <!-- Variant Selection: Touch Chips -->
                    <div class="space-y-8 mb-10">
                         <!-- Size -->
                         @php $sizes = $product->attributes()->where('attribute_name', 'size')->get(); @endphp
                         @if($sizes->isNotEmpty())
                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <label class="text-[11px] font-black text-secondary uppercase tracking-[0.2em]">Select Size</label>
                                    <button type="button" onclick="toggleSizeGuide()" class="text-[10px] font-bold text-primary underline">Size Guide</button>
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($sizes as $size)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="size" value="{{ $size->attribute_value }}" class="peer sr-only" required>
                                            <div class="min-w-[50px] h-12 flex items-center justify-center px-4 bg-gray-50 border-2 border-transparent rounded-2xl text-[13px] font-black text-gray-400 peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all active:scale-95">
                                                {{ $size->attribute_value }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                         @endif

                         <!-- Color -->
                         @php $colors = $product->attributes()->where('attribute_name', 'color')->get(); @endphp
                         @if($colors->isNotEmpty())
                            <div>
                                <label class="block text-[11px] font-black text-secondary uppercase tracking-[0.2em] mb-4">Choose Intensity (Color)</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($colors as $color)
                                        <label class="cursor-pointer" onclick="switchImageByColor('{{ $color->attribute_value }}')">
                                            <input type="radio" name="color" value="{{ $color->attribute_value }}" data-color="{{ strtolower($color->attribute_value) }}" class="peer sr-only" required>
                                            <div class="px-6 py-3 bg-gray-50 border-2 border-transparent rounded-2xl text-[12px] font-black text-gray-400 peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all active:scale-95">
                                                {{ $color->attribute_value }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                         @endif
                    </div>

                    <!-- Quantity (Desktop Only) -->
                    <div class="hidden md:flex items-center gap-6 mb-10">
                        <div class="flex items-center bg-gray-50 rounded-2xl p-1 border border-gray-100 shadow-inner shrink-0">
                             <button type="button" onclick="decrementQty()" class="w-12 h-12 flex items-center justify-center text-gray-400 hover:text-primary transition-colors"><i class="fas fa-minus"></i></button>
                             <input type="number" name="quantity" id="product-quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-12 text-center border-none bg-transparent font-black text-secondary focus:ring-0">
                             <button type="button" onclick="incrementQty()" class="w-12 h-12 flex items-center justify-center text-gray-400 hover:text-primary transition-colors"><i class="fas fa-plus"></i></button>
                        </div>
                        <button type="submit" class="flex-1 bg-gradient-to-r from-gray-900 to-gray-700 text-white font-black uppercase tracking-[0.2em] text-xs py-5 px-4 rounded-2xl hover:from-gray-800 hover:to-gray-600 hover:shadow-2xl hover:shadow-gray-900/20 transition-all transform active:scale-95 whitespace-nowrap add-to-cart-btn" data-product-id="{{ $product->id }}">
                             Add to Cart
                        </button>
                        <button type="button" onclick="buyNow()" class="flex-1 bg-gradient-to-r from-primary to-blue-600 text-white font-black uppercase tracking-[0.2em] text-xs py-5 px-4 rounded-2xl hover:from-blue-600 hover:to-blue-700 hover:shadow-2xl hover:shadow-primary/30 transition-all transform active:scale-95 whitespace-nowrap">
                             Buy Now
                        </button>
                    </div>
                </form>

                <!-- Trust Badges -->
                <div class="grid grid-cols-2 gap-4 pt-10 border-t border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-50 to-green-100 text-green-600 flex items-center justify-center text-lg shadow-sm"><i class="fas fa-truck-fast"></i></div>
                        <div>
                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Free Logistics</span>
                            <span class="text-xs font-bold text-secondary">Global Delivery</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 text-purple-600 flex items-center justify-center text-lg shadow-sm"><i class="fas fa-shield-check"></i></div>
                        <div>
                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Secure Manifest</span>
                            <span class="text-xs font-bold text-secondary">Verified Authentic</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Mobile CTA -->
    <div class="md:hidden fixed bottom-[64px] left-0 right-0 p-4 bg-white/90 backdrop-blur-xl border-t border-gray-100 z-50 animate-slide-in-up shadow-[0_-10px_40px_rgba(0,0,0,0.1)]">
        <div class="flex gap-3">
            <div class="flex items-center bg-gray-50 rounded-2xl p-1 px-3 border border-gray-100">
                 <button type="button" onclick="decrementQty()" class="w-8 h-8 flex items-center justify-center text-gray-400"><i class="fas fa-minus text-xs"></i></button>
                 <input type="number" id="mobile-qty" value="1" readonly class="w-8 text-center border-none bg-transparent font-black text-secondary text-sm p-0">
                 <button type="button" onclick="incrementQty()" class="w-8 h-8 flex items-center justify-center text-gray-400"><i class="fas fa-plus text-xs"></i></button>
            </div>
            <button type="button" class="flex-1 bg-gray-900 text-white font-black uppercase tracking-[0.2em] text-[10px] h-14 rounded-2xl shadow-lg active:scale-95 transition-transform add-to-cart-btn" data-product-id="{{ $product->id }}">
                Cart
            </button>
            <button type="button" onclick="buyNow()" class="flex-1 bg-primary text-white font-black uppercase tracking-[0.2em] text-[10px] h-14 rounded-2xl shadow-lg shadow-primary/30 active:scale-95 transition-transform">
                Buy Now
            </button>
        </div>
    </div>

    <!-- Details, Specs & Reviews (Tabbed Interface) -->
    <div class="container mx-auto px-4 mt-24 mb-24">
        <!-- Tab Navigation -->
        <div class="flex flex-wrap justify-start gap-8 border-b-2 border-gray-100 mb-12 relative">
            <button onclick="switchTab('description')" id="tab-btn-description" class="tab-btn pb-4 text-sm font-black uppercase tracking-widest text-secondary border-b-2 border-primary transition-all hover:text-primary relative top-[2px]">
                Description
            </button>
            <button onclick="switchTab('specs')" id="tab-btn-specs" class="tab-btn pb-4 text-sm font-bold uppercase tracking-widest text-gray-400 border-b-2 border-transparent transition-all hover:text-secondary relative top-[2px]">
                Data Sheet
            </button>
            <button onclick="switchTab('reviews')" id="tab-btn-reviews" class="tab-btn pb-4 text-sm font-bold uppercase tracking-widest text-gray-400 border-b-2 border-transparent transition-all hover:text-secondary relative top-[2px]">
                Reviews
            </button>
        </div>

        <!-- Tab Contents -->
        <div class="max-w-5xl mx-auto">
            
            <!-- Description Tab -->
            <div id="tab-content-description" class="tab-content animate-fade-in">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                    <div class="prose max-w-none text-gray-500 font-medium leading-[2] text-left">
                        <h4 class="text-lg font-bold text-secondary mb-4 flex items-center">
                            <i class="fas fa-info-circle text-primary mr-3"></i> Product Details
                        </h4>
                        {!! nl2br(e($product->description)) !!}
                    </div>
                    
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100">
                        <h4 class="text-lg font-bold text-secondary mb-6">Key Highlights</h4>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                <span class="text-sm text-gray-500 font-bold">Premium Quality Material Construction</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                <span class="text-sm text-gray-500 font-bold">Designed for Maximum Comfort & Durability</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                <span class="text-sm text-gray-500 font-bold">Lightweight & Breathable Design</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                                <span class="text-sm text-gray-500 font-bold">Easy Maintenance & Long-Lasting Wear</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Data Sheet (Specs) Tab -->
            <div id="tab-content-specs" class="tab-content hidden animate-fade-in">
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm max-w-3xl mx-auto">
                     <table class="w-full text-sm text-left">
                        <tbody>
                            <tr class="border-b border-gray-50 last:border-0">
                                <td class="py-4 font-bold text-gray-400 uppercase tracking-widest w-1/3">Material</td>
                                <td class="py-4 font-semibold text-secondary">Premium Composite Fiber</td>
                            </tr>
                            <tr class="border-b border-gray-50 last:border-0">
                                <td class="py-4 font-bold text-gray-400 uppercase tracking-widest">Weight</td>
                                <td class="py-4 font-semibold text-secondary">240g (Approx)</td>
                            </tr>
                            <tr class="border-b border-gray-50 last:border-0">
                                <td class="py-4 font-bold text-gray-400 uppercase tracking-widest">Origin</td>
                                <td class="py-4 font-semibold text-secondary">Designed in Italy, Assembled in Vietnam</td>
                            </tr>
                            <tr class="border-b border-gray-50 last:border-0">
                                <td class="py-4 font-bold text-gray-400 uppercase tracking-widest">Technology</td>
                                <td class="py-4 font-semibold text-secondary">CloudFoam™ Cushioning</td>
                            </tr>
                        </tbody>
                     </table>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div id="tab-content-reviews" class="tab-content hidden animate-fade-in">
                <div class="max-w-3xl mx-auto">
                    <!-- Review Summary -->
                    <div class="bg-gray-50 rounded-3xl p-8 mb-8">
                        @php
                            $avgRating = $product->reviews->avg('rating') ?? 0;
                            $totalReviews = $product->reviews->count();
                            $ratingCounts = [
                                5 => $product->reviews->where('rating', 5)->count(),
                                4 => $product->reviews->where('rating', 4)->count(),
                                3 => $product->reviews->where('rating', 3)->count(),
                                2 => $product->reviews->where('rating', 2)->count(),
                                1 => $product->reviews->where('rating', 1)->count(),
                            ];
                        @endphp
                        <div class="flex items-center gap-6 mb-6">
                            <div class="text-5xl font-black text-secondary">{{ number_format($avgRating, 1) }}</div>
                            <div>
                                <div class="flex text-yellow-400 text-sm mb-1">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= round($avgRating))
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star text-gray-300"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Based on {{ $totalReviews }} Reviews</span>
                            </div>
                        </div>
                        
                        <!-- Bars -->
                        <div class="space-y-2">
                            @foreach([5,4,3,2,1] as $star)
                            @php $percentage = $totalReviews > 0 ? ($ratingCounts[$star] / $totalReviews) * 100 : 0; @endphp
                            <div class="flex items-center gap-3 text-xs">
                                <span class="font-bold text-gray-400 w-3">{{ $star }}</span>
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-secondary rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <button onclick="document.getElementById('write-review-form').classList.toggle('hidden')" class="w-full mt-6 py-3 bg-white border-2 border-secondary text-secondary font-black uppercase tracking-widest text-xs rounded-xl hover:bg-secondary hover:text-white transition-all">
                            Write A Review
                        </button>
                    </div>

                    <!-- Write Review Form -->
                    <form id="write-review-form" action="{{ route('review.store') }}" method="POST" class="hidden bg-white border border-gray-100 rounded-3xl p-6 shadow-xl mb-8 animate-fade-in-up">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <h4 class="font-bold text-secondary mb-4">Share you experience</h4>
                        
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Rating</label>
                            <div class="flex gap-2">
                                @for($i=1; $i<=5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="peer sr-only">
                                    <i class="fas fa-star text-2xl text-gray-200 peer-checked:text-yellow-400 transition-colors hover:text-yellow-200"></i>
                                </label>
                                @endfor
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Review</label>
                            <textarea name="review_text" rows="3" class="w-full bg-gray-50 border-none rounded-xl p-4 text-sm focus:ring-2 focus:ring-primary/20" placeholder="How was the product?"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full py-3 bg-primary text-white font-black uppercase tracking-widest text-xs rounded-xl hover:bg-blue-600 transition-all">Submit Review</button>
                    </form>

                    <!-- Reviews List -->
                    <div class="space-y-6">
                        @forelse($product->reviews as $review)
                        <div class="border-b border-gray-100 pb-6 last:border-0">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
                                        {{ substr($review->user->name ?? 'Guest', 0, 2) }}
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-secondary text-sm">{{ $review->user->name ?? 'Guest' }}</h5>
                                        <span class="text-[10px] text-gray-400">Verified Buyer</span>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-300">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex text-yellow-400 text-[10px] mb-2">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-gray-500 text-sm leading-relaxed">{{ $review->review_text }}</p>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-400">
                            <i class="far fa-comment-dots text-4xl mb-3 opacity-50"></i>
                            <p>No reviews yet. Be the first to share your thoughts!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>      <!-- Related -->
    <div class="container mx-auto px-4 mt-24 mb-24">
        <h2 class="text-3xl font-playfair font-bold text-secondary mb-8 text-center">You May Also Like</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($relatedProducts as $related)
                 <x-product-card :product="$related" />
            @endforeach
        </div>
    </div>
</div>

<!-- Size Guide Modal -->
<div id="size-guide-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-300" onclick="if(event.target === this) toggleSizeGuide()">
    <div class="bg-white rounded-3xl w-full max-w-2xl m-4 p-8 relative shadow-2xl transform scale-95 transition-transform duration-300" id="size-guide-content">
        <button onclick="toggleSizeGuide()" class="absolute top-4 right-4 w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-secondary transition-all">
            <i class="fas fa-times"></i>
        </button>
        
        <h3 class="text-2xl font-playfair font-bold text-secondary mb-2 text-center">Size Guide</h3>
        <p class="text-center text-gray-400 text-sm mb-8">Find your perfect fit</p>
        
        <div class="overflow-x-auto">
            <table class="w-full text-center text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase tracking-widest text-[10px]">
                        <th class="py-4 rounded-l-xl">EU</th>
                        <th class="py-4">US (Men)</th>
                        <th class="py-4">US (Women)</th>
                        <th class="py-4">UK</th>
                        <th class="py-4 rounded-r-xl">CM</th>
                    </tr>
                </thead>
                <tbody class="text-secondary font-bold">
                    <tr class="border-b border-gray-50"><td class="py-3">36</td><td>4</td><td>5.5</td><td>3.5</td><td>23</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-3">37</td><td>4.5</td><td>6</td><td>4</td><td>23.5</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-3">38</td><td>5.5</td><td>7</td><td>5</td><td>24</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-3">39</td><td>6.5</td><td>8</td><td>6</td><td>24.5</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-3">40</td><td>7</td><td>8.5</td><td>6</td><td>25</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-3">41</td><td>8</td><td>9.5</td><td>7</td><td>26</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-3">42</td><td>8.5</td><td>10</td><td>7.5</td><td>26.5</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-3">43</td><td>9.5</td><td>11</td><td>8.5</td><td>27.5</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-3">44</td><td>10</td><td>11.5</td><td>9</td><td>28</td></tr>
                    <tr class="border-b border-gray-50"><td class="py-3">45</td><td>11</td><td>12.5</td><td>10</td><td>29</td></tr>
                </tbody>
            </table>
        </div>
        
        <div class="mt-8 bg-blue-50 p-4 rounded-2xl flex gap-4 items-start">
             <i class="fas fa-info-circle text-primary mt-1"></i>
             <p class="text-xs text-blue-800 leading-relaxed">
                 <strong>Pro Tip:</strong> If you are between sizes, we generally recommend sizing up for a more comfortable fit, especially for performance footwear.
             </p>
        </div>
    </div>
</div>

<!-- 360 View Modal -->
<div id="view-360-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 backdrop-blur-md opacity-0 transition-opacity duration-300" onclick="if(event.target === this) close360View()">
    <div class="relative w-full max-w-4xl aspect-video bg-white rounded-3xl overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300" id="view-360-content">
        <button onclick="close360View()" class="absolute top-6 right-6 z-50 w-12 h-12 bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-black rounded-full flex items-center justify-center transition-all cursor-pointer">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="absolute inset-0 flex items-center justify-center flex-col text-center p-10">
            <i class="fas fa-cube text-6xl text-gray-200 mb-6 animate-spin-slow"></i>
            <h3 class="text-2xl font-bold text-secondary mb-2">360° View Loading</h3>
            <p class="text-gray-400">Interact with the product in 3D space.</p>
            <!-- Placeholder for actual 360 viewer implementation -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/drift-zoom@1.5.1/dist/Drift.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/drift-zoom@1.5.1/dist/drift-basic.min.css">
<style>
    .drift-pane {
        position: absolute;
        width: 150%;
        height: 100%;
        z-index: 100;
        background: white;
        border: 1px solid #f3f4f6;
        border-radius: 1.5rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        pointer-events: none; /* Let clicks pass through if needed, though usually pane captures mouse */
    }
    .drift-zoom-pane {
        width: 100%;
        height: 100%;
    }
    /* Custom lens style */
    .drift-bounding-box {
        background-color: rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
</style>
<script>
    // Initialize Drift Zoom on Swiper Images
    function initDrift() {
        const images = document.querySelectorAll('.zoomable');
        const paneContainer = document.querySelector('.drift-host');
        
        images.forEach(img => {
            // Check if already initialized to avoid duplicates
            if (img.dataset.driftInitialized) return;
            
            new Drift(img, {
                paneContainer: paneContainer,
                inlinePane: false,
                containInline: true,
                hoverBoundingBox: true,
                zoomFactor: 3,
                touchDelay: 500
            });
            
            img.dataset.driftInitialized = 'true';
        });
    }

    var thumbsSwiper = new Swiper(".thumbsSwiper", {
        spaceBetween: 16,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
        breakpoints: {
            768: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 5,
            },
        },
    });

    // Swiper changes might need re-init or just work if we target all slides
    var swiper = new Swiper(".mainSwiper", {
        spaceBetween: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: thumbsSwiper,
        },
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
        },
        on: {
            init: function () {
                setTimeout(initDrift, 100);
            },
        },
    });

    function incrementQty() {
        const input = document.getElementById('product-quantity');
        const mobileInput = document.getElementById('mobile-qty');
        const max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
            mobileInput.value = input.value;
        }
    }
    
    function decrementQty() {
        const input = document.getElementById('product-quantity');
        const mobileInput = document.getElementById('mobile-qty');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            mobileInput.value = input.value;
        }
    }

    function buyNow() {
        // Create a temporary form to submit buy now request
        // Ideally handled by backend, but we can simulate adding to cart then redirecting
        const form = document.getElementById('add-to-cart-form');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'redirect_checkout';
        input.value = '1';
        form.appendChild(input);
        form.submit();
    }

    function open360View() {
        const modal = document.getElementById('view-360-modal');
        const content = document.getElementById('view-360-content');
        modal.classList.remove('hidden');
        // Small delay to allow display:block to apply before opacity transition
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function toggleSizeGuide() {
        const modal = document.getElementById('size-guide-modal');
        const content = document.getElementById('size-guide-content');
        
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        } else {
            modal.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    }

    function close360View() {
        const modal = document.getElementById('view-360-modal');
        const content = document.getElementById('view-360-content');
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function switchImageByColor(color) {
        console.log('Switching to color:', color);
        // Find slide with matching data-color in the main slider
        const slides = document.querySelectorAll('.mainSwiper .swiper-slide');
        let found = false;
        for (let i = 0; i < slides.length; i++) {
            const slideColor = slides[i].dataset.color;
            if (slideColor && slideColor.toLowerCase() === color.toLowerCase()) {
                console.log('Found match at index:', i);
                swiper.slideTo(i);
                found = true;
                break;
            }
        }
        if (!found) {
            console.log('No matching image found for color:', color);
        }
    }

    function switchTab(tabName) {
        // Reset all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-secondary', 'border-primary', 'font-black');
            btn.classList.add('text-gray-400', 'border-transparent', 'font-bold');
        });

        // Activate clicked button
        const activeBtn = document.getElementById(`tab-btn-${tabName}`);
        activeBtn.classList.remove('text-gray-400', 'border-transparent', 'font-bold');
        activeBtn.classList.add('text-secondary', 'border-primary', 'font-black');

        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Show active content
        document.getElementById(`tab-content-${tabName}`).classList.remove('hidden');
    }
</script>
@endpush