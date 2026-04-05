@extends('layouts.admin')

@section('title', 'Order Details #' . $order->order_number)

@section('content')
<div class="flex flex-col lg:flex-row gap-8">
    <!-- Main Content -->
    <div class="flex-1 space-y-8 animate-slide-in-up">
        <!-- Order Items -->
        <div class="bg-white rounded-[40px] shadow-2xl border border-white/20 overflow-hidden">
            <div class="px-10 py-8 border-b border-gray-50 bg-white">
                <h2 class="text-2xl font-black text-secondary tracking-tight">Order Items</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Product</th>
                            <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Price</th>
                            <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Qty</th>
                            <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-xl bg-gray-50 overflow-hidden shrink-0 border border-gray-100">
                                        @if($item->product && $item->product->featured_image)
                                            <img src="{{ getProductImage($item->product->featured_image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-secondary text-sm mb-1">{{ $item->product_name }}</p>
                                        <div class="flex gap-2 text-[10px] font-black text-gray-400 uppercase tracking-wider">
                                            @if($item->size) <span class="bg-gray-50 px-2 py-1 rounded">Size: {{ $item->size }}</span> @endif
                                            @if($item->color) <span class="bg-gray-50 px-2 py-1 rounded">Color: {{ $item->color }}</span> @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6 font-medium text-sm text-gray-600">{{ formatPrice($item->price) }}</td>
                            <td class="px-10 py-6 font-bold text-secondary text-sm">x{{ $item->quantity }}</td>
                            <td class="px-10 py-6 font-black text-primary text-sm text-right">{{ formatPrice($item->price * $item->quantity) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50/30">
                        <tr>
                            <td colspan="3" class="px-10 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Subtotal</td>
                            <td class="px-10 py-4 text-right font-black text-secondary">{{ formatPrice($order->total_amount) }}</td>
                        </tr>
                        <!-- If shipping/tax were separate, they'd go here. Assuming total for now. -->
                        <tr class="bg-primary/5">
                            <td colspan="3" class="px-10 py-6 text-right text-sm font-black text-primary uppercase tracking-widest">Grand Total</td>
                            <td class="px-10 py-6 text-right text-xl font-black text-primary">{{ formatPrice($order->total_amount) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Status History -->
        <div class="bg-white rounded-[40px] shadow-2xl border border-white/20 p-10">
            <h3 class="text-xl font-black text-secondary tracking-tight mb-8">Order History</h3>
            <div class="relative border-l-2 border-gray-100 ml-3 space-y-8">
                @foreach($order->statusHistory as $history)
                <div class="relative pl-8">
                    <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-white border-4 border-gray-200"></div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            {!! getOrderStatusBadge($history->status) !!}
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $history->created_at->format('M d, Y H:i A') }}</span>
                        </div>
                        @if($history->notes)
                            <p class="text-xs text-gray-500 mt-2 bg-gray-50 p-3 rounded-xl">{{ $history->notes }}</p>
                        @endif
                        <p class="text-[10px] text-gray-400 mt-1">Updated by {{ $history->createdBy->name ?? 'System' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="w-full lg:w-96 space-y-8 animate-slide-in-right">
        <!-- Status Action -->
        <div class="bg-white rounded-[32px] shadow-xl border border-white/20 p-8">
            <h3 class="text-lg font-black text-secondary tracking-tight mb-6">Update Status</h3>
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">New Status</label>
                    <div class="relative">
                        <select name="status" class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-primary/20 outline-none appearance-none cursor-pointer">
                            @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ $order->order_status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>
                
                <div>
                     <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Note (Optional)</label>
                     <textarea name="notes" rows="3" placeholder="Add a note..." class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-medium focus:ring-2 focus:ring-primary/20 outline-none text-sm"></textarea>
                </div>
                
                <button type="submit" class="w-full py-4 bg-secondary text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-primary transition shadow-lg shadow-secondary/20">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-[32px] shadow-xl border border-white/20 p-8">
            <h3 class="text-lg font-black text-secondary tracking-tight mb-6">Customer Details</h3>
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-500">
                        {{ substr($order->customer_name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-secondary">{{ $order->customer_name }}</p>
                        <p class="text-xs text-gray-400 font-medium">Customer</p>
                    </div>
                </div>
                
                <div class="space-y-4 pt-4 border-t border-gray-50">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                            <i class="fas fa-envelope text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Email</p>
                            <a href="mailto:{{ $order->customer_email }}" class="text-sm font-bold text-secondary hover:text-primary transition">{{ $order->customer_email }}</a>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-green-50 text-green-500 flex items-center justify-center shrink-0">
                            <i class="fas fa-phone text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Phone</p>
                            <a href="tel:{{ $order->customer_phone }}" class="text-sm font-bold text-secondary hover:text-primary transition">{{ $order->customer_phone ?? 'N/A' }}</a>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                            <i class="fas fa-map-marker-alt text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Shipping Address</p>
                            <p class="text-sm font-medium text-gray-600 leading-relaxed">{{ $order->shipping_address_line1 }}</p>
                            @if($order->shipping_address_line2)
                                <p class="text-sm font-medium text-gray-600 leading-relaxed">{{ $order->shipping_address_line2 }}</p>
                            @endif
                            <p class="text-sm font-medium text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                            <p class="text-sm font-medium text-gray-600">{{ $order->shipping_country }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
