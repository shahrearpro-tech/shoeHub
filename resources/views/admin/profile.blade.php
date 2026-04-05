@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white/80 backdrop-blur-xl rounded-[30px] p-8 md:p-12 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-3xl font-black text-[#1B2559] tracking-tight mb-2">My Profile</h2>
                <p class="text-[#707EAE] font-semibold">Manage your administrative details and security</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-green-50 border border-green-100 text-green-600 rounded-2xl font-bold flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 p-4 bg-red-50 border border-red-100 text-red-600 rounded-2xl font-bold">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-[#1B2559] mb-4">Account Information</h3>
                    
                    <div>
                        <label class="block text-xs font-bold text-[#A3AED0] uppercase tracking-widest mb-3 ml-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                               class="w-full px-6 py-4 bg-[#F4F7FE] border-none rounded-2xl font-bold text-[#1B2559] focus:ring-2 focus:ring-primary outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#A3AED0] uppercase tracking-widest mb-3 ml-1">Email Address</label>
                        <input type="email" value="{{ $user->email }}" disabled 
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl font-bold text-[#A3AED0] cursor-not-allowed">
                        <p class="text-[10px] text-[#A3AED0] mt-2 ml-1">Member since {{ $user->created_at->format('M d, Y') }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#A3AED0] uppercase tracking-widest mb-3 ml-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required 
                               class="w-full px-6 py-4 bg-[#F4F7FE] border-none rounded-2xl font-bold text-[#1B2559] focus:ring-2 focus:ring-primary outline-none transition">
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-[#1B2559] mb-4">Security</h3>
                    
                    <div>
                        <label class="block text-xs font-bold text-[#A3AED0] uppercase tracking-widest mb-3 ml-1">Current Password</label>
                        <input type="password" name="current_password" 
                               class="w-full px-6 py-4 bg-[#F4F7FE] border-none rounded-2xl font-bold text-[#1B2559] focus:ring-2 focus:ring-primary outline-none transition" 
                               placeholder="Enter current password to change">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#A3AED0] uppercase tracking-widest mb-3 ml-1">New Password</label>
                        <input type="password" name="new_password" 
                               class="w-full px-6 py-4 bg-[#F4F7FE] border-none rounded-2xl font-bold text-[#1B2559] focus:ring-2 focus:ring-primary outline-none transition" 
                               placeholder="Min 6 characters">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-10 py-4 bg-primary text-white rounded-2xl font-bold uppercase tracking-widest hover:shadow-lg hover:shadow-primary/30 transition-all transform hover:-translate-y-1">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
