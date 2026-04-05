@extends('layouts.app')

@section('title', 'Track Order - ' . config('app.name'))

@section('content')
<div class="bg-[#f4f7fe] min-h-screen py-12 md:py-24 relative overflow-hidden flex items-center">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-2xl mx-auto text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-display font-black text-secondary tracking-tight mb-4">Track Your Order</h1>
            <p class="text-gray-500 text-lg">Enter your order ID and the phone number used during checkout to check the status of your delivery.</p>
        </div>

        <div class="max-w-xl mx-auto bg-white rounded-[2.5rem] p-10 md:p-14 shadow-2xl shadow-primary/5 border border-white">
            <form action="{{ route('track.order') }}" method="GET">
                <div class="space-y-6">
                    <div class="relative group">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Order ID</label>
                        <input type="text" name="order_number" placeholder="e.g. ORD-123456" required
                               class="w-full pl-12 pr-6 py-5 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary text-lg">
                        <i class="fas fa-hashtag absolute left-5 top-[3.2rem] text-gray-300"></i>
                    </div>

                    <div class="relative group">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Phone Number</label>
                        <input type="tel" name="phone" placeholder="e.g. +880 1XXX QQQQQQ" required
                               class="w-full pl-12 pr-6 py-5 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary text-lg">
                         <i class="fas fa-phone absolute left-5 top-[3.2rem] text-gray-300"></i>
                    </div>

                    <button type="submit" class="w-full py-5 bg-primary text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-1 transition-all mt-4">
                        Track Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
