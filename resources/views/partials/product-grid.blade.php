@forelse($products as $product)
    <x-product-card :product="$product" />
@empty
    <div class="col-span-full py-20 text-center">
        <div class="w-32 h-32 bg-white rounded-[2.5rem] shadow-xl shadow-secondary/5 flex items-center justify-center mx-auto mb-8 border border-gray-50 group">
            <i class="fas fa-search-minus text-4xl text-gray-200 group-hover:text-primary transition-colors duration-500"></i>
        </div>
        <h3 class="text-3xl font-playfair font-black text-secondary mb-4 uppercase tracking-tight">Zero Results Found</h3>
        <p class="text-gray-400 font-medium mb-10 max-w-sm mx-auto leading-relaxed">We couldn't find any products matching your current filters. Try broadening your criteria for better results.</p>
        <a href="{{ route('shop') }}" class="inline-flex items-center gap-4 bg-secondary text-white text-[10px] font-black px-10 py-5 rounded-2xl hover:bg-primary transition-all active:scale-95 shadow-lg shadow-secondary/10 uppercase tracking-[0.2em]">
            Reset Collection <i class="fas fa-redo-alt text-[8px]"></i>
        </a>
    </div>
@endforelse
