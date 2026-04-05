@extends('layouts.app')

@section('title', 'Shop - ' . config('app.name'))

@section('content')
@php
    $getColorHex = function($colorName) {
        $colorMap = [
            'Red' => '#FF0000', 'Blue' => '#0000FF', 'Green' => '#00FF00',
            'Yellow' => '#FFFF00', 'Pink' => '#FFC0CB', 'Purple' => '#800080',
            'Orange' => '#FFA500', 'Black' => '#000000', 'White' => '#FFFFFF',
            'Gray' => '#808080', 'Brown' => '#A52A2A',
        ];
        return $colorMap[$colorName] ?? '#' . substr(md5($colorName), 0, 6);
    };
@endphp

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css">
<style>
    .noUi-target {
        background: #f1f5f9;
        border: none;
        box-shadow: none;
        height: 4px;
        margin-bottom: 25px;
        margin-top: 15px;
    }
    .noUi-connect {
        background: var(--primary);
    }
    .noUi-handle {
        width: 18px !important;
        height: 18px !important;
        right: -9px !important;
        top: -7px !important;
        background: #fff;
        border: 2px solid var(--primary);
        border-radius: 50%;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        cursor: grab;
    }
    .noUi-handle:before, .noUi-handle:after { display: none; }
    .noUi-handle:active { cursor: grabbing; scale: 1.1; }
    
    .sidebar-section {
        border-bottom: 1px solid #f8fafc;
        padding-bottom: 2rem;
        margin-bottom: 2rem;
    }
    .sidebar-section:last-child { border-bottom: none; }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        user-select: none;
    }
    .section-header i.fa-chevron-up {
        transition: transform 0.3s ease;
        font-size: 10px;
        color: #94a3b8;
    }
    .section-header.collapsed i.fa-chevron-up { transform: rotate(180deg); }
    .section-content {
        transition: all 0.3s ease-out;
        overflow: hidden;
    }
    .section-content.collapsed {
        max-height: 0;
        opacity: 0;
        margin-top: 0;
    }
</style>
@endpush

