@extends('layouts.app')

@section('title', 'My Wishlist - ' . config('app.name'))

@section('content')
<div class="bg-[#f4f7fe] min-h-screen py-12 md:py-20 relative overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px] -ml-64 -mt-64 z-0"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-500/5 rounded-full blur-[120px] -mr-64 -mb-64 z-0"></div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Section Header -->
        <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <span class="inline-block px-3 py-1 bg-primary/5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase mb-4 border border-primary/10 text-primary uppercase">Saved Items</span>
                <h1 class="text-4xl md:text-5xl font-display font-extrabold tracking-tight text-secondary">
                    My Wishlist <span class="text-gray-300 font-light ml-2">/ {{ $wishlistItems->total() }} items</span>
                </h1>
            </div>
            
            @if($wishlistItems->count() > 0)
                <form action="{{ route('wishlist.clear') }}" method="POST" id="clear-wishlist-form">
                    @csrf
                    <button type="submit" class="group flex items-center gap-3 px-6 py-3 bg-white rounded-2xl border border-white hover:border-red-100 hover:bg-red-50 transition-all shadow-sm">
                        <i class="fas fa-trash-alt text-gray-400 group-hover:text-red-500 transition-colors"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-500 group-hover:text-red-600">Clear All Favorites</span>
                    </button>
                </form>
            @endif
        </div>

        @if($wishlistItems->isEmpty())
            <div class="bg-white rounded-[2.5rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.05)] p-20 text-center border border-white animate-fade-in-up max-w-2xl mx-auto">
                <div class="w-32 h-32 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-8 relative">
                    <div class="absolute inset-0 bg-primary/10 rounded-[2rem] animate-pulse"></div>
                    <i class="far fa-heart text-5xl text-gray-200 relative z-10"></i>
                </div>
                <h3 class="text-2xl font-display font-bold text-secondary mb-3 transition-colors">Wishlist is Empty</h3>
                <p class="text-gray-400 mb-10 text-sm max-w-sm mx-auto font-medium">You haven't saved any items yet. Start exploring our collections to find your perfect match.</p>
                <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-10 py-5 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-1 transition-all">
                    Explore Shop <i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($wishlistItems as $item)
                    @php $product = $item->product; @endphp
                    <div class="group relative bg-white rounded-[2.5rem] p-4 border border-white hover:border-primary/20 transition-all duration-500 hover:shadow-[0_40px_100px_-20px_rgba(0,0,0,0.1)] animate-fade-in-up">
                        <!-- Quick Remove -->
                        <button class="absolute top-6 right-6 w-10 h-10 bg-white/80 backdrop-blur-md rounded-xl flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-white transition-all shadow-sm z-20 remove-wishlist-item" data-product-id="{{ $product->id }}">
                            <i class="fas fa-times"></i>
                        </button>

                        <!-- Product Visual -->
                        <div class="relative aspect-[4/5] bg-[#F8FAFC] rounded-[2rem] overflow-hidden mb-6 group-hover:shadow-inner transition-all">
                            <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
                                <img src="{{ getProductImage($product->images->first()?->image_path ?? $product->featured_image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                            </a>
                            
                            <!-- Quick Action Overlay -->
                            <div class="absolute inset-x-4 bottom-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                                @if($product->stock_quantity > 0)
                                    <button class="w-full bg-secondary text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-3 hover:bg-primary transition-all add-to-cart-btn" 
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-price="{{ $product->sale_price ?? $product->regular_price }}"
                                            data-product-image="{{ getProductImage($product->images->first()?->image_path ?? $product->featured_image) }}">
                                        <i class="fas fa-shopping-bag text-sm"></i> Add to Bag
                                    </button>
                                @else
                                    <div class="w-full bg-gray-200 text-gray-400 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center cursor-not-allowed">
                                        Out of Stock
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="px-2 pb-2">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[9px] font-black text-gray-300 uppercase tracking-[0.2em]">{{ $product->brand->name ?? 'Premium' }}</span>
                                @if($product->sale_price)
                                    <span class="px-2 py-0.5 bg-accent/10 text-accent text-[8px] font-black rounded-md uppercase tracking-wider">-{{ round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100) }}% Off</span>
                                @endif
                            </div>
                            <h3 class="text-lg font-display font-bold text-secondary mb-3 line-clamp-1 group-hover:text-primary transition-colors">
                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <div class="flex items-center gap-3">
                                <span class="text-xl font-display font-black text-secondary">৳{{ number_format($product->sale_price ?? $product->regular_price, 0) }}</span>
                                @if($product->sale_price)
                                    <span class="text-xs text-gray-300 line-through font-bold">৳{{ number_format($product->regular_price, 0) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-16 pagination-container">
                {{ $wishlistItems->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Custom handling for wishlist page if needed, 
    // but main.js delegated events should handle basic actions.
});
</script>
@endpush
