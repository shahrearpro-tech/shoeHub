@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<!-- Controls Header -->
<div class="glass-card rounded-[24px] p-6 mb-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 animate-fade-in">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center text-xl shadow-sm">
            <i class="fas fa-boxes"></i>
        </div>
        <div>
            <h2 class="text-secondary text-2xl font-black tracking-tight">Products Inventory</h2>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-0.5">Manage Items</p>
        </div>
    </div>
    
    <div class="flex items-center gap-4 w-full md:w-auto">
        <a href="{{ route('admin.products.create') }}" class="bg-primary hover:bg-brand-600 text-white text-sm font-black px-8 py-3.5 rounded-2xl transition shadow-lg shadow-primary/25 flex items-center gap-2 transform hover:-translate-y-1">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
</div>

<!-- Products Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 animate-fade-in" style="animation-delay: 0.1s">
    @forelse($products as $product)
        @php
            $percentSold = 0; // Placeholder logic
        @endphp
        <div class="bg-white rounded-[32px] p-5 shadow-sm hover:shadow-2xl transition-all duration-500 group relative border border-gray-50 overflow-hidden">
            <!-- Image Container -->
            <div class="h-56 w-full bg-[#F4F7FE] rounded-[24px] mb-5 overflow-hidden relative">
                <img src="{{ getProductImage($product->featured_image) }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                
                <!-- Quick Actions Overlay -->
                <div class="absolute inset-0 bg-secondary/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3 backdrop-blur-[2px]">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="w-10 h-10 bg-white text-primary rounded-xl flex items-center justify-center hover:bg-primary hover:text-white transition shadow-lg">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-10 h-10 bg-white text-red-500 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white transition shadow-lg">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                
                @if($product->is_featured)
                    <span class="absolute top-4 left-4 bg-yellow-400 text-yellow-900 text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-tighter shadow-sm">Featured</span>
                @endif

                @if($product->stock_quantity <= 5)
                    <span class="absolute top-4 right-4 bg-red-100 text-red-600 text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-tighter">Low Stock</span>
                @endif
            </div>
            
            <!-- Content -->
            <div class="space-y-4">
                <div>
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">{{ $product->category->name ?? 'Other' }}</p>
                    <h3 class="text-secondary font-black text-lg truncate group-hover:text-primary transition" title="{{ $product->name }}">{{ $product->name }}</h3>
                </div>
                
                <!-- Price -->
                <div class="flex items-center justify-between border-b border-gray-50 pb-4">
                     <span class="text-2xl font-black text-secondary">৳{{ number_format($product->price, 0) }}</span>
                </div>
                
                <!-- Inventory Progress -->
                <div>
                    <div class="flex justify-between text-[11px] font-black mb-2 uppercase tracking-tight">
                        <span class="text-gray-400">Inventory Status</span>
                        <span class="text-secondary">Available</span>
                    </div>
                    <div class="w-full h-2.5 bg-gray-50 rounded-full overflow-hidden border border-gray-100 p-[2px]">
                        <div class="h-full bg-primary rounded-full relative shadow-sm" style="width: {{ rand(10,90) }}%"></div>
                    </div>
                    <div class="flex justify-between mt-2 text-[10px] font-bold">
                        <span class="text-green-500">{{ $product->stock_quantity }} in stock</span>
                    </div>
                </div>
                
                <a href="{{ route('admin.products.edit', $product->id) }}" class="block w-full text-center py-3 bg-gray-50 text-secondary font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-primary hover:text-white transition shadow-sm">
                    Manage Product
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full py-20 text-center glass-card rounded-[32px]">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-box-open text-4xl text-gray-200"></i>
            </div>
            <h3 class="font-black text-secondary text-xl mb-2">No products found</h3>
            <p class="text-gray-400 font-bold text-sm max-w-xs mx-auto">Start building your inventory by adding a new product today.</p>
        </div>
    @endforelse
</div>
<div class="mt-8">
    {{ $products->links() }}
</div>
@endsection