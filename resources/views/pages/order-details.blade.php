@extends('layouts.app')

@section('title', 'Order Manifest - #' . $order->order_number . ' - ' . config('app.name'))

@section('content')
<div class="bg-[#f4f7fe] min-h-screen py-12 md:py-20 relative overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px] -mr-64 -mt-64 z-0"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-500/5 rounded-full blur-[120px] -ml-64 -mb-64 z-0"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto">
            
            <!-- Breadcrumbs -->
            <nav class="flex mb-10 text-[11px] uppercase tracking-[0.2em] font-bold text-gray-400">
                <a href="{{ route('account.orders') }}" class="hover:text-primary transition-colors">Digital Account</a>
                <span class="mx-3 opacity-30">/</span>
                <span class="text-secondary">Manifest #{{ $order->order_number }}</span>
            </nav>

            <!-- Main Manifest Card -->
            <div class="bg-white rounded-[2.5rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.08)] overflow-hidden border border-white">
                
                <!-- Manifest Header (Cinematic) -->
                <div class="relative bg-secondary p-10 md:p-14 text-white overflow-hidden">
                    <!-- Subtle Mesh Pattern -->
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                        <div>
                            <span class="inline-block px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[10px] font-black tracking-[0.2em] uppercase mb-4 border border-white/10">Official Order Manifest</span>
                            <h1 class="text-4xl md:text-5xl font-display font-extrabold tracking-tight mb-2">
                                #{{ $order->order_number }}
                            </h1>
                            <p class="text-white/60 font-medium tracking-wide">
                                Processed on {{ $order->created_at->format('F j, Y') }}
                            </p>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-4 flex items-center gap-4 transition-all hover:bg-white/10">
                                <div class="w-12 h-12 rounded-xl bg-primary/20 flex items-center justify-center text-primary text-xl shadow-inner">
                                    <i class="fas fa-barcode"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-white/40 font-bold mb-0.5">Manifest Status</p>
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
                                        <div class="w-2 h-2 rounded-full bg-{{ $statusColor }}-400 animate-pulse shadow-[0_0_10px_rgba(74,222,128,0.5)]"></div>
                                        <span class="font-bold text-sm uppercase tracking-wider">{{ $order->order_status }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Watermark -->
                    <div class="absolute -right-10 -bottom-10 opacity-[0.03] select-none pointer-events-none transform rotate-12">
                        <i class="fas fa-shield-check text-[20rem]"></i>
                    </div>
                </div>

                <!-- Manifest Body -->
                <div class="p-10 md:p-14">
                    
                    <!-- Top Actions Bar -->
                    <div class="flex flex-wrap gap-4 mb-16 pb-8 border-b border-gray-50">
                        <a href="{{ route('invoice', $order->order_number) }}" target="_blank" class="flex-1 md:flex-none px-6 py-4 bg-gray-50 rounded-2xl text-sm font-bold text-secondary hover:bg-white hover:shadow-xl hover:shadow-gray-200/50 transition-all border border-gray-100 flex items-center justify-center gap-3">
                            <i class="fas fa-file-invoice text-primary"></i> Digital Invoice
                        </a>
                        @if(!in_array($order->order_status, ['delivered', 'cancelled', 'returned']))
                            <a href="#" class="flex-1 md:flex-none px-6 py-4 bg-gray-50 rounded-2xl text-sm font-bold text-secondary hover:bg-white hover:shadow-xl hover:shadow-gray-200/50 transition-all border border-gray-100 flex items-center justify-center gap-3">
                                <i class="fas fa-map-marker-alt text-primary"></i> Live Tracking
                            </a>
                        @endif
                        <a href="{{ route('order.reorder', $order->id) }}" class="flex-1 md:flex-none px-6 py-4 bg-primary text-white rounded-2xl text-sm font-bold hover:shadow-2xl hover:shadow-primary/30 transition-all shadow-xl shadow-primary/10 flex items-center justify-center gap-3">
                            <i class="fas fa-redo"></i> Reorder Items
                        </a>
                    </div>

                    <!-- Secondary Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 mb-20">
                        <!-- Shipping Grid Item -->
                        <div>
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-primary text-lg">
                                    <i class="fas fa-truck-loading"></i>
                                </div>
                                <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Destination Protocol</h2>
                            </div>
                            <div class="bg-gray-50/50 rounded-[2rem] p-8 border border-gray-50">
                                <p class="font-display font-bold text-xl text-secondary mb-3">{{ $order->customer_name }}</p>
                                <div class="text-gray-500 font-medium space-y-1.5 leading-relaxed">
                                    <p>{{ $order->shipping_address_line1 }}</p>
                                    @if($order->shipping_address_line2)
                                        <p>{{ $order->shipping_address_line2 }}</p>
                                    @endif
                                    <p>{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                                    <p class="text-secondary font-bold pt-2 flex items-center gap-2">
                                        <i class="fas fa-phone-alt text-xs opacity-50"></i>
                                        {{ $order->customer_phone }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Grid Item -->
                        <div>
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 text-lg">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Financial Settlement</h2>
                            </div>
                            <div class="bg-gray-50/50 rounded-[2rem] p-8 border border-gray-50 space-y-6">
                                <div class="flex justify-between items-center pb-6 border-b border-gray-100">
                                    <div>
                                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Method</p>
                                        <p class="font-bold text-secondary uppercase tracking-wider">{{ $order->payment_method }}</p>
                                    </div>
                                    <div class="w-12 h-12 rounded-xl bg-white border border-gray-100 flex items-center justify-center shadow-sm">
                                        <i class="fas fa-{{ $order->payment_method == 'cod' ? 'hand-holding-usd' : 'wallet' }} text-gray-400"></i>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Status</p>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-green-100">
                                            <i class="fas fa-check-circle text-[8px]"></i>
                                            {{ $order->payment_status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items Manifest -->
                    <div class="mb-20">
                        <div class="flex items-center justify-between mb-10">
                            <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Itemized Manifest</h2>
                            <span class="text-[10px] font-bold text-primary bg-primary/5 px-3 py-1 rounded-full border border-primary/10">
                                {{ $order->items->count() }} Unique Items
                            </span>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="group flex flex-col md:flex-row items-center gap-8 p-6 bg-white rounded-3xl border border-gray-100 hover:border-primary/20 hover:shadow-2xl hover:shadow-gray-200/50 transition-all">
                                    <div class="w-24 h-24 bg-gray-50 rounded-2xl overflow-hidden flex-shrink-0 border border-gray-100 group-hover:scale-105 transition-transform">
                                        <img src="{{ getProductImage($item->product->featured_image ?? '') }}" class="w-full h-full object-cover">
                                    </div>
                                    
                                    <div class="flex-1 text-center md:text-left">
                                        <h3 class="font-display font-bold text-xl text-secondary mb-2 group-hover:text-primary transition-colors">{{ $item->product_name }}</h3>
                                        <div class="flex flex-wrap justify-center md:justify-start gap-4">
                                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Quantity: <span class="text-secondary">{{ $item->quantity }}</span></span>
                                            @if($item->size) 
                                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Size: <span class="text-secondary">{{ $item->size }}</span></span>
                                            @endif
                                            @if($item->color) 
                                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Color: <span class="text-secondary">{{ $item->color }}</span></span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="text-center md:text-right">
                                        <p class="font-display font-black text-2xl text-secondary mb-1">৳{{ number_format($item->total_price, 2) }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">৳{{ number_format($item->unit_price, 2) }} Unit price</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Manifest Totals -->
                    <div class="flex justify-end">
                        <div class="w-full md:w-80 space-y-4">
                            <div class="flex justify-between items-center text-gray-400 text-[10px] font-black uppercase tracking-widest">
                                <span>Manifest Subtotal</span>
                                <span class="text-secondary font-bold shadow-sm">৳{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-400 text-[10px] font-black uppercase tracking-widest">
                                <span>Logistics / Shipping</span>
                                <span class="text-secondary font-bold">৳{{ number_format($order->delivery_charge, 2) }}</span>
                            </div>
                            
                            <div class="pt-8 border-t border-gray-100 flex justify-between items-end">
                                <div>
                                    <p class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-1">Final Settlement</p>
                                    <h4 class="text-4xl font-display font-black text-secondary">৳{{ number_format($order->total_amount, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Manifest Footer -->
                <div class="p-10 border-t border-gray-50 bg-[#FBFDFF] flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center text-purple-600">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <p class="text-xs text-gray-400 max-w-xs leading-relaxed">
                            This manifest is a digitally verified record of your transaction. For support, please contact <span class="text-secondary font-bold">support@shoehub.com</span>.
                        </p>
                    </div>
                    
                    <a href="{{ route('account.orders') }}" class="px-8 py-4 bg-white border border-gray-200 rounded-2xl text-[11px] font-black uppercase tracking-widest text-secondary hover:bg-gray-50 transition-all shadow-sm">
                        <i class="fas fa-arrow-left mr-3 opacity-50"></i> Return to Control Center
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
