@php
    $route = Route::currentRouteName();
@endphp
<aside id="main-sidebar" class="w-[290px] bg-white h-screen fixed left-0 top-0 overflow-y-auto z-50 font-['Plus_Jakarta_Sans'] transform -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl border-r border-gray-100">
    <!-- Brand -->
    <div class="px-8 pt-9 pb-8 flex items-center gap-3">
        <div class="text-[#1B2559] font-bold text-[26px] tracking-tight flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-[#1B2559] flex items-center justify-center text-white text-sm">S</div>
            ShoeHub Admin
        </div>
    </div>
    
    <div class="border-b border-gray-100 mb-6 mx-8"></div>

    <!-- Navigation -->
    <nav class="space-y-1">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'dashboard') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
            <i class="fas fa-home w-5 h-5 mr-3 text-lg {{ str_contains($route, 'dashboard') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Dashboard</span>
        </a>

        <!-- Products -->
        <a href="{{ route('admin.products') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'products') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
             <i class="fas fa-shopping-bag w-5 h-5 mr-3 text-lg {{ str_contains($route, 'products') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Products</span>
        </a>

        <a href="{{ route('admin.categories') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'categories') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
            <i class="fas fa-layer-group w-5 h-5 mr-3 text-lg {{ str_contains($route, 'categories') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Categories</span>
        </a>

         <a href="{{ route('admin.brands') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'brands') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
            <i class="fas fa-tag w-5 h-5 mr-3 text-lg {{ str_contains($route, 'brands') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Brands</span>
        </a>
        
        <a href="{{ route('admin.orders') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'orders') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
            <i class="fas fa-shopping-cart w-5 h-5 mr-3 text-lg {{ str_contains($route, 'orders') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Orders</span>
        </a>

        <a href="{{ route('admin.customers') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'customers') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
            <i class="fas fa-users w-5 h-5 mr-3 text-lg {{ str_contains($route, 'customers') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Customers</span>
        </a>

         <a href="{{ route('admin.sliders') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'sliders') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
            <i class="fas fa-images w-5 h-5 mr-3 text-lg {{ str_contains($route, 'sliders') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Sliders</span>
        </a>

        <!-- Final Migration Links -->
        <a href="{{ route('admin.coupons') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'coupons') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
            <i class="fas fa-ticket-alt w-5 h-5 mr-3 text-lg {{ str_contains($route, 'coupons') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Coupons</span>
        </a>

        <a href="{{ route('admin.videos') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'videos') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
            <i class="fas fa-video w-5 h-5 mr-3 text-lg {{ str_contains($route, 'videos') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Social Intel</span>
        </a>

        <a href="{{ route('admin.social-posts.index') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'social-posts') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
            <i class="fab fa-instagram w-5 h-5 mr-3 text-lg {{ str_contains($route, 'social-posts') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Social Feed</span>
        </a>

        <a href="{{ route('admin.reviews') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'reviews') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
            <i class="fas fa-star w-5 h-5 mr-3 text-lg {{ str_contains($route, 'reviews') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Product Intel</span>
        </a>

        <a href="{{ route('admin.settings') }}" class="flex items-center px-6 py-4 transition-all duration-200 group {{ str_contains($route, 'settings') ? 'text-[#1B2559] font-bold border-r-[3px] border-[#4318FF]' : 'text-[#A3AED0] hover:text-[#1B2559] font-medium' }}">
            <i class="fas fa-cog w-5 h-5 mr-3 text-lg {{ str_contains($route, 'settings') ? 'text-[#4318FF]' : 'text-[#A3AED0] group-hover:text-[#4318FF]' }}"></i>
            <span class="flex-1">Settings</span>
        </a>
        
        <form action="{{ route('admin.logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center px-6 py-4 transition-all duration-200 group text-[#A3AED0] hover:text-red-500 font-medium">
                <i class="fas fa-sign-out-alt w-5 h-5 mr-3 text-lg group-hover:text-red-500"></i>
                <span class="flex-1 text-left">Log Out</span>
            </button>
        </form>
    </nav>
</aside>
<div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-[#0B1437]/40 z-40 hidden backdrop-blur-[2px] transition-all duration-300 opacity-0"></div>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('main-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const mainContent = document.getElementById('main-content');
        const isMobile = window.innerWidth < 768;

        if (sidebar.classList.contains('-translate-x-full')) {
            // Opening
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
            
            if (!isMobile) {
                mainContent.style.marginLeft = '290px';
            }
            localStorage.setItem('adminSidebarOpen', 'true');
        } else {
            // Closing
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
            
            if (!isMobile) {
                mainContent.style.marginLeft = '0px';
            }
            localStorage.setItem('adminSidebarOpen', 'false');
        }
    }

    // Initialize sidebar state on load
    document.addEventListener('DOMContentLoaded', () => {
        const isOpen = localStorage.getItem('adminSidebarOpen') === 'true';
        const isMobile = window.innerWidth < 768;
        const sidebar = document.getElementById('main-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const mainContent = document.getElementById('main-content');

        if (isOpen && !isMobile) {
            sidebar.classList.remove('-translate-x-full');
            mainContent.style.marginLeft = '290px';
            mainContent.classList.remove('duration-300'); // No animation on initial load
            setTimeout(() => mainContent.classList.add('duration-300'), 100);
        }
    });
</script>