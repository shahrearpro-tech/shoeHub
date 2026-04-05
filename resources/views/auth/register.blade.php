@extends('layouts.app')

@section('title', 'Register - ' . config('app.name'))

@section('content')
<div class="min-h-[calc(100vh-80px)] bg-[#f4f7fe] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Blobs -->
    <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-[100px] animate-blob"></div>
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-purple-500/5 rounded-full blur-[100px] animate-blob animation-delay-2000"></div>

    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-[2.5rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.05)] border border-gray-100 relative z-10">
        <div class="text-center">
            <h2 class="text-3xl font-display font-black text-secondary mb-2">Create Account</h2>
            <p class="text-gray-400 text-sm">Join our premium community</p>
        </div>

        @if($errors->any())
            <div class="mt-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl animate-shake">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-bold text-red-700 uppercase tracking-wider">
                            Please correct the errors below to continue.
                        </p>
                    </div>
                </div>
            </div>
        @endif
        
        <form class="mt-8 space-y-6" action="{{ route('register.process') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-[11px] font-black text-gray-300 uppercase tracking-widest mb-2 ml-2">Full Name</label>
                    <div class="relative group">
                        <input name="name" type="text" value="{{ old('name') }}" required 
                               class="w-full pl-12 pr-4 py-4 {{ $errors->has('name') ? 'border-red-500 ring-4 ring-red-500/10' : 'border-gray-100' }} bg-gray-50 border rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary group-hover:bg-white" 
                               placeholder="John Doe">
                        <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 {{ $errors->has('name') ? 'text-red-400' : 'text-gray-300' }} group-focus-within:text-primary transition-colors"></i>
                    </div>
                    @error('name') <p class="text-[10px] text-red-500 font-bold mt-1 ml-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[11px] font-black text-gray-300 uppercase tracking-widest mb-2 ml-2">Email Address</label>
                    <div class="relative group">
                        <input name="email" type="email" value="{{ old('email') }}" required 
                               class="w-full pl-12 pr-4 py-4 {{ $errors->has('email') ? 'border-red-500 ring-4 ring-red-500/10' : 'border-gray-100' }} bg-gray-50 border rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary group-hover:bg-white" 
                               placeholder="john@example.com">
                        <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 {{ $errors->has('email') ? 'text-red-400' : 'text-gray-300' }} group-focus-within:text-primary transition-colors"></i>
                    </div>
                    @error('email') <p class="text-[10px] text-red-500 font-bold mt-1 ml-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[11px] font-black text-gray-300 uppercase tracking-widest mb-2 ml-2">Phone</label>
                    <div class="relative group">
                        <input name="phone" type="tel" value="{{ old('phone') }}" required 
                               class="w-full pl-12 pr-4 py-4 {{ $errors->has('phone') ? 'border-red-500 ring-4 ring-red-500/10' : 'border-gray-100' }} bg-gray-50 border rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary group-hover:bg-white" 
                               placeholder="+880...">
                        <i class="fas fa-phone absolute left-5 top-1/2 -translate-y-1/2 {{ $errors->has('phone') ? 'text-red-400' : 'text-gray-300' }} group-focus-within:text-primary transition-colors"></i>
                    </div>
                    @error('phone') <p class="text-[10px] text-red-500 font-bold mt-1 ml-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[11px] font-black text-gray-300 uppercase tracking-widest mb-2 ml-2">Password</label>
                    <div class="relative group">
                        <input name="password" type="password" required 
                               class="w-full pl-12 pr-4 py-4 {{ $errors->has('password') ? 'border-red-500 ring-4 ring-red-500/10' : 'border-gray-100' }} bg-gray-50 border rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary group-hover:bg-white" 
                               placeholder="••••••••">
                        <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 {{ $errors->has('password') ? 'text-red-400' : 'text-gray-300' }} group-focus-within:text-primary transition-colors"></i>
                    </div>
                    @error('password') <p class="text-[10px] text-red-500 font-bold mt-1 ml-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[11px] font-black text-gray-300 uppercase tracking-widest mb-2 ml-2">Confirm Password</label>
                    <div class="relative group">
                        <input name="password_confirmation" type="password" required class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary group-hover:bg-white" placeholder="••••••••">
                        <i class="fas fa-check-circle absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors"></i>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-black uppercase tracking-widest rounded-2xl text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-xl shadow-primary/30 hover:shadow-primary/50 transition-all transform hover:-translate-y-1">
                Create Account
            </button>
            
            <p class="mt-2 text-center text-xs text-gray-500">
                Already have an account? <a href="{{ route('login') }}" class="font-bold text-primary hover:text-secondary transition">Sign in</a>
            </p>
        </form>
    </div>
</div>
@endsection