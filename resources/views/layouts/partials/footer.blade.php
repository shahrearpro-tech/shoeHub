<footer class="bg-gradient-to-br from-[#1B2559] via-[#0B1437] to-[#050B20] text-white pt-24 pb-12 font-sans relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary to-transparent opacity-50"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary rounded-full mix-blend-overlay filter blur-3xl opacity-10"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-accent rounded-full mix-blend-overlay filter blur-3xl opacity-5"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <!-- Brand Info -->
            <div class="space-y-6">
                <a href="{{ route('home') }}" class="inline-flex items-center group transition-all duration-300">
                    @if(isset($settings['site_logo_footer']))
                        <img src="{{ asset('storage/' . $settings['site_logo_footer']) }}" alt="{{ $settings['site_title'] ?? config('app.name') }}" class="h-8 md:h-12 w-auto object-contain transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="flex items-center gap-1">
                            <span class="text-2xl md:text-3xl font-display font-black tracking-tightest text-white group-hover:text-primary transition-colors">SHOE</span>
                            <span class="text-2xl md:text-3xl font-display font-light tracking-tightest text-primary">HUB</span>
                        </div>
                    @endif
                </a>
                <p class="text-gray-400 leading-relaxed text-sm">
                    {{ $settings['footer_description'] ?? 'Experience the epitome of style and comfort. ShoeHub brings you an exclusive collection of premium footwear, curated for the modern trendsetter.' }}
                </p>
                <div class="flex space-x-4 pt-2">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-primary hover:border-primary transition-all duration-300 transform hover:-translate-y-1"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-primary hover:border-primary transition-all duration-300 transform hover:-translate-y-1"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-primary hover:border-primary transition-all duration-300 transform hover:-translate-y-1"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            
            <!-- Shop Links -->
            <div>
                <h4 class="text-lg font-playfair font-bold mb-8 text-white relative inline-block">Collections <span class="absolute -bottom-2 left-0 w-8 h-0.5 bg-primary rounded-full"></span></h4>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li><a href="{{ route('shop') }}" class="hover:text-primary hover:pl-2 transition-all duration-300 block">All Products</a></li>
                    <li><a href="{{ route('shop', ['sort' => 'newest']) }}" class="hover:text-primary hover:pl-2 transition-all duration-300 block">New Arrivals</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-primary hover:pl-2 transition-all duration-300 block">The Journal (Blog)</a></li>
                </ul>
            </div>
            
            <!-- Support Links -->
            <div>
                <h4 class="text-lg font-playfair font-bold mb-8 text-white relative inline-block">Customer Care <span class="absolute -bottom-2 left-0 w-8 h-0.5 bg-primary rounded-full"></span></h4>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li><a href="{{ route('contact') }}" class="hover:text-primary hover:pl-2 transition-all duration-300 block">Contact Us</a></li>
                    <li><a href="{{ route('shipping.policy') }}" class="hover:text-primary hover:pl-2 transition-all duration-300 block">Shipping Policy</a></li>
                    <li><a href="{{ route('returns') }}" class="hover:text-primary hover:pl-2 transition-all duration-300 block">Returns & Exchanges</a></li>
                    <li><a href="{{ route('size.guide') }}" class="hover:text-primary hover:pl-2 transition-all duration-300 block">Size Guide</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-primary hover:pl-2 transition-all duration-300 block">FAQs</a></li>
                </ul>
            </div>
            
            <!-- Newsletter -->
            <div>
                <h4 class="text-lg font-playfair font-bold mb-8 text-white relative inline-block">Stay Updated <span class="absolute -bottom-2 left-0 w-8 h-0.5 bg-primary rounded-full"></span></h4>
                <p class="text-gray-400 text-sm mb-6">Subscribe to our newsletter for exclusive drops and 10% off your first order.</p>
                <form id="newsletter-form" class="relative group">
                    <input type="email" placeholder="Your email address" class="w-full bg-white/5 text-white px-5 py-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 border border-white/10 placeholder-gray-500 transition-all">
                    <button type="submit" class="absolute right-2 top-2 bottom-2 bg-primary text-white p-3 rounded-lg hover:bg-primary-dark transition-all shadow-lg hover:shadow-primary/30">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Bottom Footer -->
        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Crafted with <i class="fas fa-heart text-red-500 mx-1 animate-pulse"></i> for Quality.</p>
        </div>
    </div>
</footer>

