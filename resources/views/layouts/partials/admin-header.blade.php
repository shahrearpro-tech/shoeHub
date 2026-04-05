<header class="sticky top-4 z-40 mx-4 md:mx-8">
    <div class="bg-white/50 backdrop-blur-xl rounded-[20px] p-4 flex items-center justify-between gap-4 transition-all hover:bg-white/80 shadow-sm">
        
        <!-- Left: Hamburger & Breadcrumb -->
        <div class="flex items-center gap-6 min-w-fit">
            <button onclick="toggleSidebar()" class="text-[#1B2559] text-xl p-3 hover:bg-[#F4F7FE] rounded-2xl transition-all shadow-sm hover:shadow-md">
                <i class="fas fa-bars"></i>
            </button>
            <div class="hidden sm:block">
                <nav class="text-[12px] text-[#707EAE] font-bold uppercase tracking-widest mb-0.5">
                    Pages / <span class="text-[#1B2559]">@yield('title')</span>
                </nav>
                <h1 class="text-2xl font-black text-[#1B2559] tracking-tight leading-none">@yield('title')</h1>
            </div>
        </div>

        <!-- Center: Search Box -->
        <div class="flex-1 max-w-2xl px-4 hidden md:block">
            <div class="relative bg-[#F4F7FE] rounded-[20px] flex items-center px-5 py-3 text-[#2B3674] border border-transparent focus-within:border-primary/20 focus-within:bg-white transition-all shadow-inner">
                <i class="fas fa-search text-[#8F9BBA] mr-3"></i>
                <input type="text" placeholder="Search..." class="bg-transparent border-none outline-none text-sm w-full text-[#2B3674] font-medium placeholder-[#8F9BBA]">
            </div>
        </div>
        
        <!-- Right: Actions -->
        <div class="bg-white/80 rounded-[20px] p-1.5 flex items-center gap-1 shadow-sm border border-gray-50">
            <div class="relative group">
                <div id="profileBtn" class="ml-2 w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white font-black cursor-pointer hover:shadow-lg hover:shadow-primary/30 transition-all transform hover:-translate-y-0.5">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </div>
</header>