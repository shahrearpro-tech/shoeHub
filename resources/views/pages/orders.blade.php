@extends('layouts.app')

@section('title', 'My Manifests - ' . config('app.name'))

@section('content')
<div class="bg-[#f4f7fe] min-h-screen py-12 md:py-20 relative overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px] -mr-64 -mt-64 z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            
            <!-- Account Navigation -->
            <aside class="lg:col-span-1 space-y-8 animate-fade-in-up">
                <div class="bg-white rounded-3xl shadow-sm p-6 sticky top-24">
                     <nav class="space-y-2">
                        <a href="{{ route('account') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('account') ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-secondary' }} font-bold transition">
                            <i class="fas fa-home w-5"></i> Dashboard
                        </a>
                        <a href="{{ route('account.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('account.orders*') ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-secondary' }} font-bold transition">
                            <i class="fas fa-shopping-bag w-5"></i> My Manifests
                        </a>
                        <a href="{{ route('account.addresses') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('account.addresses') ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-secondary' }} font-bold transition">
                            <i class="fas fa-map-marker-alt w-5"></i> Addresses
                        </a>
                        <a href="{{ route('account.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('account.profile') ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-secondary' }} font-bold transition">
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
            </aside>
            
            <!-- Main Content -->
            <main class="lg:col-span-3 space-y-10 animate-fade-in-up delay-100">
                
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-4">
                    <div>
                        <span class="inline-block px-3 py-1 bg-primary/5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase mb-4 border border-primary/10 text-primary">Order History</span>
                        <h1 class="text-4xl md:text-5xl font-display font-extrabold tracking-tight text-secondary">
                            My <span class="text-primary">Manifests</span>
                        </h1>
                    </div>
                    <div class="bg-white px-6 py-4 rounded-[1.5rem] shadow-sm border border-white flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-primary">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Total Logged</p>
                            <p class="text-xl font-display font-black text-secondary leading-none">{{ $orders->total() }}</p>
                        </div>
                    </div>
                </div>
                
                @if($orders->isEmpty())
                    <div class="bg-white rounded-[2.5rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.05)] p-20 text-center border border-white animate-fade-in-up">
                        <div class="w-32 h-32 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-8 relative">
                            <div class="absolute inset-0 bg-primary/10 rounded-[2rem] animate-pulse"></div>
                            <i class="fas fa-archive text-5xl text-gray-200 relative z-10"></i>
                        </div>
                        <h3 class="text-2xl font-display font-bold text-secondary mb-3 transition-colors">No Manifests Logged</h3>
                        <p class="text-gray-400 mb-10 text-sm max-w-sm mx-auto font-medium">It appears you haven't initiated any order protocols yet. Explore our latest drops to start your first manifest.</p>
                        <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-10 py-5 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-1 transition-all">
                            Browse Collection <i class="fas fa-arrow-right ml-3"></i>
                        </a>
                    </div>
                @else
                    <!-- Orders Manifest List -->
                    <div class="space-y-6">
                        @foreach($orders as $order)
                            <div class="bg-white rounded-[2.2rem] shadow-[0_20px_50px_-15px_rgba(0,0,0,0.03)] p-6 md:p-8 border border-white hover:border-primary/20 transition-all hover:shadow-[0_40px_100px_-20px_rgba(0,0,0,0.08)] group relative overflow-hidden">
                                <!-- Interior Accent -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-primary/10 transition-colors"></div>
                                
                                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                                    <!-- Context Info -->
                                    <div class="flex items-center gap-6 w-full lg:w-auto">
                                        <div class="w-16 h-16 rounded-2xl bg-secondary flex items-center justify-center text-white text-2xl shadow-xl shadow-secondary/10 group-hover:bg-primary transition-colors">
                                            <i class="fas fa-box-open"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-display font-bold text-xl text-secondary mb-1">Manifest #{{ $order->order_number }}</h3>
                                            <div class="flex items-center gap-3">
                                                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">{{ $order->created_at->format('M d, Y') }}</span>
                                                <span class="w-1 h-1 rounded-full bg-gray-200"></span>
                                                <div class="flex items-center gap-2">
                                                    @php
                                                        $statusColor = match($order->order_status) {
                                                            'delivered' => 'green',
                                                            'pending' => 'yellow',
                                                            'processing' => 'blue',
                                                            'cancelled' => 'red',
                                                            default => 'gray'
                                                        };
                                                    @endphp
                                                    <div class="w-1.5 h-1.5 rounded-full bg-{{ $statusColor }}-500 shadow-[0_0_8px_rgba(34,197,94,0.5)]"></div>
                                                    <span class="text-[10px] font-black text-{{ $statusColor }}-600 uppercase tracking-widest text-[9px]">{{ $order->order_status }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Financial & Status Grid -->
                                    <div class="flex flex-wrap items-center justify-center md:justify-end gap-x-12 gap-y-6 w-full lg:w-auto">
                                        <div class="text-center md:text-right">
                                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Settlement</p>
                                            <p class="text-2xl font-display font-black text-secondary">৳{{ number_format($order->total_amount, 2) }}</p>
                                        </div>
                                        
                                        <!-- Actions -->
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('order.details', $order->order_number) }}" 
                                               class="h-14 px-8 bg-gray-50 border border-gray-100 flex items-center justify-center rounded-2xl text-[10px] font-black uppercase tracking-widest text-secondary hover:bg-white hover:shadow-xl hover:shadow-gray-200/50 transition-all">
                                                Visual Details
                                            </a>
                                            <a href="{{ route('invoice', $order->order_number) }}" target="_blank"
                                               class="w-14 h-14 bg-primary text-white flex items-center justify-center rounded-2xl shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-1 transition-all">
                                                <i class="fas fa-file-invoice text-sm"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Manifest Pagination -->
                    <div class="mt-12">
                        {{ $orders->links() }}
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection
