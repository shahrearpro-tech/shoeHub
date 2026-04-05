<header class="relative z-50">
    <!-- Top Promo Bar (Desktop Scrolling) -->
    <div class="hidden md:block bg-[#1B2559] text-white py-2.5 text-[10px] uppercase tracking-[0.2em] font-black relative z-50 overflow-hidden border-b border-white/5">
        <div class="scroll-container flex whitespace-nowrap">
            <div class="scroll-content flex gap-20 items-center">
                <p class="flex items-center gap-2"><i class="fas fa-bolt text-accent"></i> Flash Sale: 20% Off All Sneakers</p>
                <p class="flex items-center gap-2"><i class="fas fa-truck-fast text-accent"></i> Free Shipping on Orders Over {{ formatPrice(1000) }}</p>
                <p class="flex items-center gap-2"><i class="fas fa-shield-halved text-accent"></i> International Verified Authenticity</p>
                <p class="flex items-center gap-2"><i class="fas fa-rotate text-accent"></i> 7-Day Hassle Free Returns</p>
                <!-- Double for seamless loop -->
                <p class="flex items-center gap-2"><i class="fas fa-bolt text-accent"></i> Flash Sale: 20% Off All Sneakers</p>
                <p class="flex items-center gap-2"><i class="fas fa-truck-fast text-accent"></i> Free Shipping on Orders Over {{ formatPrice(1000) }}</p>
                <p class="flex items-center gap-2"><i class="fas fa-shield-halved text-accent"></i> International Verified Authenticity</p>
                <p class="flex items-center gap-2"><i class="fas fa-rotate text-accent"></i> 7-Day Hassle Free Returns</p>
            </div>
        </div>
        <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center space-x-4 bg-[#1B2559] pl-4">
             <a href="{{ route('track.order') }}" class="hover:text-accent transition duration-300">Track</a>
             @auth
                 <a href="{{ route('account') }}" class="hover:text-accent transition duration-300">Account</a>
             @else
                 <a href="{{ route('login') }}" class="hover:text-accent transition duration-300">Sign In</a>
             @endauth
        </div>
    </div>
    
    <style>
        .scroll-container { width: 100%; }
        .scroll-content { animation: scroll-left 30s linear infinite; width: max-content; }
        @keyframes scroll-left { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    </style>
    
    <!-- Main Navigation -->
    <div class="bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 py-3 md:py-0">
            <div class="flex flex-col md:flex-row md:items-center justify-between md:h-20 gap-3 md:gap-0">
                
                <!-- Logo & Mobile Actions Row -->
                <div class="flex items-center justify-between w-full md:w-auto">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="py-4 md:py-0 inline-flex items-center group transition-all duration-300">
                        @if(isset($settings['site_logo_header']))
                            <img src="{{ asset('storage/' . $settings['site_logo_header']) }}" alt="{{ $settings['site_title'] ?? config('app.name') }}" class="h-8 md:h-12 w-auto object-contain transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="flex items-center gap-1">
                                <span class="text-2xl md:text-3xl font-display font-black tracking-tightest text-secondary group-hover:text-primary transition-colors">SHOE</span>
                                <span class="text-2xl md:text-3xl font-display font-light tracking-tightest text-primary">HUB</span>
                            </div>
                        @endif
                    </a>

                    <!-- Mobile Right Icons (Cart Only) -->
                    <div class="flex md:hidden items-center space-x-4">
                        <a href="{{ route('cart') }}" class="text-secondary relative">
                            <i class="fas fa-shopping-bag text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-primary text-white text-[9px] font-black rounded-full w-4 h-4 flex items-center justify-center cart-count">{{ getCartItemsCount() }}</span>
                        </a>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-8 flex-1 justify-center">
                    <a href="{{ route('home') }}" class="text-sm font-bold uppercase tracking-wide text-secondary hover:text-primary transition relative group py-2">
                        Home
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('shop') }}" class="text-sm font-bold uppercase tracking-wide text-secondary hover:text-primary transition relative group py-2">
                        Shop
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('about') }}" class="text-sm font-bold uppercase tracking-wide text-secondary hover:text-primary transition relative group py-2">
                        About Us
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('blog.index') }}" class="text-sm font-bold uppercase tracking-wide text-secondary hover:text-primary transition relative group py-2">
                        Journal
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <!-- Mega Menu Trigger -->
                    <div class="relative group">
                        <button class="text-sm font-bold uppercase tracking-wide text-secondary hover:text-primary transition flex items-center py-2">
                            Categories <i class="fas fa-chevron-down ml-1 text-[10px] transform group-hover:rotate-180 transition-transform"></i>
                        </button>
                        <!-- Mega Menu -->
                        <div class="absolute top-full left-1/2 -translate-x-1/2 mt-0 w-[600px] bg-white rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-4 p-6 border border-gray-100 z-50 grid grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">By Category</h4>
                                <div class="space-y-2">
                                    @php $categories = \App\Models\Category::where('parent_id', null)->where('status', 'active')->take(8)->get(); @endphp
                                    @foreach($categories as $category)
                                        <a href="{{ route('shop', ['category' => $category->slug]) }}" class="flex items-center group/item p-2 rounded-lg hover:bg-light transition-colors">
                                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 group-hover/item:bg-primary group-hover/item:text-white transition-colors mr-3">
                                                <i class="fas fa-shoe-prints text-xs"></i>
                                            </div>
                                            <span class="text-sm font-semibold text-secondary group-hover/item:text-primary">{{ $category->name }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-5 flex flex-col justify-end relative overflow-hidden group/card cursor-pointer" onclick="window.location.href='{{ route('shop', ['sort' => 'newest']) }}'">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                                <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&q=80&w=400" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110">
                                <div class="relative z-20 text-white">
                                    <span class="text-xs font-bold uppercase bg-accent px-2 py-1 rounded mb-2 inline-block">New</span>
                                    <h4 class="text-xl font-playfair font-bold">New Arrivals</h4>
                                    <p class="text-xs text-white/80 mt-1 mb-3">Check out the latest drops.</p>
                                    <span class="text-xs font-bold underline">Shop Now</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Search Bar (Mobile & Desktop) -->
                <div class="w-full md:w-auto md:flex-1 md:max-w-md flex justify-end">
                    <form action="{{ route('shop') }}" method="GET" class="relative w-full group">
                        <input type="text" name="search" placeholder="Search for shoes, brands..." 
                               class="w-full pl-10 pr-4 py-2.5 md:py-2 bg-gray-100/50 border border-gray-200/50 rounded-xl md:rounded-full text-sm font-medium focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder-gray-400 text-secondary">
                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    </form>
                </div>
                
                <!-- Desktop Right Icons -->
                <div class="hidden lg:flex items-center justify-end gap-6 ml-6">
                    <a href="{{ route('wishlist') }}" class="text-secondary hover:text-primary transition transform hover:scale-110 relative group" id="wishlist-toggle">
                        <i class="far fa-heart text-xl"></i>
                        <span class="absolute -top-1.5 -right-1.5 bg-accent text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center shadow-sm">
                            {{ \App\Models\Wishlist::where('user_id', auth()->id())->count() }}
                        </span>
                    </a>
                    <a href="{{ route('cart') }}" class="text-secondary hover:text-primary transition transform hover:scale-110 relative group" id="cart-toggle">
                        <i class="fas fa-shopping-bag text-xl"></i>
                        <span class="absolute -top-1.5 -right-1.5 bg-primary text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center shadow-sm cart-count">{{ getCartItemsCount() }}</span>
                    </a>
                </div>
            </div>
            
            <!-- Mobile Quick Categories (Horizontal Scroll) -->
            <div class="md:hidden mt-3 pb-2 flex space-x-3 overflow-x-auto no-scrollbar mask-image-r">
                @foreach(\App\Models\Category::where('parent_id', null)->where('status', 'active')->take(6)->get() as $cat)
                    <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="flex-shrink-0 px-3 py-1.5 bg-gray-50 border border-gray-100 rounded-lg text-[10px] font-bold text-gray-500 uppercase tracking-wide whitespace-nowrap hover:bg-primary hover:text-white transition-colors">
                        {{ $cat->name }}
                    </a>
                @endforeach
                <a href="{{ route('shop', ['sort' => 'newest']) }}" class="flex-shrink-0 px-3 py-1.5 bg-gray-50 border border-gray-100 rounded-lg text-[10px] font-bold text-gray-500 uppercase tracking-wide whitespace-nowrap hover:bg-primary hover:text-white transition-colors">
                    New Arrivals
                </a>
            </div>
        </div>
    </div>
</header>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>