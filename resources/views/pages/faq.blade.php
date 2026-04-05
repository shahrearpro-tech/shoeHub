@extends('layouts.app')

@section('title', 'FAQ - ' . config('app.name'))

@section('content')
<div class="bg-gray-50 min-h-screen py-24 relative overflow-hidden">
    <!-- Decorative Accents -->
    <div class="absolute top-0 left-1/4 w-[300px] h-[300px] bg-primary/5 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-accent/5 rounded-full blur-[120px] animate-pulse delay-1000"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-20 animate-fade-in-up">
                <span class="inline-block py-1.5 px-4 bg-primary/10 text-primary text-[10px] font-black tracking-[0.3em] uppercase rounded-full mb-6 border border-primary/10">Knowledge Center</span>
                <h1 class="text-5xl md:text-7xl font-display font-black text-secondary mb-6 tracking-tighter">Common Queries</h1>
                <p class="text-gray-500 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                    Everything you need to know about our high-performance logistics and care.
                </p>
            </div>

            <div class="space-y-4 animate-fade-in-up delay-200">
                <!-- FAQ Item 1 -->
                <details class="bg-white rounded-[2.5rem] shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] group border border-transparent hover:border-primary/20 transition-all duration-500 overflow-hidden">
                    <summary class="list-none flex justify-between items-center p-8 cursor-pointer group-open:bg-primary/5 transition-colors">
                        <h3 class="font-black text-lg md:text-xl text-secondary tracking-tight">How long does shipping take?</h3>
                        <div class="w-10 h-10 bg-gray-50 rounded-2xl flex items-center justify-center text-primary transition-transform duration-500 group-open:rotate-45 shadow-inner">
                            <i class="fas fa-plus text-xs"></i>
                        </div>
                    </summary>
                    <div class="px-8 pb-8 pt-2">
                        <div class="h-[1px] w-full bg-gray-100 mb-6"></div>
                        <p class="text-gray-500 leading-relaxed font-medium">
                            Standard shipping typically takes 3-5 business days within Dhaka, and 5-7 business days for other divisions. Express shipping options are available at checkout for 1-2 day delivery.
                        </p>
                    </div>
                </details>

                <!-- FAQ Item 2 -->
                <details class="bg-white rounded-[2.5rem] shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] group border border-transparent hover:border-primary/20 transition-all duration-500 overflow-hidden">
                    <summary class="list-none flex justify-between items-center p-8 cursor-pointer group-open:bg-primary/5 transition-colors">
                        <h3 class="font-black text-lg md:text-xl text-secondary tracking-tight">What is your return policy?</h3>
                        <div class="w-10 h-10 bg-gray-50 rounded-2xl flex items-center justify-center text-primary transition-transform duration-500 group-open:rotate-45 shadow-inner">
                            <i class="fas fa-plus text-xs"></i>
                        </div>
                    </summary>
                    <div class="px-8 pb-8 pt-2">
                        <div class="h-[1px] w-full bg-gray-100 mb-6"></div>
                        <p class="text-gray-500 leading-relaxed font-medium">
                            We offer a 7-day hassle-free return policy for all unworn items in their original packaging. Simply contact our support team to initiate a return request.
                        </p>
                    </div>
                </details>

                <!-- FAQ Item 3 -->
                <details class="bg-white rounded-[2.5rem] shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] group border border-transparent hover:border-primary/20 transition-all duration-500 overflow-hidden">
                    <summary class="list-none flex justify-between items-center p-8 cursor-pointer group-open:bg-primary/5 transition-colors">
                        <h3 class="font-black text-lg md:text-xl text-secondary tracking-tight">Do you ship internationally?</h3>
                        <div class="w-10 h-10 bg-gray-50 rounded-2xl flex items-center justify-center text-primary transition-transform duration-500 group-open:rotate-45 shadow-inner">
                            <i class="fas fa-plus text-xs"></i>
                        </div>
                    </summary>
                    <div class="px-8 pb-8 pt-2">
                        <div class="h-[1px] w-full bg-gray-100 mb-6"></div>
                        <p class="text-gray-500 leading-relaxed font-medium">
                            Currently, we only ship within Bangladesh. We are working on expanding our logistics to support international shipping soon.
                        </p>
                    </div>
                </details>

                <!-- FAQ Item 4 -->
                <details class="bg-white rounded-[2.5rem] shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] group border border-transparent hover:border-primary/20 transition-all duration-500 overflow-hidden">
                    <summary class="list-none flex justify-between items-center p-8 cursor-pointer group-open:bg-primary/5 transition-colors">
                        <h3 class="font-black text-lg md:text-xl text-secondary tracking-tight">How can I track my order?</h3>
                        <div class="w-10 h-10 bg-gray-50 rounded-2xl flex items-center justify-center text-primary transition-transform duration-500 group-open:rotate-45 shadow-inner">
                            <i class="fas fa-plus text-xs"></i>
                        </div>
                    </summary>
                    <div class="px-8 pb-8 pt-2">
                        <div class="h-[1px] w-full bg-gray-100 mb-6"></div>
                        <p class="text-gray-500 leading-relaxed font-medium">
                            You can track your order status from your account dashboard or by using the "Track Order" link in the footer and entering your order ID.
                        </p>
                    </div>
                </details>
            </div>
            
            <div class="mt-20 text-center bg-secondary p-12 rounded-[3rem] shadow-2xl relative overflow-hidden group">
                <div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <h3 class="text-2xl font-black text-white mb-4 relative z-10">Still have questions?</h3>
                <p class="text-gray-400 mb-10 relative z-10">Our performance team is ready to assist you personally.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-4 px-12 py-5 bg-primary text-white font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-xl shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-1 transition-all relative z-10">
                    Get in Touch <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
