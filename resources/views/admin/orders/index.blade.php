@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="bg-white rounded-[40px] shadow-2xl border border-white/20 overflow-hidden animate-slide-in-up">
    <!-- Header -->
    <div class="px-10 py-8 border-b border-gray-50 flex flex-col md:flex-row justify-between items-center gap-6 bg-white">
        <div>
            <h2 class="text-3xl font-black text-secondary tracking-tight">Order Management</h2>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Track and manage shipments</p>
        </div>
        
        <div class="flex flex-wrap gap-4">
            <!-- Filter -->
            <form action="{{ route('admin.orders') }}" method="GET" class="flex items-center gap-3 bg-gray-50 rounded-2xl p-1.5 border border-gray-100">
                <select name="status" onchange="this.form.submit()" class="bg-transparent border-none text-xs font-bold uppercase tracking-wider text-gray-500 py-2 px-4 focus:ring-0 cursor-pointer">
                    <option value="">All Statuses</option>
                    @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </form>
            
            <!-- Search -->
            <form action="{{ route('admin.orders') }}" method="GET" class="relative group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders..." class="w-64 pl-12 pr-6 py-3 rounded-2xl bg-gray-50 border-none text-secondary font-bold text-xs shadow-inner focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Order ID</th>
                    <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Customer</th>
                    <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                    <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Total</th>
                    <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                <tr class="group hover:bg-gray-50/30 transition-colors">
                    <td class="px-10 py-6">
                        <span class="font-black text-secondary font-mono bg-gray-100 px-3 py-1 rounded-lg text-xs">{{ $order->order_number }}</span>
                    </td>
                    <td class="px-10 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center font-bold text-xs text-gray-600">
                                {{ substr($order->customer_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-secondary text-sm">{{ $order->customer_name }}</p>
                                <p class="text-[10px] text-gray-400 font-medium tracking-wide">{{ $order->customer_email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-10 py-6 font-bold text-xs text-secondary">
                        {{ $order->created_at->format('M d, Y') }}<br>
                        <span class="text-[10px] text-gray-400 font-medium">{{ $order->created_at->format('H:i') }}</span>
                    </td>
                    <td class="px-10 py-6 font-black text-secondary text-sm">
                        {{ formatPrice($order->total_amount) }}
                    </td>
                    <td class="px-10 py-6">
                        {!! getOrderStatusBadge($order->order_status) !!}
                    </td>
                    <td class="px-10 py-6 text-right">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all shadow-sm">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-10 py-20 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-box-open text-gray-300 text-2xl"></i>
                            </div>
                            <p class="text-gray-400 font-bold text-sm">No orders found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-10 py-8 border-t border-gray-50">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
@endsection
