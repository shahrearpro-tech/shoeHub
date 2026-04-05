@props(['product'])

@php
    $rating = \App\Models\Review::where('product_id', $product->id)->avg('rating');
    $price = $product->price;
    $comparePrice = $product->sale_price ? $product->regular_price : null;
    $hasDiscount = $comparePrice > $price;
    $discountPercent = $hasDiscount ? round((($comparePrice - $price) / $comparePrice) * 100) : 0;
    
    // Get colors and sizes from loaded attributes collection (requires eager loading)
    $colors = $product->attributes->where('attribute_name', 'color');
    $sizes = $product->attributes->where('attribute_name', 'size');
    
    $getColorHex = function($colorName) {
        $colorMap = [
            'Red' => '#FF0000', 'Blue' => '#0000FF', 'Green' => '#00FF00',
            'Yellow' => '#FFFF00', 'Pink' => '#FFC0CB', 'Purple' => '#800080',
            'Orange' => '#FFA500', 'Black' => '#000000', 'White' => '#FFFFFF',
            'Gray' => '#808080', 'Brown' => '#A52A2A',
        ];
        return $colorMap[$colorName] ?? '#' . substr(md5($colorName), 0, 6);
    };

    $mainImage = $product->featured_image;
    $secondaryImage = $product->images->where('is_featured', false)->first();
    $secondaryImagePath = $secondaryImage ? $secondaryImage->image_path : null;
@endphp

<div class="product-card group bg-white rounded-2xl overflow-hidden relative hover:shadow-2xl transition-all duration-500 border border-gray-100 flex flex-col h-full">
    <!-- Product Image -->
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-50 to-white aspect-[4/5]">
        <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
            @if ($mainImage)
                <img src="{{ getProductImage($mainImage) }}" 
                     alt="{{ $product->name }}"
                     loading="lazy"
                     decoding="async"
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-all duration-700 {{ $secondaryImagePath ? 'group-hover:opacity-0' : '' }}">
                
                @if ($secondaryImagePath)
                    <img src="{{ getProductImage($secondaryImagePath) }}" 
                         alt="{{ $product->name }}"
                         loading="lazy"
                         decoding="async"
                         class="absolute inset-0 w-full h-full object-cover transform scale-110 opacity-0 group-hover:opacity-100 transition-all duration-700">
                @endif
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                    <i class="fas fa-image text-4xl"></i>
                </div>
            @endif
        </a>
        
        <!-- Badges -->
        <div class="absolute top-3 left-3 z-10 flex flex-col gap-2">
            @if ($hasDiscount)
                <span class="bg-accent text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-sm">
                    -{{ $discountPercent }}%
                </span>
            @endif
            
            @if ($product->is_new)
                <span class="bg-blue-500 text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-sm">
                    NEW
                </span>
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="absolute top-3 right-3 flex flex-col gap-2 transition-all duration-300 z-10 lg:translate-x-10 lg:opacity-0 group-hover:translate-x-0 group-hover:opacity-100">
            <button class="w-8 h-8 md:w-9 md:h-9 bg-white rounded-full shadow-md flex items-center justify-center text-gray-600 hover:text-red-500 hover:bg-red-50 transition-colors add-to-wishlist-btn" 
                    data-product-id="{{ $product->id }}" title="Add to Wishlist">
                <i class="far fa-heart text-sm md:text-base"></i>
            </button>
            <button class="w-8 h-8 md:w-9 md:h-9 bg-white rounded-full shadow-md flex items-center justify-center text-gray-600 hover:text-primary hover:bg-blue-50 transition-colors quick-view-btn" 
                    data-product="{{ json_encode($product) }}" 
                    title="Quick View">
                <i class="far fa-eye text-sm md:text-base"></i>
            </button>
        </div>

        <!-- Quick Add Options -->
        @if ($sizes->isNotEmpty())
            <div class="absolute bottom-0 left-0 w-full bg-white/95 backdrop-blur-sm p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300 border-t border-gray-100">
                <div class="flex justify-center flex-wrap gap-2">
                    @foreach ($sizes->take(4) as $size)
                        <button class="w-8 h-8 rounded border border-gray-200 text-xs font-semibold hover:border-primary hover:text-primary transition add-to-cart-btn"
                                data-product-id="{{ $product->id }}" 
                                data-size="{{ $size->attribute_value }}">
                            {{ $size->attribute_value }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    
    <!-- Product Info -->
    <div class="p-4 flex flex-col flex-1">
        <div class="mb-1">
             <!-- Color Swatches -->
            @if ($colors->isNotEmpty())
                <div class="flex gap-1.5 mb-2">
                    @foreach ($colors->take(5) as $color)
                        <button class="w-4 h-4 rounded-full border border-gray-200 hover:scale-110 transition-all product-color-swatch focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary"
                             style="background-color: {{ $getColorHex($color->attribute_value) }};"
                             title="{{ $color->attribute_value }}"
                             data-color="{{ $color->attribute_value }}">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <h3 class="font-display font-bold text-gray-800 text-base mb-1 line-clamp-1 group-hover:text-primary transition-colors">
            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
        </h3>
        
        <div class="mt-auto pt-2 flex items-center justify-between">
            <div class="flex flex-col">
                @if ($hasDiscount)
                    <span class="text-xs text-gray-400 line-through">৳{{ number_format($comparePrice, 0) }}</span>
                    <span class="text-lg font-bold text-gray-900">৳{{ number_format($price, 0) }}</span>
                @else
                    <span class="text-lg font-bold text-gray-900">৳{{ number_format($price, 0) }}</span>
                @endif
            </div>
            
            <button class="w-10 h-10 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-sm hover:shadow-lg add-to-cart-btn"
                    data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}"
                    data-product-price="{{ $price }}"
                    data-product-image="{{ $mainImage ? getProductImage($mainImage) : '' }}"
                    data-description="{{ Str::limit(strip_tags($product->description), 150) }}"
                    data-slug="{{ $product->slug }}"
                    data-colors='{{ $colors->toJson() }}'
                    data-sizes='{{ $sizes->toJson() }}'
                    title="Add to Cart">
                <i class="fas fa-shopping-bag"></i>
            </button>
        </div>
    </div>
</div>
