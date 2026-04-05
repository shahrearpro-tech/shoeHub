@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="bg-white rounded-[40px] shadow-2xl w-full border border-white/20 flex flex-col animate-scale-in">
    <!-- Header -->
    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-white rounded-t-[40px]">
        <div>
            <h2 class="text-3xl font-black text-secondary tracking-tight">Add New Product</h2>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Create a professional inventory entry</p>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-10">
        @csrf

        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-3">
                <i class="fas fa-exclamation-triangle text-red-500"></i>
                <h4 class="text-sm font-black text-red-600 uppercase tracking-wider">Please fix the following errors</h4>
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('error'))
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-times-circle text-red-500"></i>
                <span class="text-red-600 text-sm font-bold">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left: Image Upload & Basics (4 cols) -->
            <div class="lg:col-span-4 space-y-8">
                <div class="space-y-4">
                    <label class="block text-[11px] font-black text-secondary uppercase tracking-widest">Product Gallery</label>
                    <div id="gallery-container" class="space-y-4">
                        <!-- Dynamic rows will be here -->
                    </div>
                    <button type="button" id="add-image-btn" class="w-full py-4 border-2 border-dashed border-gray-100 rounded-2xl text-gray-400 font-bold hover:border-primary hover:text-primary transition flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i> Add Image
                    </button>
                    <p class="text-[10px] text-gray-400 font-medium">* First image will be the main listed image.</p>
                </div>

                <template id="gallery-row-template">
                    <div class="gallery-row bg-gray-50 p-4 rounded-2xl border border-gray-100 flex gap-4 items-start relative group">
                        <div class="w-20 h-20 bg-white rounded-xl flex-shrink-0 border border-gray-100 flex items-center justify-center overflow-hidden relative cursor-pointer hover:border-primary transition">
                            <input type="file" name="gallery[INDEX][image]" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10 gallery-input" required>
                            <i class="fas fa-image text-gray-300 text-xl preview-icon"></i>
                            <img src="" class="absolute inset-0 w-full h-full object-cover hidden preview-img">
                        </div>
                        <div class="flex-1 space-y-2 color-variation-wrapper hidden">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Color Variation (Optional)</label>
                            <input type="text" name="gallery[INDEX][color]" placeholder="e.g. Red, Blue" class="w-full px-4 py-2 rounded-xl bg-white border border-gray-100 text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>
                        <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center shadow-md hover:bg-red-600 transition remove-row-btn">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Right: Form Fields (8 cols) -->
            <div class="lg:col-span-8 space-y-10">
                <!-- Product Type Selection -->
                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-black text-secondary uppercase text-[11px] tracking-widest mb-1">Product Type</h3>
                        <p class="text-[10px] text-gray-400 font-bold">Choose inventory structure</p>
                    </div>
                    <div class="flex bg-white p-1 rounded-xl border border-gray-100">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="product_type" value="single" checked class="peer sr-only" onchange="toggleProductType()">
                            <span class="block px-6 py-2 rounded-lg text-xs font-black uppercase tracking-widest text-gray-400 transition-all peer-checked:bg-primary peer-checked:text-white peer-checked:shadow-lg">Single</span>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="product_type" value="variable" class="peer sr-only" onchange="toggleProductType()">
                            <span class="block px-6 py-2 rounded-lg text-xs font-black uppercase tracking-widest text-gray-400 transition-all peer-checked:bg-primary peer-checked:text-white peer-checked:shadow-lg">Variable</span>
                        </label>
                    </div>
                </div>

                <!-- General Information -->
                <div class="space-y-6">
                    <div class="flex items-center gap-2 pb-2 border-b border-gray-50">
                        <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                        <h3 class="font-black text-secondary uppercase text-[11px] tracking-widest">General Information</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Product Title</label>
                            <input type="text" name="name" required value="{{ old('name') }}" placeholder="Enter product title..." class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Brand</label>
                            <select name="brand_id" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none appearance-none cursor-pointer">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Category</label>
                            <select name="category_id" required class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none appearance-none cursor-pointer">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Inventory & Pricing -->
                <div class="space-y-6">
                    <div class="flex items-center gap-2 pb-2 border-b border-gray-50">
                        <span class="w-1.5 h-6 bg-green-500 rounded-full"></span>
                        <h3 class="font-black text-secondary uppercase text-[11px] tracking-widest">Inventory & Pricing</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Regular Price (৳)</label>
                            <input type="number" step="0.01" name="regular_price" required value="{{ old('regular_price') }}" placeholder="0.00" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-black focus:ring-2 focus:ring-primary/20 outline-none transition">
                            @error('regular_price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Sale Price (৳) <span class="text-gray-300 normal-case">optional</span></label>
                            <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" placeholder="0.00" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                            @error('sale_price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Stock Amount</label>
                            <input type="number" name="stock_quantity" required value="{{ old('stock_quantity', 0) }}" placeholder="0" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                            @error('stock_quantity') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">SKU Code</label>
                            <input type="text" name="sku" required value="{{ old('sku') }}" placeholder="PROD-000" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                            @error('sku') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Attributes (Hidden for Single Product) -->
                <div id="attributes-section" class="space-y-6 hidden">
                     <div class="flex items-center gap-2 pb-2 border-b border-gray-50">
                        <span class="w-1.5 h-6 bg-red-500 rounded-full"></span>
                        <h3 class="font-black text-secondary uppercase text-[11px] tracking-widest">Attributes (Comma Separated)</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Sizes</label>
                            <input type="text" name="sizes" value="{{ old('sizes') }}" placeholder="e.g. 40, 41, 42" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Colors</label>
                            <input type="text" name="colors" value="{{ old('colors') }}" placeholder="e.g. Red, Blue, Black" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-6">
                    <div class="flex items-center gap-2 pb-2 border-b border-gray-50">
                        <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
                        <h3 class="font-black text-secondary uppercase text-[11px] tracking-widest">Deep Description</h3>
                    </div>
                    <textarea name="description" rows="5" placeholder="Tell more about this product..." class="w-full px-6 py-4 rounded-[28px] bg-gray-50 border-none text-secondary font-medium focus:ring-2 focus:ring-primary/20 outline-none transition">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Sales Footer Actions -->
        <div class="pt-8 border-t border-gray-50 flex justify-end gap-6 items-center">
             <a href="{{ route('admin.products') }}" class="text-gray-400 font-black text-[11px] uppercase tracking-widest hover:text-secondary transition">
                Discard Changes
            </a>
            <button type="submit" class="px-10 py-4 bg-primary text-white rounded-[24px] font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/30 hover:bg-brand-600 transition-all transform hover:-translate-y-1">
                Publish to Store
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('gallery-container');
        const template = document.getElementById('gallery-row-template');
        const addBtn = document.getElementById('add-image-btn');
        let index = 0;

        // Make function available globally for onchange
        window.toggleProductType = function() {
            const type = document.querySelector('input[name="product_type"]:checked').value;
            const attrSection = document.getElementById('attributes-section');
            const colorWrappers = document.querySelectorAll('.color-variation-wrapper');

            if (type === 'variable') {
                attrSection.classList.remove('hidden');
                colorWrappers.forEach(el => el.classList.remove('hidden'));
            } else {
                attrSection.classList.add('hidden');
                colorWrappers.forEach(el => el.classList.add('hidden'));
            }
        };

        function addRow() {
            const clone = template.content.cloneNode(true);
            const row = clone.querySelector('.gallery-row');
            
            row.innerHTML = row.innerHTML.replace(/INDEX/g, index);
            
            // Image Preview
            const input = row.querySelector('.gallery-input');
            const img = row.querySelector('.preview-img');
            const icon = row.querySelector('.preview-icon');
            
            input.addEventListener('change', function(e) {
                if(this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                        img.classList.remove('hidden');
                        icon.classList.add('hidden');
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Remove Row
            row.querySelector('.remove-row-btn').addEventListener('click', function() {
                row.remove();
            });

            // Check current type and show/hide color input for new row
            const currentType = document.querySelector('input[name="product_type"]:checked').value;
            if(currentType === 'variable') {
                row.querySelector('.color-variation-wrapper').classList.remove('hidden');
            }

            container.appendChild(row);
            index++;
        }

        addBtn.addEventListener('click', addRow);
        
        // Add one empty row by default
        addRow();
        
        // Initial check
        toggleProductType();
    });
</script>
@endpush