@extends('layouts.app')

@section('title', 'About Us - ' . config('app.name'))

@section('content')
<!-- Hero Section -->
<section class="py-20 bg-secondary text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/2 h-full bg-primary/10 skew-x-12 transform translate-x-20"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-5xl md:text-7xl font-display font-black mb-6 tracking-tight">We Are <span class="text-primary">ShoeHub</span></h1>
        <p class="text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">Redefining footwear culture since 2025. Where style meets substance, and every step tells a story.</p>
    </div>
</section>

<!-- Our Story -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-primary/10 rounded-full blur-2xl"></div>
                <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&q=80&w=800" alt="Our Story" class="rounded-[2.5rem] get-shadow relative z-10 transform rotate-2 hover:rotate-0 transition duration-500">
            </div>
            <div>
                <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Our Origin</span>
                <h2 class="text-4xl font-display font-black text-secondary mb-6">More Than Just Shoes</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    ShoeHub began with a simple mission: to create a digital santuary for sneakerheads and casual wearers alike. We believe that footwear is the foundation of personal style, and finding the perfect pair should be an experience, not a chore.
                </p>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    From exclusive drops to daily drivers, our curated collection represents the pinnacle of design and comfort. We partner directly with global brands to ensure authenticity and quality in every box we ship.
                </p>
                
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-4xl font-black text-primary mb-1">50k+</h3>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Happy Customers</p>
                    </div>
                    <div>
                        <h3 class="text-4xl font-black text-primary mb-1">100%</h3>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Authentic Brands</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-20 bg-[#f4f7fe]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-display font-black text-secondary">Our Core Values</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-xl transition duration-500 hover:-translate-y-2">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 text-2xl mb-6">
                    <i class="fas fa-gem"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary mb-3">Premium Quality</h3>
                <p class="text-gray-500">We never compromise on materials or craftsmanship. Only the best makes it to our shelves.</p>
            </div>
            
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-xl transition duration-500 hover:-translate-y-2">
                <div class="w-16 h-16 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 text-2xl mb-6">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary mb-3">Fast Delivery</h3>
                <p class="text-gray-500">We know you want your gear fast. Our logistics network ensures rapid nationwide shipping.</p>
            </div>
            
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-xl transition duration-500 hover:-translate-y-2">
                <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 text-2xl mb-6">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary mb-3">24/7 Support</h3>
                <p class="text-gray-500">Our dedicated team is always ready to assist you with sizing, orders, or style advice.</p>
            </div>
        </div>
    </div>
</section>
@endsection
