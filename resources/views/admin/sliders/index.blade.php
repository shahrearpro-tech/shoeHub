@extends('layouts.admin')

@section('title', 'Sliders')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- List -->
    <div class="lg:col-span-2 space-y-6 animate-slide-in-left">
        @forelse($sliders as $slider)
        <div class="bg-white rounded-[32px] shadow-lg border border-white/20 overflow-hidden group relative">
            <div class="relative aspect-[16/6] overflow-hidden">
                <img src="{{ asset($slider->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                
                <div class="absolute bottom-6 left-8 right-8 text-white">
                    <h3 class="text-2xl font-black mb-1 leading-tight">{{ $slider->title }}</h3>
                    <p class="text-sm font-medium opacity-90">{{ $slider->subtitle }}</p>
                </div>
                
                <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" onsubmit="return confirm('Delete this slider?');" class="absolute top-4 right-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                        <i class="fas fa-trash text-xs"></i>
                    </button>
                </form>
            </div>
            <div class="px-8 py-4 bg-white flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Link:</span>
                    <a href="{{ $slider->link }}" target="_blank" class="text-xs font-bold text-primary hover:underline">{{ $slider->link }}</a>
                </div>
                <div class="text-[10px] font-black text-gray-300 uppercase tracking-widest">
                    Order: {{ $slider->display_order }}
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-[32px] shadow-lg border border-white/20 p-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 mx-auto">
                <i class="fas fa-images text-gray-300 text-2xl"></i>
            </div>
            <p class="text-gray-400 font-bold text-sm">No sliders found</p>
        </div>
        @endforelse
    </div>

    <!-- Create Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-[40px] shadow-2xl border border-white/20 p-10 sticky top-8 animate-slide-in-right">
            <h3 class="text-xl font-black text-secondary tracking-tight mb-2">Add Slider</h3>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-8">Create homepage banner</p>
            
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Slider Image</label>
                    <div class="group border-2 border-dashed border-gray-100 rounded-[24px] bg-gray-50 h-40 flex flex-col items-center justify-center cursor-pointer hover:border-primary hover:bg-white transition-all duration-500 text-center p-4 relative overflow-hidden">
                        <input type="file" name="image" required accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform duration-500 text-primary">
                            <i class="fas fa-cloud-upload-alt text-xl"></i>
                        </div>
                        <h4 class="text-gray-400 font-bold text-xs">Drop image here</h4>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Title</label>
                    <input type="text" name="title" required class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition transition-all" placeholder="Banner Heading">
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Subtitle</label>
                    <input type="text" name="subtitle" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-medium focus:ring-2 focus:ring-primary/20 outline-none transition" placeholder="Optional subtitle">
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Button Link</label>
                    <input type="text" name="link" required class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-medium focus:ring-2 focus:ring-primary/20 outline-none transition" placeholder="https://...">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Btn Text</label>
                        <input type="text" name="button_text" required class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition" placeholder="Shop Now">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Order</label>
                        <input type="number" name="display_order" value="0" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-primary text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/30 hover:bg-brand-600 transition-all transform hover:-translate-y-1">
                    Create Slider
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
