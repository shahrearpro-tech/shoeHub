@extends('layouts.app')

@section('title', 'Contact Us - ' . config('app.name'))

@section('content')
<div class="bg-gray-50 min-h-screen py-24 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-[-10%] right-[-10%] w-[50%] h-[50%] bg-primary/5 rounded-full blur-[150px] animate-pulse"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[50%] h-[50%] bg-accent/5 rounded-full blur-[150px] animate-pulse delay-1000"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-20 animate-fade-in-up">
                <span class="inline-block py-1.5 px-4 bg-primary/10 text-primary text-[10px] font-black tracking-[0.3em] uppercase rounded-full mb-6 border border-primary/10">Inquiry Manifest</span>
                <h1 class="text-5xl md:text-7xl font-display font-black text-secondary mb-6 tracking-tighter">Let's Connect</h1>
                <p class="text-gray-500 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                    A dedicated concierge is available 24/7 to assist with your urban performance gear.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <!-- Contact Info cards -->
                <div class="lg:col-span-5 space-y-6 animate-fade-in-up delay-100">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_20px_50px_-15px_rgba(0,0,0,0.05)] border border-gray-100 hover:shadow-2xl transition-all duration-500 group">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 bg-primary/5 rounded-2xl flex items-center justify-center text-primary text-2xl group-hover:bg-primary group-hover:text-white transition-all duration-500 shadow-inner">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-secondary text-sm uppercase tracking-widest mb-1">Global Studio</h3>
                                <p class="text-gray-500 text-sm font-medium leading-relaxed">123 Shoe Street, Fashion City<br>Dhaka, Bangladesh</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_20px_50px_-15px_rgba(0,0,0,0.05)] border border-gray-100 hover:shadow-2xl transition-all duration-500 group">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 bg-[#05CD99]/5 rounded-2xl flex items-center justify-center text-[#05CD99] text-2xl group-hover:bg-[#05CD99] group-hover:text-white transition-all duration-500 shadow-inner">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-secondary text-sm uppercase tracking-widest mb-1">Digital Mail</h3>
                                <p class="text-gray-500 text-sm font-medium">support@shoehub.com<br>info@shoehub.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_20px_50px_-15px_rgba(0,0,0,0.05)] border border-gray-100 hover:shadow-2xl transition-all duration-500 group">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 bg-accent/5 rounded-2xl flex items-center justify-center text-accent text-2xl group-hover:bg-accent group-hover:text-white transition-all duration-500 shadow-inner">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-secondary text-sm uppercase tracking-widest mb-1">Concierge Line</h3>
                                <p class="text-gray-500 text-sm font-medium">+880 1XXX QQQQQQ<br>Mon-Sun, 24/7 Priority</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 text-center lg:text-left">
                        <div class="flex gap-4 justify-center lg:justify-start">
                            <a href="#" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-secondary hover:bg-primary hover:text-white shadow-sm transition-all"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-secondary hover:bg-primary hover:text-white shadow-sm transition-all"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-secondary hover:bg-primary hover:text-white shadow-sm transition-all"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="lg:col-span-7 animate-fade-in-up delay-200">
                    <div class="bg-white p-10 md:p-16 rounded-[3rem] shadow-[0_40px_80px_-20px_rgba(0,0,0,0.1)] border border-gray-50">
                        <h2 class="text-2xl font-black text-secondary mb-10 tracking-tight">Dispatch a Message</h2>
                        <form>
                            <div class="space-y-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-2">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Identity</label>
                                        <input type="text" placeholder="Full Name" class="w-full px-8 py-5 bg-gray-50/50 border border-gray-100 rounded-3xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Digital Address</label>
                                        <input type="email" placeholder="email@example.com" class="w-full px-8 py-5 bg-gray-50/50 border border-gray-100 rounded-3xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Inquiry Subject</label>
                                    <input type="text" placeholder="Product, Shipping, Other..." class="w-full px-8 py-5 bg-gray-50/50 border border-gray-100 rounded-3xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1">Manifest</label>
                                    <textarea rows="6" placeholder="Your message here..." class="w-full px-8 py-5 bg-gray-50/50 border border-gray-100 rounded-3xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary resize-none"></textarea>
                                </div>
                                
                                <div class="pt-4">
                                    <button type="button" class="group relative w-full py-6 bg-secondary text-white font-black uppercase tracking-[0.3em] text-xs rounded-[2rem] shadow-2xl hover:bg-primary shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-1 transition-all overflow-hidden">
                                        <span class="relative z-10 flex items-center justify-center gap-3">Dispatch Message <i class="fas fa-paper-plane text-[10px] group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i></span>
                                        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
