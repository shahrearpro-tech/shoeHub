@extends('layouts.app')

@section('title', 'Return Policy - ' . config('app.name'))

@section('content')
<div class="bg-gray-50 min-h-screen py-24 relative overflow-hidden">
    <!-- Decorative Accents -->
    <div class="absolute top-[10%] left-[-5%] w-[400px] h-[400px] bg-primary/5 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute bottom-[10%] right-[-5%] w-[400px] h-[400px] bg-accent/5 rounded-full blur-[120px] animate-pulse delay-1000"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-20 animate-fade-in-up">
                <span class="inline-block py-1.5 px-4 bg-primary/10 text-primary text-[10px] font-black tracking-[0.3em] uppercase rounded-full mb-6 border border-primary/10">Reversion Protocol</span>
                <h1 class="text-5xl md:text-7xl font-display font-black text-secondary mb-6 tracking-tighter">Returns & Exchanges</h1>
                <p class="text-gray-500 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                    A seamless reversion experience for our elite community.
                </p>
            </div>

            <div class="bg-white rounded-[3rem] p-10 md:p-16 shadow-[0_30px_70px_-20px_rgba(0,0,0,0.08)] border border-gray-50 animate-fade-in-up delay-200">
                <div class="space-y-16">
                    <section class="group">
                        <div class="flex items-center gap-6 mb-8 group-hover:translate-x-2 transition-transform duration-500">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-primary text-xl shadow-inner group-hover:bg-primary group-hover:text-white transition-all">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h3 class="text-2xl font-black text-secondary tracking-tight">1. Return Eligibility</h3>
                        </div>
                        <div class="pl-18 space-y-4">
                            <p class="text-gray-500 text-lg leading-relaxed font-medium">Our protocol spans <span class="text-secondary font-black">7 days</span>. If 7 days have elapsed since your acquisition, we are unable to process a refund or exchange.</p>
                            <p class="text-gray-500 text-lg leading-relaxed font-medium">To maintain eligibility, items must remain <span class="text-secondary font-black underline decoration-primary/30">unworn</span> and in original condition with all manifest packaging intact.</p>
                        </div>
                    </section>

                    <section class="group">
                        <div class="flex items-center gap-6 mb-8 group-hover:translate-x-2 transition-transform duration-500">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-red-500 text-xl shadow-inner group-hover:bg-red-500 group-hover:text-white transition-all">
                                <i class="fas fa-ban"></i>
                            </div>
                            <h3 class="text-2xl font-black text-secondary tracking-tight">2. Non-Returnable Assets</h3>
                        </div>
                        <div class="pl-18 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex items-center gap-4">
                                <i class="fas fa-gift text-gray-400"></i>
                                <span class="text-gray-700 font-bold uppercase text-[10px] tracking-widest">Gift Cards</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex items-center gap-4">
                                <i class="fas fa-heartbeat text-gray-400"></i>
                                <span class="text-gray-700 font-bold uppercase text-[10px] tracking-widest">Personal Care</span>
                            </div>
                        </div>
                    </section>

                    <section class="group">
                        <div class="flex items-center gap-6 mb-8 group-hover:translate-x-2 transition-transform duration-500">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-[#05CD99] text-xl shadow-inner group-hover:bg-[#05CD99] group-hover:text-white transition-all">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <h3 class="text-2xl font-black text-secondary tracking-tight">3. Refund Processing</h3>
                        </div>
                        <p class="text-gray-500 text-lg leading-relaxed font-medium pl-18">Upon receipt and validation of your return, a digital manifest will be issued. Approved refunds are processed to the original payment method within <span class="text-secondary font-black italic">5-10 business days</span>.</p>
                    </section>

                    <section class="group">
                        <div class="flex items-center gap-6 mb-8 group-hover:translate-x-2 transition-transform duration-500">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-accent text-xl shadow-inner group-hover:bg-accent group-hover:text-white transition-all">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <h3 class="text-2xl font-black text-secondary tracking-tight">4. Reverse Logistics</h3>
                        </div>
                        <div class="pl-18 space-y-6">
                            <div class="bg-secondary p-8 rounded-[2rem] text-white/90">
                                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-primary mb-4">Mailing Manifest</p>
                                <p class="text-xl font-black tracking-tight leading-relaxed italic">123 Shoe Street, Fashion City,<br>Dhaka, Bangladesh</p>
                            </div>
                            <p class="text-gray-500 text-lg leading-relaxed font-medium">Clients remain responsible for reverse shipping valuations. Original logistics fees are non-refundable.</p>
                        </div>
                    </section>
                </div>
            </div>
            
            <div class="mt-20 text-center">
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-4 px-12 py-5 bg-white text-secondary border border-gray-200 font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-sm hover:bg-gray-50 transition-all">
                    Initiate Return Manifest <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
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
