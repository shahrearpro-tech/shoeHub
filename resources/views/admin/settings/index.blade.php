@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex items-end justify-between">
        <div>
             <h2 class="text-3xl font-black text-secondary tracking-tight">Store Settings</h2>
             <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Configure your application</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Branding & Theming -->
        <div class="bg-white rounded-[40px] shadow-2xl border border-white/20 p-10">
            <h3 class="text-xl font-black text-secondary tracking-tight mb-8">Branding & Theming</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Logos -->
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 px-1">Header Logo</label>
                        <div class="flex items-center gap-6 p-6 rounded-3xl bg-gray-50 border border-dashed border-gray-200">
                            @if(isset($settings['site_logo_header']))
                                <img src="{{ asset('storage/' . $settings['site_logo_header']) }}" class="h-12 w-auto object-contain bg-secondary p-2 rounded-xl">
                            @endif
                            <input type="file" name="site_logo_header" class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 px-1">Footer Logo</label>
                        <div class="flex items-center gap-6 p-6 rounded-3xl bg-gray-50 border border-dashed border-gray-200">
                            @if(isset($settings['site_logo_footer']))
                                <img src="{{ asset('storage/' . $settings['site_logo_footer']) }}" class="h-12 w-auto object-contain bg-secondary p-2 rounded-xl">
                            @endif
                            <input type="file" name="site_logo_footer" class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition">
                        </div>
                    </div>
                </div>

                <!-- Colors -->
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Primary Color</label>
                        <div class="flex items-center gap-4">
                            <input type="color" oninput="this.nextElementSibling.value = this.value" value="{{ $settings['theme_color_primary'] ?? '#4318FF' }}" class="w-16 h-16 rounded-2xl border-none p-1 bg-gray-50 cursor-pointer transition-transform hover:scale-105">
                            <input type="text" name="theme_color_primary" oninput="this.previousElementSibling.value = this.value" value="{{ $settings['theme_color_primary'] ?? '#4318FF' }}" class="flex-1 px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-mono text-xs uppercase focus:ring-2 focus:ring-primary/20 outline-none transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Secondary Color (Dark Mode)</label>
                        <div class="flex items-center gap-4">
                            <input type="color" oninput="this.nextElementSibling.value = this.value" value="{{ $settings['theme_color_secondary'] ?? '#1B2559' }}" class="w-16 h-16 rounded-2xl border-none p-1 bg-gray-50 cursor-pointer transition-transform hover:scale-105">
                            <input type="text" name="theme_color_secondary" oninput="this.previousElementSibling.value = this.value" value="{{ $settings['theme_color_secondary'] ?? '#1B2559' }}" class="flex-1 px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-mono text-xs uppercase focus:ring-2 focus:ring-primary/20 outline-none transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Accent Color</label>
                        <div class="flex items-center gap-4">
                            <input type="color" oninput="this.nextElementSibling.value = this.value" value="{{ $settings['theme_color_accent'] ?? '#FF5B5B' }}" class="w-16 h-16 rounded-2xl border-none p-1 bg-gray-50 cursor-pointer transition-transform hover:scale-105">
                            <input type="text" name="theme_color_accent" oninput="this.previousElementSibling.value = this.value" value="{{ $settings['theme_color_accent'] ?? '#FF5B5B' }}" class="flex-1 px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-mono text-xs uppercase focus:ring-2 focus:ring-primary/20 outline-none transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Chatbot Theme Color</label>
                        <div class="flex items-center gap-4">
                            <input type="color" oninput="this.nextElementSibling.value = this.value" value="{{ $settings['chatbot_color'] ?? '#4318FF' }}" class="w-16 h-16 rounded-2xl border-none p-1 bg-gray-50 cursor-pointer transition-transform hover:scale-105">
                            <input type="text" name="chatbot_color" oninput="this.previousElementSibling.value = this.value" value="{{ $settings['chatbot_color'] ?? '#4318FF' }}" class="flex-1 px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-mono text-xs uppercase focus:ring-2 focus:ring-primary/20 outline-none transition">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Settings -->
        <div class="bg-white rounded-[40px] shadow-2xl border border-white/20 p-10">
            <h3 class="text-xl font-black text-secondary tracking-tight mb-8">General Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                     <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Store Name</label>
                     <input type="text" name="site_title" value="{{ $settings['site_title'] ?? 'ShoeHub' }}" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                </div>
                <div>
                     <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Contact Email</label>
                     <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                </div>
                 <div>
                     <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Currency Symbol</label>
                     <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '৳' }}" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                </div>
                 <div>
                     <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Phone Number</label>
                     <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none transition">
                </div>
            </div>
             <div class="mt-8">
                 <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Footer Description</label>
                 <textarea name="footer_description" rows="3" class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-none text-secondary font-medium focus:ring-2 focus:ring-primary/20 outline-none transition">{{ $settings['footer_description'] ?? '' }}</textarea>
            </div>
        </div>

        <!-- Social Links -->
        <div class="bg-white rounded-[40px] shadow-2xl border border-white/20 p-10">
            <h3 class="text-xl font-black text-secondary tracking-tight mb-8">Social Connections</h3>
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl"><i class="fab fa-facebook-f"></i></div>
                    <input type="text" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="Facebook URL" class="flex-1 px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-medium focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-500 flex items-center justify-center text-xl"><i class="fab fa-twitter"></i></div>
                    <input type="text" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" placeholder="Twitter URL" class="flex-1 px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-medium focus:ring-2 focus:ring-sky-500/20 outline-none transition">
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-xl"><i class="fab fa-instagram"></i></div>
                    <input type="text" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="Instagram URL" class="flex-1 px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-medium focus:ring-2 focus:ring-pink-500/20 outline-none transition">
                </div>
            </div>
        </div>

        <!-- Advanced Settings -->
        <div class="bg-white rounded-[40px] shadow-2xl border border-white/20 p-10">
            <h3 class="text-xl font-black text-secondary tracking-tight mb-8">Advanced Integration</h3>
            <div class="space-y-8">
                <div>
                     <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Instagram Access Token (Long-Lived)</label>
                     <input type="password" name="instagram_access_token" value="{{ $settings['instagram_access_token'] ?? '' }}" placeholder="Paste your Instagram Graph API access token" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-mono text-xs focus:ring-2 focus:ring-primary/20 outline-none transition">
                     <p class="mt-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest">Used for automatic feed fetching. Get this from your Meta for Developers dashboard.</p>
                </div>

                <div>
                     <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Instagram Widget Code (Override Automatic/Manual Feed)</label>
                     <textarea name="instagram_widget_code" rows="5" placeholder="Paste your embed code from LightWidget, Behold.so, or Instagram here..." class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-none text-secondary font-mono text-xs focus:ring-2 focus:ring-primary/20 outline-none transition">{{ $settings['instagram_widget_code'] ?? '' }}</textarea>
                     <p class="mt-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest">Paste HTML snippet to show a live feed. This will hide both the automatic API feed and manual posts.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end pb-12">
            <button type="submit" class="px-12 py-5 bg-primary text-white rounded-[24px] font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/30 hover:bg-brand-600 transition-all transform hover:-translate-y-1">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
