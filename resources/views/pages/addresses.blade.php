@extends('layouts.app')

@section('title', 'My Addresses - ' . config('app.name'))

@section('content')
<div class="bg-[#f4f7fe] min-h-screen py-12 relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <h1 class="text-4xl font-display font-black text-secondary mb-8">My Addresses</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm p-6 sticky top-24">
                     <nav class="space-y-2">
                        <a href="{{ route('account') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-secondary font-bold transition">
                            <i class="fas fa-home w-5"></i> Dashboard
                        </a>
                        <a href="{{ route('account.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-secondary font-bold transition">
                            <i class="fas fa-shopping-bag w-5"></i> My Orders
                        </a>
                        <a href="{{ route('account.addresses') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary text-white font-bold transition">
                            <i class="fas fa-map-marker-alt w-5"></i> Addresses
                        </a>
                        <a href="{{ route('account.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-secondary font-bold transition">
                            <i class="fas fa-user-cog w-5"></i> Account Details
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 font-bold transition text-left">
                                <i class="fas fa-sign-out-alt w-5"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Content -->
            <div class="lg:col-span-3">
                 <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm mb-8">
                    <h2 class="text-2xl font-bold text-secondary mb-8 pb-4 border-b border-gray-100">Saved Addresses</h2>
                    
                    @if($addresses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($addresses as $address)
                                <div class="border border-gray-200 rounded-2xl p-6 relative group hover:border-primary transition hover:shadow-lg">
                                    <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                                        <button class="w-8 h-8 rounded bg-gray-50 text-gray-500 hover:bg-primary hover:text-white flex items-center justify-center transition"><i class="fas fa-edit"></i></button>
                                        <button class="w-8 h-8 rounded bg-gray-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition"><i class="fas fa-trash"></i></button>
                                    </div>
                                    <h3 class="font-bold text-secondary mb-2">{{ $address->full_name }}</h3>
                                    <p class="text-sm text-gray-500 mb-4">{{ $address->phone }}</p>
                                    <p class="text-sm text-gray-600 leading-relaxed">
                                        {{ $address->address_line1 }}<br>
                                        @if($address->address_line2) {{ $address->address_line2 }}<br> @endif
                                        {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                    </p>
                                    @if($address->is_default)
                                        <span class="inline-block mt-4 px-3 py-1 bg-green-100 text-green-600 text-xs font-bold rounded-lg uppercase">Default</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic mb-8">No addresses saved yet.</p>
                    @endif
                 </div>

                 <!-- Add New Address -->
                 <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm">
                    <h2 class="text-2xl font-bold text-secondary mb-8 pb-4 border-b border-gray-100">Add New Address</h2>
                    
                    <form action="{{ route('address.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Full Name</label>
                                <input type="text" name="full_name" required 
                                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                            </div>
                            <div class="relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Phone Number</label>
                                <input type="tel" name="phone" required 
                                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                            </div>
                            <div class="md:col-span-2 relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Address Line 1</label>
                                <input type="text" name="address_line1" required placeholder="Street address"
                                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                            </div>
                            <div class="md:col-span-2 relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Address Line 2 (Optional)</label>
                                <input type="text" name="address_line2" placeholder="Apartment, suite, unit, etc."
                                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                            </div>
                             <div class="relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">City</label>
                                <input type="text" name="city" required 
                                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                            </div>
                             <div class="relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">State / Province</label>
                                <input type="text" name="state" required 
                                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                            </div>
                             <div class="relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Postal Code</label>
                                <input type="text" name="postal_code" required 
                                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                            </div>
                        </div>
                        
                        <div class="flex gap-4">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="is_default" value="1" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="text-sm font-bold text-gray-500 group-hover:text-secondary transition">Set as default address</span>
                            </label>
                        </div>

                        <div class="mt-8">
                             <button type="submit" class="px-10 py-4 bg-secondary text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                                 Save Address
                             </button>
                        </div>
                    </form>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
