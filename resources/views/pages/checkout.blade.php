@extends('layouts.app')

@section('title', 'Secure Checkout - ' . config('app.name'))

@section('content')
@php
    $user = auth()->user();
    $deliveryCharge = 60;
    $total = $subtotal + $deliveryCharge;
@endphp

<div class="bg-white min-h-screen py-8 md:py-20 relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10 max-w-5xl">
        
        <!-- Progress Header (Desktop) -->
        <div class="hidden md:flex justify-between items-center mb-16 relative">
            <div class="absolute left-0 top-1/2 w-full h-1 bg-gray-100 -z-10 rounded-full"></div>
            <div class="absolute left-0 top-1/2 w-1/2 h-1 bg-primary/20 -z-10 rounded-full"></div>
            
            <div class="flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shadow-lg shadow-primary/30"><i class="fas fa-check"></i></div>
                <span class="text-xs font-bold uppercase tracking-widest text-primary">Cart Review</span>
            </div>
            <div class="flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-secondary text-white flex items-center justify-center font-bold shadow-lg shadow-secondary/30">2</div>
                <span class="text-xs font-bold uppercase tracking-widest text-secondary">Checkout</span>
            </div>
            <div class="flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-white border-2 border-gray-200 text-gray-300 flex items-center justify-center font-bold">3</div>
                <span class="text-xs font-bold uppercase tracking-widest text-gray-300">Done</span>
            </div>
        </div>

        <!-- Mobile Title -->
        <div class="md:hidden mb-8 text-center">
            <h1 class="text-2xl font-playfair font-black text-secondary">Checkout</h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Complete your order</p>
        </div>
        
        <form action="{{ route('order.store') }}" method="POST" id="checkout-form" class="flex flex-col lg:flex-row gap-8 lg:gap-16">
            @csrf
            
            <!-- Left Column: Inputs -->
            <div class="lg:w-[60%] space-y-8 animate-fade-in-up">
                
                @if($errors->any())
                <div class="bg-red-50 border border-red-100 rounded-2xl p-4 md:p-6 mb-8">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                        <h4 class="text-sm font-bold text-red-700">Please correct the following:</h4>
                    </div>
                    <ul class="list-disc list-inside text-xs text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <!-- Section: Contact & Shipping -->
                <div class="bg-gray-50/50 rounded-3xl p-6 md:p-10 border border-gray-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-secondary/5 text-secondary flex items-center justify-center text-lg font-black"><i class="fas fa-map-marker-alt"></i></div>
                        <h2 class="text-xl font-bold text-secondary uppercase tracking-tight">Shipping Info</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Name & Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="label-text">Full Name</label>
                                <div class="input-group">
                                    <i class="fas fa-user input-icon"></i>
                                    <input type="text" name="customer_name" required value="{{ old('customer_name', $user->name ?? '') }}" 
                                           class="form-input" placeholder="Name">
                                </div>
                            </div>
                            <div>
                                <label class="label-text">Phone Number</label>
                                <div class="input-group">
                                    <i class="fas fa-phone input-icon"></i>
                                    <input type="tel" name="customer_phone" required value="{{ old('customer_phone', $user->phone ?? '') }}" 
                                           class="form-input" placeholder="01XXX-XXXXXX" inputmode="numeric">
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="label-text">Email Address</label>
                            <div class="input-group">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" name="customer_email" required value="{{ old('customer_email', $user->email ?? '') }}" 
                                       class="form-input" placeholder="your@email.com">
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                             <label class="label-text">Delivery Address</label>
                             <div class="input-group mb-3">
                                <i class="fas fa-home input-icon"></i>
                                <input type="text" name="shipping_address_line1" required 
                                       class="form-input" placeholder="House, Road, Area">
                             </div>
                             <input type="text" name="shipping_address_line2" 
                                    class="form-input !pl-6" placeholder="Apartment / Floor (Optional)">
                        </div>

                        <!-- City & Zone -->
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="label-text">City</label>
                                <div class="relative">
                                    <i class="fas fa-city input-icon z-10"></i>
                                    <select name="shipping_city" required class="form-input appearance-none">
                                        <option value="Dhaka">Dhaka</option>
                                        <option value="Chittagong">Chittagong</option>
                                        <option value="Sylhet">Sylhet</option>
                                        <option value="Khulna">Khulna</option>
                                        <!-- Add more -->
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-400 pointer-events-none"></i>
                                </div>
                            </div>
                            <div>
                                <label class="label-text">Zip Code</label>
                                <div class="input-group">
                                    <i class="fas fa-map-pin input-icon"></i>
                                    <input type="text" name="shipping_postal_code" required 
                                           class="form-input" placeholder="1230" inputmode="numeric">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Section: Payment -->
                <div class="bg-gray-50/50 rounded-3xl p-6 md:p-10 border border-gray-100">
                     <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-secondary/5 text-secondary flex items-center justify-center text-lg font-black"><i class="fas fa-wallet"></i></div>
                        <h2 class="text-xl font-bold text-secondary uppercase tracking-tight">Payment Method</h2>
                    </div>
                    
                    <div class="space-y-4">
                        <label class="payment-option active">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-secondary border-gray-300 focus:ring-secondary">
                                <span class="font-bold text-secondary">Cash on Delivery</span>
                            </div>
                            <i class="fas fa-hand-holding-dollar text-2xl text-secondary/50"></i>
                        </label>
                        
                        <label class="payment-option opacity-50 cursor-not-allowed grayscale">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="payment_method" value="online" disabled class="w-5 h-5 text-gray-300">
                                <div>
                                    <span class="font-bold text-gray-500">Online Payment</span>
                                    <span class="block text-[10px] uppercase font-bold text-gray-400">Coming Soon</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <i class="fab fa-cc-visa text-2xl text-gray-300"></i>
                                <i class="fab fa-cc-mastercard text-2xl text-gray-300"></i>
                            </div>
                        </label>
                    </div>
                </div>

            </div>
            
            <!-- Right Column: Summary -->
            <div class="lg:w-[40%]">
                <div class="sticky top-24">
                    <div class="bg-secondary text-white rounded-[2rem] p-8 md:p-10 shadow-xl shadow-secondary/20 relative overflow-hidden">
                        <!-- Decorative Abstract -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
                        
                        <h3 class="text-2xl font-playfair font-black mb-8 relative z-10">Order Summary</h3>
                        
                        <!-- Cart Items (Preview) -->
                        <div class="space-y-4 mb-8 max-h-60 overflow-y-auto pr-2 custom-scrollbar relative z-10">
                            @foreach($cartItems as $item)
                            <div class="flex gap-4 items-center">
                                <div class="w-12 h-12 rounded-lg bg-white/10 overflow-hidden shrink-0">
                                    <img src="{{ getProductImage($item['image']) }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold truncate">{{ $item['name'] }}</h4>
                                    <p class="text-xs text-white/60">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <span class="text-sm font-bold">৳{{ $item['price'] * $item['quantity'] }}</span>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="border-t border-white/10 pt-6 space-y-3 relative z-10">
                            <div class="flex justify-between text-sm text-white/70">
                                <span>Subtotal</span>
                                <span>৳{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-white/70">
                                <span>Shipping</span>
                                <span>৳{{ number_format($deliveryCharge, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-2xl font-black pt-4 border-t border-white/10">
                                <span>Total</span>
                                <span>৳{{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full mt-8 bg-white text-secondary py-5 rounded-2xl font-black uppercase tracking-[0.2em] hover:bg-primary hover:text-white transition-all shadow-lg active:scale-95 flex items-center justify-center gap-3 relative z-10">
                            <span class="text-xs md:text-sm">Place Order</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                        
                        <p class="text-[10px] text-white/40 text-center mt-6 font-bold uppercase tracking-widest relative z-10">
                            <i class="fas fa-lock mr-1"></i> 256-Bit SSL Encrypted
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .label-text {
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #9CA3AF; /* gray-400 */
        margin-bottom: 0.5rem;
        display: block;
        margin-left: 0.5rem;
    }
    .input-group {
        position: relative;
        transition: all 0.3s ease;
    }
    .input-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: #D1D5DB; /* gray-300 */
        transition: color 0.3s ease;
    }
    .form-input {
        width: 100%;
        padding: 1rem 1.25rem 1rem 3rem;
        background-color: white;
        border: 2px solid #F3F4F6; /* gray-100 */
        border-radius: 1rem;
        font-weight: 700;
        color: var(--secondary);
        outline: none;
        transition: all 0.3s ease;
    }
    .form-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.05); /* primary/5 */
    }
    .input-group:focus-within .input-icon {
        color: var(--primary);
    }
    
    .payment-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        background: white;
        border: 2px solid transparent;
        border-radius: 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }
    .payment-option.active {
        border-color: var(--secondary);
        background: #F4F7FE; /* light */
    }
    
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
    }
</style>
@endsection