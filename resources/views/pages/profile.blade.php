@extends('layouts.app')

@section('title', 'My Profile - ' . config('app.name'))

@section('content')
<div class="bg-[#f4f7fe] min-h-screen py-12 relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <h1 class="text-4xl font-display font-black text-secondary mb-8">My Profile</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm p-6 sticky top-24">
                     <nav class="space-y-2">
                        <a href="{{ route('account') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-secondary font-bold transition">
                            <i class="fas fa-home w-5"></i> Dashboard
                        </a>
                        <a href="{{ route('account.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-secondary font-bold transition">
                            <i class="fas fa-shopping-bag w-5"></i> My Orders
                        </a>
                        <a href="{{ route('account.addresses') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-secondary font-bold transition">
                            <i class="fas fa-map-marker-alt w-5"></i> Addresses
                        </a>
                        <a href="{{ route('account.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary text-white font-bold transition">
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

            <!-- Main Content -->
            <div class="lg:col-span-3">
                 <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm">
                    <h2 class="text-2xl font-bold text-secondary mb-8 pb-4 border-b border-gray-100">Personal Information</h2>
                    
                    @if(session('success'))
                        <div class="mb-8 bg-green-50 text-green-600 px-6 py-4 rounded-xl font-bold border border-green-100">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-8 bg-red-50 text-red-600 px-6 py-4 rounded-xl font-bold border border-red-100">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div class="relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                            </div>
                            
                            <div class="relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                                <input type="email" value="{{ $user->email }}" disabled
                                       class="w-full px-6 py-4 bg-gray-100 border border-gray-100 rounded-2xl text-gray-500 font-bold cursor-not-allowed">
                                <p class="text-[10px] text-gray-400 mt-2 ml-1">Email cannot be changed.</p>
                            </div>

                            <div class="relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Phone Number</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" required
                                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                            </div>
                        </div>

                         <h3 class="text-xl font-bold text-secondary mb-6 mt-12 pb-4 border-b border-gray-100">Change Password</h3>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                             <div class="relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Current Password</label>
                                <input type="password" name="current_password"
                                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                            </div>
                             <div class="relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">New Password</label>
                                <input type="password" name="new_password"
                                       class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary">
                            </div>
                         </div>

                         <button type="submit" class="px-10 py-4 bg-primary text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                             Save Changes
                         </button>
                    </form>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
