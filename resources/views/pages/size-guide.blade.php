@extends('layouts.app')

@section('title', 'Size Guide - ' . config('app.name'))

@section('content')
<div class="bg-gray-50 min-h-screen py-24 relative overflow-hidden">
    <!-- Decorative Accents -->
    <div class="absolute top-[5%] right-[10%] w-[300px] h-[300px] bg-primary/5 rounded-full blur-[100px] animate-pulse"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-20 animate-fade-in-up">
                <span class="inline-block py-1.5 px-4 bg-primary/10 text-primary text-[10px] font-black tracking-[0.3em] uppercase rounded-full mb-6 border border-primary/10">Fitment Index</span>
                <h1 class="text-5xl md:text-7xl font-display font-black text-secondary mb-6 tracking-tighter">Size Calibration</h1>
                <p class="text-gray-500 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                    Precision measurement for optimal urban performance.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 animate-fade-in-up delay-200">
                <!-- Men's Footwear -->
                <div class="bg-white rounded-[3rem] p-10 shadow-[0_30px_70px_-20px_rgba(0,0,0,0.08)] border border-gray-50">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                            <i class="fas fa-male"></i>
                        </div>
                        <h3 class="text-2xl font-black text-secondary tracking-tight">Men's Footwear</h3>
                    </div>
                    <div class="overflow-hidden rounded-2xl border border-gray-100">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">US</th>
                                    <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">UK</th>
                                    <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">EU</th>
                                    <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">CM</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr class="hover:bg-primary/5 transition-colors"><td class="p-5 font-black text-secondary">7</td><td class="p-5 text-gray-500 font-medium">6</td><td class="p-5 text-gray-500 font-medium">40</td><td class="p-5 text-primary font-black italic">25</td></tr>
                                <tr class="hover:bg-primary/5 transition-colors"><td class="p-5 font-black text-secondary">8</td><td class="p-5 text-gray-500 font-medium">7</td><td class="p-5 text-gray-500 font-medium">41</td><td class="p-5 text-primary font-black italic">26</td></tr>
                                <tr class="hover:bg-primary/5 transition-colors"><td class="p-5 font-black text-secondary">9</td><td class="p-5 text-gray-500 font-medium">8</td><td class="p-5 text-gray-500 font-medium">42</td><td class="p-5 text-primary font-black italic">27</td></tr>
                                <tr class="hover:bg-primary/5 transition-colors"><td class="p-5 font-black text-secondary">10</td><td class="p-5 text-gray-500 font-medium">9</td><td class="p-5 text-gray-500 font-medium">43</td><td class="p-5 text-primary font-black italic">28</td></tr>
                                <tr class="hover:bg-primary/5 transition-colors"><td class="p-5 font-black text-secondary">11</td><td class="p-5 text-gray-500 font-medium">10</td><td class="p-5 text-gray-500 font-medium">44</td><td class="p-5 text-primary font-black italic">29</td></tr>
                                <tr class="hover:bg-primary/5 transition-colors"><td class="p-5 font-black text-secondary">12</td><td class="p-5 text-gray-500 font-medium">11</td><td class="p-5 text-gray-500 font-medium">45</td><td class="p-5 text-primary font-black italic">30</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Women's Footwear -->
                <div class="bg-white rounded-[3rem] p-10 shadow-[0_30px_70px_-20px_rgba(0,0,0,0.08)] border border-gray-50">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-[#05CD99]/10 rounded-xl flex items-center justify-center text-[#05CD99]">
                            <i class="fas fa-female"></i>
                        </div>
                        <h3 class="text-2xl font-black text-secondary tracking-tight">Women's Footwear</h3>
                    </div>
                    <div class="overflow-hidden rounded-2xl border border-gray-100">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">US</th>
                                    <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">UK</th>
                                    <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">EU</th>
                                    <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">CM</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr class="hover:bg-[#05CD99]/5 transition-colors"><td class="p-5 font-black text-secondary">5</td><td class="p-5 text-gray-500 font-medium">3</td><td class="p-5 text-gray-500 font-medium">36</td><td class="p-5 text-[#05CD99] font-black italic">22</td></tr>
                                <tr class="hover:bg-[#05CD99]/5 transition-colors"><td class="p-5 font-black text-secondary">6</td><td class="p-5 text-gray-500 font-medium">4</td><td class="p-5 text-gray-500 font-medium">37</td><td class="p-5 text-[#05CD99] font-black italic">23</td></tr>
                                <tr class="hover:bg-[#05CD99]/5 transition-colors"><td class="p-5 font-black text-secondary">7</td><td class="p-5 text-gray-500 font-medium">5</td><td class="p-5 text-gray-500 font-medium">38</td><td class="p-5 text-[#05CD99] font-black italic">24</td></tr>
                                <tr class="hover:bg-[#05CD99]/5 transition-colors"><td class="p-5 font-black text-secondary">8</td><td class="p-5 text-gray-500 font-medium">6</td><td class="p-5 text-gray-500 font-medium">39</td><td class="p-5 text-[#05CD99] font-black italic">25</td></tr>
                                <tr class="hover:bg-[#05CD99]/5 transition-colors"><td class="p-5 font-black text-secondary">9</td><td class="p-5 text-gray-500 font-medium">7</td><td class="p-5 text-gray-500 font-medium">40</td><td class="p-5 text-[#05CD99] font-black italic">26</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- How to Measure -->
            <div class="mt-12 bg-secondary rounded-[3rem] p-10 md:p-16 text-white relative overflow-hidden group animate-fade-in-up delay-300">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-[100px] -mr-32 -mt-32"></div>
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
                    <div class="md:col-span-12">
                        <h3 class="text-3xl font-black mb-6 tracking-tight">Measurement Methodology</h3>
                        <p class="text-gray-400 text-lg leading-relaxed font-medium mb-8">Place a piece of paper on the floor against a wall. Stand on the paper with your heel against the wall. Mark the longest part of your foot on the paper. Measure the distance from the wall to the mark to find your CM size.</p>
                        <div class="flex flex-wrap gap-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-primary font-black text-xs">1</div>
                                <span class="text-xs font-black uppercase tracking-widest text-white/60">Paper on floor</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-primary font-black text-xs">2</div>
                                <span class="text-xs font-black uppercase tracking-widest text-white/60">Stand & Mark</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-primary font-black text-xs">3</div>
                                <span class="text-xs font-black uppercase tracking-widest text-white/60">Measure CM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-16 text-center italic text-gray-400 font-medium">
                <p>If you're between sizes, we recommend selecting the larger valuation for optimal comfort.</p>
            </div>
        </div>
    </div>
</div>
@endsection
