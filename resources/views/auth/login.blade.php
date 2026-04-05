@extends('layouts.app')

@section('title', 'Login - ' . config('app.name'))

@section('content')
<div class="min-h-[calc(100vh-80px)] bg-[#f4f7fe] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Blobs -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-[100px] animate-blob"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-500/5 rounded-full blur-[100px] animate-blob animation-delay-2000"></div>

    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-[2.5rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.05)] border border-gray-100 relative z-10">
        <div class="text-center">
            <h2 class="text-3xl font-display font-black text-secondary mb-2">Welcome Back</h2>
            <p class="text-gray-400 text-sm">Access your secure dashboard</p>
        </div>

        @if($errors->any())
            <div class="mt-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl animate-shake">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-bold text-red-700 uppercase tracking-wider">
                            {{ $errors->first() }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mt-8 bg-green-50 border-l-4 border-green-500 p-4 rounded-xl animate-fade-in">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-bold text-green-700 uppercase tracking-wider">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        
        <form class="mt-8 space-y-6" action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-[11px] font-black text-gray-300 uppercase tracking-widest mb-2 ml-2">Email Address</label>
                    <div class="relative group">
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary group-hover:bg-white" 
                               placeholder="john@example.com">
                        <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors"></i>
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-[11px] font-black text-gray-300 uppercase tracking-widest mb-2 ml-2">Password</label>
                    <div class="relative group">
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary focus:bg-white outline-none transition-all font-bold text-secondary group-hover:bg-white" 
                               placeholder="••••••••">
                        <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors"></i>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-xs font-bold text-gray-500">Remember me</label>
                </div>
                <div class="text-xs">
                    <a href="#" class="font-bold text-primary hover:text-secondary transition">Forgot your password?</a>
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-black uppercase tracking-widest rounded-2xl text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-xl shadow-primary/30 hover:shadow-primary/50 transition-all transform hover:-translate-y-1">
                Sign in
            </button>
            
            <p class="mt-2 text-center text-xs text-gray-500">
                Not a member? <a href="{{ route('register') }}" class="font-bold text-primary hover:text-secondary transition">Start your journey</a>
            </p>
        </form>
    </div>
</div>
@endsection