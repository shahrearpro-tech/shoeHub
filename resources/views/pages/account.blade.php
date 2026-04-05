@extends('layouts.app')

@section('title', 'My Account - ' . config('app.name'))

@section('content')
<div class="bg-[#f4f7fe] min-h-screen py-12 relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <h1 class="text-4xl font-display font-black text-secondary mb-8">My Account</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm p-6 sticky top-24">
                    <div class="flex items-center gap-4 mb-8 pb-8 border-b border-gray-100">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary text-xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-secondary">{{ $user->name }}</h3>
                            <p class="text-xs text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>
                    
                    <nav class="space-y-2">
                        <a href="{{ route('account') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary text-white font-bold transition">
                            <i class="fas fa-home w-5"></i> Dashboard
                        </a>
                        <a href="{{ route('account.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-secondary font-bold transition">
                            <i class="fas fa-shopping-bag w-5"></i> My Orders
                        </a>
                        <a href="{{ route('account.addresses') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-secondary font-bold transition">
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

            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Welcome Card -->
                <div class="bg-primary text-white rounded-[2.5rem] p-8 md:p-12 relative overflow-hidden shadow-lg shadow-primary/20">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-display font-bold mb-2">Welcome back, {{ explode(' ', $user->name)[0] }}!</h2>
                        <p class="text-white/80 max-w-lg mb-8">Here you can view your recent orders, manage your shipping addresses, and edit your password and account details.</p>
                        <div class="flex gap-4">
                            <a href="{{ route('shop') }}" class="px-6 py-3 bg-white text-primary font-bold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">Continue Shopping</a>
                        </div>
                    </div>
                   <div class="absolute right-0 bottom-0 opacity-10 transform translate-y-1/4 translate-x-1/4">
                       <i class="fas fa-shopping-bag text-[20rem]"></i>
                   </div>
                </div>

                <!-- Recent Orders Preview -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-secondary">Recent Orders</h3>
                        <a href="{{ route('account.orders') }}" class="text-sm font-bold text-primary hover:underline">View All</a>
                    </div>
                    
                    @if($recentOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-gray-400 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                                        <th class="pb-4 pl-4">Order</th>
                                        <th class="pb-4">Date</th>
                                        <th class="pb-4">Status</th>
                                        <th class="pb-4">Total</th>
                                        <th class="pb-4 pr-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($recentOrders as $order)
                                    <tr class="group hover:bg-gray-50 transition">
                                        <td class="py-4 pl-4 font-bold text-secondary">#{{ $order->order_number }}</td>
                                        <td class="py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="py-4">
                                            <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase {{ $order->order_status === 'delivered' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                        <td class="py-4 font-bold text-secondary">৳{{ number_format($order->total_amount) }}</td>
                                        <td class="py-4 pr-4 text-right">
                                            <a href="{{ route('order.details', $order->order_number) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 text-primary hover:bg-primary hover:text-white transition">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300 text-2xl">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <p class="text-gray-500 font-medium">No orders found yet.</p>
                            <a href="{{ route('shop') }}" class="text-primary font-bold mt-2 inline-block hover:underline">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
