@extends('layouts.app')

@section('title', 'Shipping Policy - ' . config('app.name'))

@section('content')
<div class="bg-gray-50 min-h-screen py-24 relative overflow-hidden">
    <!-- Decorative Accents -->
    <div class="absolute top-[20%] right-[-5%] w-[400px] h-[400px] bg-primary/5 rounded-full blur-[100px] animate-pulse"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-20 animate-fade-in-up">
                <span class="inline-block py-1.5 px-4 bg-primary/10 text-primary text-[10px] font-black tracking-[0.3em] uppercase rounded-full mb-6 border border-primary/10">Logistics Manifest</span>
                <h1 class="text-5xl md:text-7xl font-display font-black text-secondary mb-6 tracking-tighter">Shipping Policy</h1>
                <p class="text-gray-500 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                    Transparent logistics for your high-performance acquisitions.
                </p>
            </div>

            <div class="bg-white rounded-[3rem] p-10 md:p-16 shadow-[0_30px_70px_-20px_rgba(0,0,0,0.08)] border border-gray-50 animate-fade-in-up delay-200">
                <div class="space-y-16">
                    <section class="group">
                        <div class="flex items-center gap-6 mb-8 group-hover:translate-x-2 transition-transform duration-500">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-primary text-xl shadow-inner group-hover:bg-primary group-hover:text-white transition-all">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3 class="text-2xl font-black text-secondary tracking-tight">1. Processing Time</h3>
                        </div>
                        <p class="text-gray-500 text-lg leading-relaxed font-medium pl-18">All orders are processed within <span class="text-secondary font-black">1-2 business days</span>. Orders are not shipped or delivered on weekends or holidays.</p>
                    </section>

                    <section class="group">
                        <div class="flex items-center gap-6 mb-8 group-hover:translate-x-2 transition-transform duration-500">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-[#05CD99] text-xl shadow-inner group-hover:bg-[#05CD99] group-hover:text-white transition-all">
                                <i class="fas fa-truck-loading"></i>
                            </div>
                            <h3 class="text-2xl font-black text-secondary tracking-tight">2. Shipping Rates & Estimates</h3>
                        </div>
                        <div class="pl-18 space-y-6">
                            <p class="text-gray-500 text-lg leading-relaxed font-medium">Shipping charges for your order will be calculated and displayed at core checkout valuation.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 group/rate hover:bg-white hover:border-primary/20 transition-all cursor-default">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Standard Delivery</span>
                                    <div class="flex justify-between items-end">
                                        <span class="text-secondary font-black text-xl italic">3-5 Days</span>
                                        <span class="text-primary font-black text-2xl">৳60</span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 group/rate hover:bg-white hover:border-primary/20 transition-all cursor-default">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Priority Express</span>
                                    <div class="flex justify-between items-end">
                                        <span class="text-secondary font-black text-xl italic">1-2 Days</span>
                                        <span class="text-primary font-black text-2xl">৳120</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="group">
                        <div class="flex items-center gap-6 mb-8 group-hover:translate-x-2 transition-transform duration-500">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-accent text-xl shadow-inner group-hover:bg-accent group-hover:text-white transition-all">
                                <i class="fas fa-search-location"></i>
                            </div>
                            <h3 class="text-2xl font-black text-secondary tracking-tight">3. Shipment Manifest & Tracking</h3>
                        </div>
                        <p class="text-gray-500 text-lg leading-relaxed font-medium pl-18">You will receive a Shipment Confirmation email once your order has shipped containing your tracking manifest number(s). The tracking number will be active within 24 hours.</p>
                    </section>

                    <section class="group">
                        <div class="flex items-center gap-6 mb-8 group-hover:translate-x-2 transition-transform duration-500">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-red-500 text-xl shadow-inner group-hover:bg-red-500 group-hover:text-white transition-all">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h3 class="text-2xl font-black text-secondary tracking-tight">4. Liability & Damages</h3>
                        </div>
                        <p class="text-gray-500 text-lg leading-relaxed font-medium pl-18">ShoeHub is not liable for any products damaged or lost during shipping. If you received your order damaged, please contact the shipment carrier to file a manifest claim.</p>
                    </section>
                </div>
            </div>
            
            <div class="mt-16 text-center animate-fade-in-up delay-300">
                <p class="text-gray-400 font-medium italic">All durations mentioned are business days only.</p>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .pl-18 { padding-left: 0; }
    @media (min-width: 768px) {
        .pl-18 { padding-left: 4.5rem; }
    }
</style>