<!-- Quick View Modal, Mini Cart, Wishlist Drawers (using same HTML structure as before, just updated with Blade syntax where needed) -->
<!-- ... (omitted for brevity, assume main.js handles these mostly, just need placeholders) ... -->
<div id="mini-cart-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden backdrop-blur-sm"></div>
<div id="mini-cart-drawer" class="fixed top-0 right-0 h-full w-full md:w-96 bg-white shadow-2xl z-[60] transform translate-x-full transition-transform duration-300 flex flex-col">
    <!-- Header -->
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="text-xl font-bold text-secondary">Shopping cart</h3>
        <button id="close-mini-cart" class="text-gray-500 hover:text-secondary transition flex items-center gap-1 text-sm font-medium">
            <i class="fas fa-times"></i> Close
        </button>
    </div>
    <div class="flex-1 overflow-y-auto p-6 space-y-6" id="mini-cart-items">
        <!-- JS Injected -->
    </div>
    <div class="p-6 border-t bg-white">
        <div class="flex justify-between items-center mb-4">
            <span class="text-xl font-bold text-secondary">Subtotal:</span>
            <span id="mini-cart-total" class="text-xl font-bold text-primary">{{ formatPrice(0) }}</span>
        </div>
        <div class="flex flex-col gap-3">
            <a href="{{ route('cart') }}" class="w-full py-4 text-center font-bold text-secondary bg-gray-50 hover:bg-gray-100 rounded-lg transition border border-gray-100">View Cart</a>
            <a href="{{ route('checkout') }}" class="w-full py-4 text-center font-bold text-white bg-primary hover:bg-blue-700 rounded-lg transition shadow-lg shadow-blue-500/20">Checkout</a>
        </div>
    </div>
</div>

<!-- Wishlist Drawer -->
<div id="wishlist-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden backdrop-blur-sm"></div>
<div id="wishlist-drawer" class="fixed top-0 right-0 h-full w-full md:w-96 bg-white shadow-2xl z-[60] transform translate-x-full transition-transform duration-300 flex flex-col">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="text-xl font-bold text-secondary">My Wishlist</h3>
        <button id="close-wishlist" class="text-gray-500 hover:text-secondary transition flex items-center gap-1 text-sm font-medium">
            <i class="fas fa-times"></i> Close
        </button>
    </div>
    <div class="flex-1 overflow-y-auto p-6 space-y-6" id="wishlist-items">
        <!-- JS Injected -->
    </div>
</div>

<!-- Quick View Modal -->
<div id="quick-view-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="this.parentElement.classList.add('hidden')"></div>
    <div class="bg-white w-full max-w-4xl rounded-[2.5rem] overflow-hidden relative z-10 flex flex-col md:flex-row shadow-2xl">
        <button onclick="this.closest('#quick-view-modal').classList.add('hidden')" class="absolute top-6 right-6 w-10 h-10 bg-white shadow-lg rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-all z-20">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="md:w-1/2 h-[400px] md:h-auto bg-light relative group">
            <img id="qv-img" src="" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-black/20 to-transparent"></div>
        </div>
        
        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-6">
                <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Quick View</span>
                <h2 id="qv-name" class="text-3xl font-playfair font-bold text-secondary mb-3">Product Name</h2>
                <div class="text-2xl font-bold text-primary" id="qv-price">৳0</div>
            </div>
            
            <p id="qv-description" class="text-gray-500 text-sm leading-relaxed mb-8 line-clamp-4">
                Loading description...
            </p>

            <div class="flex gap-4">
                <a id="qv-link" href="#" class="flex-1 bg-secondary text-white py-4 rounded-xl font-bold text-center hover:bg-primary transition-all shadow-lg hover:shadow-primary/30">View Details</a>
                <button onclick="quickAddToCart(null, this)" class="w-14 h-14 border-2 border-primary text-primary rounded-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                    <i class="fas fa-shopping-cart"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Video Lightbox -->
<div id="video-lightbox" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/95 backdrop-blur-md" onclick="this.parentElement.classList.add('hidden')"></div>
    <div id="video-content-wrapper" class="w-full max-w-5xl aspect-video bg-black rounded-3xl overflow-hidden relative z-10 shadow-2xl border border-white/10 transform transition-all duration-500">
        <button onclick="closeVideoLightbox()" class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-white text-white hover:text-secondary rounded-full flex items-center justify-center transition-all z-20 backdrop-blur-md border border-white/20">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div id="video-container" class="w-full h-full">
            <!-- Video Injected -->
        </div>
    </div>
</div>
<!-- Similar for Wishlist -->