<div class="bg-[#f8faff] min-h-screen py-8 relative">
    <!-- ... Background and Title content stays similar ... -->
    <div class="absolute top-0 left-0 w-full h-[600px] overflow-hidden z-0 pointer-events-none opacity-40">
        <div class="absolute top-[-100px] left-[-100px] w-96 h-96 bg-primary/10 rounded-full blur-[150px]"></div>
        <div class="absolute top-[200px] right-[-50px] w-64 h-64 bg-accent/5 rounded-full blur-[100px]"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Breadcrumb & Title -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
            <div>
                <nav class="mb-4 flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Digital Home</a>
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <span class="text-secondary text-gray-900">Elite Collection</span>
                </nav>
                <h1 class="text-4xl md:text-6xl font-playfair font-black text-secondary leading-none">
                    Discover <span class="text-primary italic">Style</span>
                </h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative group">
                    <select id="sort-select" class="appearance-none bg-white border border-gray-100 px-8 py-4 pr-12 rounded-2xl text-sm font-bold text-secondary shadow-sm focus:ring-2 focus:ring-primary/20 outline-none cursor-pointer transition-all hover:shadow-md">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Latest Arrivals</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none transition-transform group-hover:translate-y-[-40%]"></i>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Sidebar Filters -->
            <aside id="shop-sidebar" class="fixed inset-0 z-[110] lg:relative lg:inset-auto lg:z-0 lg:w-[28%] transform -translate-x-full lg:translate-x-0 transition-all duration-500 ease-out lg:opacity-100 opacity-0 invisible lg:visible">
                <div class="absolute inset-0 bg-secondary/40 backdrop-blur-sm lg:hidden transition-opacity" onclick="toggleShopSidebar()"></div>
                <div class="bg-white h-full lg:h-auto lg:rounded-[2.5rem] shadow-2xl lg:shadow-[0_40px_100px_-20px_rgba(0,0,0,0.05)] border-r lg:border border-gray-100 p-8 lg:p-10 relative z-10 w-[85%] max-w-[400px] lg:w-full overflow-y-auto lg:sticky lg:top-32">
                    <div class="flex justify-between items-center mb-12">
                        <h2 class="text-2xl font-playfair font-black text-secondary uppercase tracking-tight">Gallery Filter</h2>
                        <button class="lg:hidden w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400" onclick="toggleShopSidebar()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <form id="filter-form">
                        <!-- Search -->
                        <div class="sidebar-section">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Search Catalog</label>
                            <div class="relative group">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Find your pair..." class="w-full pl-12 pr-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none transition-all group-hover:bg-gray-100 font-medium text-sm">
                                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 transition-colors group-focus-within:text-primary"></i>
                            </div>
                        </div>
                        
                        <!-- Price Range Slider -->
                        <div class="sidebar-section">
                            <div class="section-header" onclick="toggleSection(this)">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Price Intent</label>
                                <i class="fas fa-chevron-up"></i>
                            </div>
                            <div class="section-content mt-6">
                                <div id="price-slider" class="mx-2"></div>
                                <div class="flex justify-between items-center text-[11px] font-black text-secondary uppercase tracking-widest mt-2">
                                    <span id="price-min-label">৳{{ number_format($dbMinPrice) }}</span>
                                    <span id="price-max-label">৳{{ number_format($dbMaxPrice) }}</span>
                                </div>
                                <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price', $dbMinPrice) }}">
                                <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price', $dbMaxPrice) }}">
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="sidebar-section">
                            <div class="section-header" onclick="toggleSection(this)">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Elite Categories</label>
                                <i class="fas fa-chevron-up"></i>
                            </div>
                            <div class="section-content mt-6 flex flex-wrap gap-2">
                                <label class="cursor-pointer">
                                    <input type="radio" name="category" value="" class="peer sr-only" {{ !request('category') ? 'checked' : '' }}>
                                    <span class="px-5 py-2.5 rounded-xl border border-gray-100 text-[10px] font-bold text-gray-400 bg-gray-50 peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary transition-all inline-block uppercase tracking-wider hover:border-primary/30">All</span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="category" value="{{ $cat->slug }}" class="peer sr-only" {{ request('category') == $cat->slug ? 'checked' : '' }}>
                                        <span class="px-5 py-2.5 rounded-xl border border-gray-100 text-[10px] font-bold text-gray-400 bg-gray-50 peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary transition-all inline-block uppercase tracking-wider hover:border-primary/30">{{ $cat->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Brand -->
                        <div class="sidebar-section">
                            <div class="section-header" onclick="toggleSection(this)">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Curated Brands</label>
                                <i class="fas fa-chevron-up"></i>
                            </div>
                            <div class="section-content mt-6 space-y-3">
                                @foreach($brands as $brand)
                                    <label class="flex items-center justify-between cursor-pointer group">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="brand_ids[]" value="{{ $brand->id }}" class="peer sr-only" {{ in_array($brand->id, request('brand_ids', [])) ? 'checked' : '' }}>
                                            <span class="w-5 h-5 rounded-md border-2 border-gray-100 mr-4 peer-checked:bg-primary peer-checked:border-primary flex items-center justify-center transition-all group-hover:border-primary/50 text-white text-[10px]">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text-xs font-bold text-gray-400 peer-checked:text-secondary group-hover:text-secondary transition-colors uppercase tracking-widest">{{ $brand->name }}</span>
                                        </div>
                                        <span class="text-[9px] font-black text-gray-300 group-hover:text-primary transition-colors opacity-0 group-hover:opacity-100 tracking-tighter">SELECT</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Color -->
                        <div class="sidebar-section">
                            <div class="section-header" onclick="toggleSection(this)">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Select Shade</label>
                                <i class="fas fa-chevron-up"></i>
                            </div>
                            <div class="section-content mt-6 flex flex-wrap gap-3">
                                @foreach($availableColors as $color)
                                    <label class="cursor-pointer relative group">
                                        <input type="radio" name="color" value="{{ $color->attribute_value }}" class="peer sr-only" {{ request('color') == $color->attribute_value ? 'checked' : '' }}>
                                        <span class="block w-9 h-9 rounded-full border-4 border-white shadow-md ring-1 ring-gray-100 peer-checked:ring-primary transition-all transform hover:scale-110 active:scale-95" style="background-color: {{ $getColorHex($color->attribute_value) }}"></span>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 px-3 py-1.5 bg-secondary text-white text-[8px] font-black rounded-lg opacity-0 group-hover:opacity-100 transition-all pointer-events-none whitespace-nowrap shadow-xl translate-y-2 group-hover:translate-y-0 uppercase tracking-widest">
                                            {{ $color->attribute_value }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Size -->
                        <div class="sidebar-section">
                            <div class="section-header" onclick="toggleSection(this)">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Perfect Fit</label>
                                <i class="fas fa-chevron-up"></i>
                            </div>
                            <div class="section-content mt-6 grid grid-cols-4 gap-2">
                                @foreach($availableSizes as $size)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="size" value="{{ $size->attribute_value }}" class="peer sr-only" {{ request('size') == $size->attribute_value ? 'checked' : '' }}>
                                        <span class="flex items-center justify-center aspect-square rounded-xl border border-gray-100 text-[10px] font-black text-gray-400 bg-gray-50 peer-checked:bg-secondary peer-checked:text-white peer-checked:border-secondary transition-all hover:border-gray-300 uppercase shadow-sm active:scale-90">{{ $size->attribute_value }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-4 flex flex-col gap-4">
                            <button type="submit" class="hidden">Apply</button>
                            <a href="{{ route('shop') }}" class="w-full py-4 rounded-2xl bg-gray-50 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:bg-red-50 hover:text-red-500 transition-all active:scale-95 shadow-sm">Reset Architecture</a>
                        </div>
                    </form>
                </div>
            </aside>
            
            <!-- Product Section -->
            <main class="lg:w-full">
                <!-- Active Filters & Meta -->
                <div class="flex flex-col gap-8 mb-12">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div id="results-meta" class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">
                            Found <span class="text-secondary text-primary">{{ $products->total() }}</span> unique silhouettes
                        </div>
                        
                        <div class="flex items-center gap-6">
                            <div id="active-filters" class="flex flex-wrap gap-3">
                                @if(request('category'))
                                    <div class="flex items-center gap-3 px-5 py-2.5 bg-white rounded-full border border-gray-100 text-[9px] font-black text-secondary uppercase tracking-[0.1em] shadow-sm group hover:border-primary/20 transition-all">
                                        <span class="opacity-50 tracking-normal font-medium">Type:</span> {{ request('category') }}
                                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="text-gray-300 hover:text-red-500 transition-colors"><i class="fas fa-times"></i></a>
                                    </div>
                                @endif
                                @if(request('color'))
                                    <div class="flex items-center gap-3 px-5 py-2.5 bg-white rounded-full border border-gray-100 text-[9px] font-black text-secondary uppercase tracking-[0.1em] shadow-sm group hover:border-primary/20 transition-all">
                                        <span class="opacity-50 tracking-normal font-medium">Shade:</span> {{ request('color') }}
                                        <a href="{{ request()->fullUrlWithQuery(['color' => null]) }}" class="text-gray-300 hover:text-red-500 transition-colors"><i class="fas fa-times"></i></a>
                                    </div>
                                @endif
                                @if(request()->anyFilled(['category', 'brand', 'brand_ids', 'search', 'min_price', 'max_price', 'size', 'color']))
                                    <a href="{{ route('shop') }}" class="text-[9px] font-black text-gray-300 uppercase tracking-widest hover:text-red-500 border-b border-dashed border-gray-200 hover:border-red-200 transition-all ml-4">Clean Dataset</a>
                                @endif
                            </div>

                            <button class="lg:hidden flex items-center gap-4 px-8 py-4 bg-white rounded-2xl shadow-xl shadow-secondary/5 border border-gray-50 text-[10px] font-black text-secondary uppercase tracking-[0.3em] active:scale-95 transition-all" onclick="toggleShopSidebar()">
                                <i class="fas fa-sliders-h text-primary"></i> Filter
                            </button>
                        </div>
                    </div>

                    @if(request('search'))
                        <div class="flex items-baseline gap-4 py-8 border-y border-gray-50">
                            <span class="text-gray-400 text-sm font-medium italic tracking-wide">Dataset inquiry for</span>
                            <span class="text-3xl md:text-5xl font-playfair font-black text-secondary uppercase">"{{ request('search') }}"</span>
                        </div>
                    @endif
                </div>
                
                <!-- Grid Wrapper with Premium Shimmer -->
                <div class="relative group/grid min-h-[600px]">
                    <div id="grid-loader" class="absolute inset-0 bg-white/40 backdrop-blur-[2px] z-50 flex items-center justify-center opacity-0 invisible transition-all duration-500 rounded-[2.5rem]">
                        <div class="relative w-20 h-20">
                            <div class="absolute inset-0 border-4 border-primary/10 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-t-primary rounded-full animate-spin"></div>
                            <i class="fas fa-shoe-prints absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-primary/40 text-xl animate-pulse"></i>
                        </div>
                    </div>

                    <div id="products-grid-container" class="grid grid-cols-2 lg:grid-cols-3 gap-6 md:gap-12 transition-opacity duration-500 ease-in-out">
                        @include('partials.product-grid')
                    </div>
                </div>
                
                <!-- Pagination -->
                <div id="pagination-container" class="mt-24">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </main>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
<script>
    function toggleSection(header) {
        header.classList.toggle('collapsed');
        const content = header.nextElementSibling;
        content.classList.toggle('collapsed');
    }

    function toggleShopSidebar() {
        const sidebar = document.getElementById('shop-sidebar');
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('opacity-0');
        sidebar.classList.toggle('invisible');
        document.body.classList.toggle('overflow-hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filter-form');
        const sortSelect = document.getElementById('sort-select');
        const gridContainer = document.getElementById('products-grid-container');
        const paginationContainer = document.getElementById('pagination-container');
        const metaContainer = document.getElementById('results-meta');
        const loader = document.getElementById('grid-loader');
        
        // noUiSlider Initialization
        const priceSlider = document.getElementById('price-slider');
        const minInput = document.getElementById('min_price');
        const maxInput = document.getElementById('max_price');
        const minLabel = document.getElementById('price-min-label');
        const maxLabel = document.getElementById('price-max-label');

        if (priceSlider) {
            noUiSlider.create(priceSlider, {
                start: [{{ request('min_price', $dbMinPrice) }}, {{ request('max_price', $dbMaxPrice) }}],
                connect: true,
                range: { 'min': {{ $dbMinPrice }}, 'max': {{ $dbMaxPrice }} },
                step: 10,
                format: {
                    to: value => Math.round(value),
                    from: value => value
                }
            });

            priceSlider.noUiSlider.on('update', function(values, handle) {
                if (handle === 0) {
                    minInput.value = values[0];
                    minLabel.innerHTML = '৳' + Number(values[0]).toLocaleString();
                } else {
                    maxInput.value = values[1];
                    maxLabel.innerHTML = '৳' + Number(values[1]).toLocaleString();
                }
            });

            priceSlider.noUiSlider.on('change', updateResults);
        }

        let timeout = null;

        function updateResults() {
            loader.classList.remove('invisible', 'opacity-0');
            gridContainer.classList.add('opacity-40', 'scale-[0.99]');

            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            params.set('sort', sortSelect.value);

            const fetchUrl = `{{ route('shop') }}?${params.toString()}`;

            fetch(fetchUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                gridContainer.innerHTML = data.products_html;
                paginationContainer.innerHTML = data.pagination_html;
                metaContainer.innerHTML = data.showing_text;
                
                window.history.pushState({}, '', fetchUrl);
                bindPagination();
                
                // Refresh Swatches if needed (optional)
            })
            .finally(() => {
                setTimeout(() => {
                    loader.classList.add('invisible', 'opacity-0');
                    gridContainer.classList.remove('opacity-40', 'scale-[0.99]');
                }, 300);
            });
        }

        function bindPagination() {
            paginationContainer.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    loader.classList.remove('invisible', 'opacity-0');
                    gridContainer.classList.add('opacity-40');

                    fetch(this.href, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        gridContainer.innerHTML = data.products_html;
                        paginationContainer.innerHTML = data.pagination_html;
                        metaContainer.innerHTML = data.showing_text;
                        window.history.pushState({}, '', this.href);
                        bindPagination();
                        window.scrollTo({ top: 300, behavior: 'smooth' });
                    })
                    .finally(() => {
                        loader.classList.add('invisible', 'opacity-0');
                        gridContainer.classList.remove('opacity-40');
                    });
                });
            });
        }

        // Event Listeners
        filterForm.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
            input.addEventListener('change', updateResults);
        });

        const searchInput = filterForm.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(updateResults, 800);
            });
        }

        sortSelect.addEventListener('change', updateResults);
        bindPagination();
    });
</script>
@endpush
@endsection