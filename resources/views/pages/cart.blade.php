@extends('layouts.app')

@section('title', 'Shopping Cart - ' . config('app.name'))

@section('content')
@php
    $cartCount = count($cartItems);
@endphp

<div class="bg-gray-50 min-h-screen py-12 md:py-24 relative overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-primary/5 rounded-full blur-[150px] animate-pulse"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-accent/5 rounded-full blur-[150px] animate-pulse delay-1000"></div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Section Header -->
        <div class="mb-16 text-center lg:text-left animate-fade-in-up">
            <span class="inline-block px-4 py-1.5 bg-primary/10 rounded-full text-[10px] font-black tracking-[0.3em] uppercase mb-6 border border-primary/10 text-primary">Current Inventory</span>
            <h1 class="text-5xl md:text-7xl font-display font-black tracking-tighter text-secondary">
                Shopping Cart <span class="text-gray-300 font-light ml-4">/ {{ $cartCount }} items</span>
            </h1>
        </div>

        @if(empty($cartItems))
             <div class="bg-white rounded-[3rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.05)] p-20 text-center border border-gray-50 animate-fade-in-up max-w-2xl mx-auto group">
                <div class="w-32 h-32 bg-gray-50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 relative group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-primary/5 rounded-[2.5rem] animate-pulse"></div>
                    <i class="fas fa-shopping-basket text-5xl text-gray-200 relative z-10"></i>
                </div>
                <h3 class="text-3xl font-display font-black text-secondary mb-4 tracking-tight transition-colors">Manifest is Empty</h3>
                <p class="text-gray-500 mb-12 text-lg max-w-sm mx-auto font-medium leading-relaxed">It appears your requisition list is currently unoccupied. Explore our active collections to populate it.</p>
                <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-12 py-6 bg-primary text-white text-xs font-black uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-1 transition-all">
                    Initiate Shopping <i class="fas fa-arrow-right ml-4"></i>
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Cart Items List -->
                <div class="lg:w-2/3 animate-fade-in-up delay-100">
                    <div class="space-y-6">
                        @foreach($cartItems as $key => $item)
                            <div class="group relative bg-white rounded-[2.5rem] shadow-[0_20px_50px_-15px_rgba(0,0,0,0.04)] p-6 md:p-8 border border-transparent hover:border-primary/20 transition-all duration-500 hover:shadow-[0_40px_80px_-20px_rgba(0,0,0,0.08)]">
                                <div class="flex flex-col md:flex-row items-center gap-10">
                                    <!-- Product Visual -->
                                    <div class="relative w-40 h-40 flex-shrink-0">
                                        <a href="{{ route('product.show', $item['slug']) }}" class="block w-full h-full bg-gray-50 rounded-3xl overflow-hidden border border-gray-100 shadow-inner group-hover:scale-105 transition-all duration-700">
                                            @if($item['image'])
                                                <img src="{{ getProductImage($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-contain p-4 group-hover:rotate-6 transition-transform duration-700">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-200"><i class="fas fa-image text-4xl"></i></div>
                                            @endif
                                        </a>
                                        <div class="absolute -top-3 -left-3 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-secondary border border-gray-100 z-10">
                                            <span class="text-[10px] font-black font-mono">#{{ $loop->iteration }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Context & Details -->
                                    <div class="flex-1 text-center md:text-left">
                                        <div class="mb-4">
                                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] block mb-2">Signature Drop</span>
                                            <a href="{{ route('product.show', $item['slug']) }}" class="font-display font-black text-3xl text-secondary hover:text-primary transition-colors block leading-[1.1] tracking-tighter">
                                                {{ $item['name'] }}
                                            </a>
                                        </div>
                                        <div class="flex flex-wrap justify-center md:justify-start gap-4">
                                            @if(isset($item['attributes']['size']))
                                                <div class="flex flex-col">
                                                    <span class="text-[8px] font-black text-gray-300 uppercase tracking-widest mb-1">Dimension</span>
                                                    <span class="inline-flex items-center px-4 py-1.5 rounded-xl bg-gray-50 text-secondary font-black text-[10px] uppercase tracking-widest border border-gray-100 shadow-sm">{{ $item['attributes']['size'] }}</span>
                                                </div>
                                            @endif
                                            @if(isset($item['attributes']['color']))
                                                <div class="flex flex-col">
                                                    <span class="text-[8px] font-black text-gray-300 uppercase tracking-widest mb-1">Variant</span>
                                                    <span class="inline-flex items-center px-4 py-1.5 rounded-xl bg-gray-50 text-secondary font-black text-[10px] uppercase tracking-widest border border-gray-100 shadow-sm">{{ $item['attributes']['color'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Quantity Control -->
                                    <div class="flex flex-col items-center gap-6">
                                        <div class="bg-gray-50/50 rounded-2xl p-1.5 flex items-center border border-gray-100 shadow-inner">
                                            <form action="{{ route('cart.update') }}" method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="key" value="{{ $key }}">
                                                <input type="hidden" name="action" value="decrease">
                                                <button type="submit" class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-gray-400 hover:text-primary hover:shadow-md transition-all">
                                                    <i class="fas fa-minus text-xs"></i>
                                                </button>
                                            </form>
                                            <input type="number" 
                                                   value="{{ $item['quantity'] }}" 
                                                   min="1" 
                                                   readonly
                                                   class="w-16 text-center bg-transparent border-none focus:ring-0 text-lg font-black text-secondary appearance-none">
                                            <form action="{{ route('cart.update') }}" method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="key" value="{{ $key }}">
                                                <input type="hidden" name="action" value="increase">
                                                <button type="submit" class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-gray-400 hover:text-primary hover:shadow-md transition-all">
                                                    <i class="fas fa-plus text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="key" value="{{ $key }}">
                                            <button type="submit" class="text-[9px] font-black uppercase tracking-[0.3em] text-red-400 hover:text-red-700 transition-colors flex items-center gap-2">
                                                <i class="fas fa-trash-alt"></i> Remove Item
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <!-- Financial Info -->
                                    <div class="text-center md:text-right md:w-40 border-t md:border-t-0 md:border-l border-gray-50 pt-8 md:pt-0 md:pl-10">
                                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest mb-3">Manifest Total</p>
                                        <p class="font-display font-black text-3xl text-secondary mb-1">৳{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                        <p class="text-[10px] font-bold text-primary italic uppercase tracking-widest">৳{{ number_format($item['price'], 2) }} ea.</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Action / Summary Column -->
                <div class="lg:w-1/3 animate-fade-in-up delay-200">
                    <div class="bg-white rounded-[3rem] p-12 shadow-[0_50px_100px_-30px_rgba(0,0,0,0.12)] sticky top-24 border border-gray-50 overflow-hidden">
                        <!-- Decorative Header Gradient -->
                        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary via-accent to-purple-500"></div>
                        
                        <h2 class="text-3xl font-display font-black text-secondary mb-10 tracking-tight">Requisition Summary</h2>
                        
                        <div class="space-y-8 mb-12">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Gross Subtotal</span>
                                <span class="text-secondary font-black text-xl italic tracking-tight">৳{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Logistics Protocol</span>
                                <span class="text-[9px] font-black text-primary bg-primary/5 px-4 py-2 rounded-full border border-primary/10 uppercase tracking-widest">TBD at Checkout</span>
                            </div>
                        </div>
                        
                        <div class="pt-10 border-t border-gray-50 mb-12">
                             <p class="text-[10px] font-black text-primary uppercase tracking-[0.4em] mb-4">Final Settlement Estimate</p>
                             <div class="text-6xl font-display font-black text-secondary tracking-tighter leading-none mb-2">
                                ৳{{ number_format($subtotal, 2) }}
                             </div>
                             <p class="text-[10px] text-gray-400 font-medium">VAT & processing inclusive</p>
                        </div>
                        
                        <a href="{{ route('checkout') }}" class="group relative w-full flex items-center justify-center gap-5 bg-secondary text-white py-7 text-[10px] font-black uppercase tracking-[0.4em] rounded-[2rem] shadow-2xl shadow-secondary/20 hover:bg-primary hover:shadow-primary/40 hover:-translate-y-2 transition-all overflow-hidden duration-500">
                            <span class="relative z-10">Proceed to Settlement</span>
                            <i class="fas fa-lock text-sm relative z-10 group-hover:scale-110 transition-transform"></i>
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                        </a>
                        
                        <div class="mt-12 pt-8 border-t border-gray-50 flex items-center justify-center gap-8 opacity-40">
                            <i class="fab fa-cc-visa text-3xl hover:opacity-100 transition-opacity cursor-help"></i>
                            <i class="fab fa-cc-mastercard text-3xl hover:opacity-100 transition-opacity cursor-help"></i>
                            <i class="fas fa-shield-check text-3xl hover:opacity-100 transition-opacity cursor-help text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
