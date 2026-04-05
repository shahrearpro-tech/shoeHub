@extends('layouts.admin')

@section('title', 'Customers')

@section('content')
<div class="bg-white rounded-[40px] shadow-2xl border border-white/20 overflow-hidden animate-slide-in-up">
    <!-- Header -->
    <div class="px-10 py-8 border-b border-gray-50 flex flex-col md:flex-row justify-between items-center gap-6 bg-white">
        <div>
            <h2 class="text-3xl font-black text-secondary tracking-tight">Customers</h2>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Manage user base</p>
        </div>
        
        <!-- Search -->
        <form action="{{ route('admin.customers') }}" method="GET" class="relative group">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customers..." class="w-64 pl-12 pr-6 py-3 rounded-2xl bg-gray-50 border-none text-secondary font-bold text-xs shadow-inner focus:ring-2 focus:ring-primary/20 outline-none transition-all">
            <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">User</th>
                    <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Contact Info</th>
                    <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Joined Date</th>
                    <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Orders</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($customers as $customer)
                <tr class="group hover:bg-gray-50/30 transition-colors">
                    <td class="px-10 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center font-bold text-sm text-blue-600">
                                {{ substr($customer->name, 0, 1) }}
                            </div>
                            <span class="font-bold text-secondary text-sm">{{ $customer->name }}</span>
                        </div>
                    </td>
                    <td class="px-10 py-6">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-envelope text-gray-300 text-xs w-4"></i>
                                <span class="text-sm font-medium text-gray-600">{{ $customer->email }}</span>
                            </div>
                            @if($customer->phone)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-phone text-gray-300 text-xs w-4"></i>
                                <span class="text-xs font-medium text-gray-500">{{ $customer->phone }}</span>
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-10 py-6 font-bold text-xs text-secondary">
                        {{ $customer->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-10 py-6 text-center">
                        <span class="px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600">{{ $customer->orders_count }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-20 text-center">
                         <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-users text-gray-300 text-2xl"></i>
                            </div>
                            <p class="text-gray-400 font-bold text-sm">No customers found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-10 py-8 border-t border-gray-50">
        {{ $customers->withQueryString()->links() }}
    </div>
</div>
@endsection
