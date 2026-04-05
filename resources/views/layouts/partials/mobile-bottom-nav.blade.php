<div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-xl border-t border-gray-100 z-[100] pb-safe shadow-nav transition-all duration-300" id="mobile-nav">
    <div class="flex items-center justify-around h-16 px-2">
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 group transition-all {{ Request::is('/') || Request::is('home') ? 'text-primary' : 'text-gray-400 hover:text-secondary' }}">
            <div class="relative group-active:scale-90 transition-transform">
                <i class="fas fa-home text-xl"></i>
            </div>
            <span class="text-[9px] font-black uppercase tracking-[0.1em]">Home</span>
        </a>
        
        <a href="{{ route('shop') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 group transition-all {{ Request::is('shop*') ? 'text-primary' : 'text-gray-400 hover:text-secondary' }}">
            <div class="relative group-active:scale-90 transition-transform">
                <i class="fas fa-grid-2 text-xl"></i>
                <i class="fas fa-th-large text-xl"></i>
            </div>
            <span class="text-[9px] font-black uppercase tracking-[0.1em]">Shop</span>
        </a>

        <!-- Prominent Search/Discover Action -->
        <button class="flex flex-col items-center justify-center w-full h-full -mt-8 px-2" id="mobile-search-toggle">
            <div class="w-14 h-14 bg-primary text-white rounded-2xl shadow-xl shadow-primary/30 flex items-center justify-center transform active:scale-90 transition-all border-4 border-white">
                <i class="fas fa-search text-xl"></i>
            </div>
        </button>

        <a href="{{ route('cart') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 group transition-all {{ Request::is('cart') ? 'text-primary' : 'text-gray-400 hover:text-secondary' }}">
            <div class="relative group-active:scale-90 transition-transform">
                <i class="fas fa-shopping-bag text-xl"></i>
                <span class="absolute -top-1.5 -right-1.5 bg-accent text-white text-[8px] font-black rounded-full min-w-[16px] h-4 flex items-center justify-center px-1 border-2 border-white cart-count">{{ getCartItemsCount() }}</span>
            </div>
            <span class="text-[9px] font-black uppercase tracking-[0.1em]">Cart</span>
        </a>

        <a href="{{ route('account') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 group transition-all {{ Request::is('account*') || Request::is('login') || Request::is('register') ? 'text-primary' : 'text-gray-400 hover:text-secondary' }}">
            <div class="relative group-active:scale-90 transition-transform">
                <i class="fas fa-user text-xl"></i>
            </div>
            <span class="text-[9px] font-black uppercase tracking-[0.1em]">Profile</span>
        </a>
    </div>
</div>

<style>
    .pb-safe {
        padding-bottom: env(safe-area-inset-bottom);
    }
</style>
