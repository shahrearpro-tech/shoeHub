@extends('layouts.app')

@section('title', 'Order Confirmed - ' . config('app.name'))

@section('content')
<div class="bg-[#f4f7fe] min-h-screen py-12 md:py-24 relative overflow-hidden">
    <!-- Abstract Background Elements -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px] -mr-48 -mt-48 z-0"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-purple-500/5 rounded-full blur-[120px] -ml-48 -mb-48 z-0"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto">
            <!-- Success Header -->
            <div class="text-center mb-16 animate-fade-in-up">
                <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-xl shadow-green-500/10">
                    <i class="fas fa-check text-4xl text-green-500"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-display font-black text-secondary tracking-tight mb-4">Manifest <span class="text-primary">Secured</span></h1>
                <p class="text-gray-500 text-lg max-w-lg mx-auto font-medium">Your order has been authorized and is currently being processed through our logistics grid.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Order Details Card -->
                <div class="lg:col-span-8 space-y-8 animate-fade-in-up delay-100">
                    <div class="bg-white rounded-[3rem] p-10 md:p-14 shadow-[0_40px_100px_-20px_rgba(0,0,0,0.04)] border border-white overflow-hidden relative">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10 pb-6 border-b border-gray-50">
                            <h2 class="text-2xl font-display font-black text-secondary uppercase tracking-tight">Operational Summary</h2>
                            <span class="inline-block px-6 py-2 bg-gray-50 border border-gray-100 rounded-full text-[10px] font-black tracking-[0.3em] text-primary uppercase select-all w-fit">#{{ $order->order_number }}</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Target Destination</p>
                                <div class="space-y-1">
                                    <p class="font-bold text-secondary">{{ $order->customer_name }}</p>
                                    <p class="text-sm text-gray-500 italic">{{ $order->shipping_address_line1 }}</p>
                                    <p class="text-sm text-gray-500 font-bold">{{ $order->shipping_city }} {{ $order->shipping_postal_code }}</p>
                                    <p class="text-sm text-gray-400 uppercase font-black tracking-widest text-[9px] mt-2">LINK: {{ $order->customer_phone }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Settlement Stats</p>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Method</span>
                                        <span class="font-black text-primary uppercase text-xs">{{ strtoupper($order->payment_method) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Protocol</span>
                                        <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-500 rounded-full text-[9px] font-black uppercase tracking-widest">
                                            <span class="w-1 h-1 rounded-full bg-blue-500 mr-2 animate-pulse"></span> {{ $order->order_status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Itemized List -->
                        <div class="space-y-6 pt-10 border-t border-gray-50">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Manifest items</p>
                            @foreach($order->items as $item)
                                <div class="flex gap-6 group">
                                    <div class="w-20 h-20 bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden flex-shrink-0 group-hover:shadow-lg transition-all">
                                        <img src="{{ getProductImage($item->product->featured_image ?? '') }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-secondary text-sm group-hover:text-primary transition-colors mb-1 line-clamp-1">{{ $item->product_name }}</h4>
                                        <div class="flex items-center gap-3 text-[10px] font-black text-gray-300 tracking-widest uppercase mb-2">
                                            <span class="text-primary/50">#{{ $item->product->sku ?? 'N/A' }}</span>
                                            @if($item->size) <span class="w-1 h-1 rounded-full bg-gray-200"></span> <span>Size: <span class="text-secondary">{{ $item->size }}</span></span> @endif
                                            @if($item->color) <span class="w-1 h-1 rounded-full bg-gray-200"></span> <span>Color: <span class="text-secondary">{{ $item->color }}</span></span> @endif
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $item->quantity }} Units</p>
                                            <p class="font-black text-secondary">৳{{ number_format($item->total_price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Summary & Navigation -->
                <div class="lg:col-span-4 space-y-8 animate-fade-in-up delay-200">
                    <div class="bg-secondary p-10 rounded-[3rem] shadow-2xl relative overflow-hidden group">
                        <!-- Abstract Mesh -->
                        <div class="absolute inset-0 opacity-[0.03] pointer-events-none group-hover:opacity-[0.05] transition-opacity" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 15px 15px;"></div>
                        
                        <h3 class="text-white/40 text-[10px] font-black uppercase tracking-[0.3em] mb-4">Total Settlement</h3>
                        <div class="text-3xl md:text-4xl font-display font-black text-white tracking-tighter mb-10 break-all">৳{{ number_format($order->total_amount, 2) }}</div>
                        
                        <div class="space-y-4 mb-10 pt-8 border-t border-white/10 text-[10px] font-bold text-white/60 uppercase tracking-widest">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span class="text-white">৳{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Logistics</span>
                                <span class="text-white">৳{{ number_format($order->delivery_charge, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('account.orders') }}" class="w-full bg-white text-secondary py-6 rounded-3xl font-black uppercase text-[10px] tracking-[0.2em] flex items-center justify-center gap-3 hover:bg-primary hover:text-white transition-all shadow-xl shadow-black/10">
                            Track Manifest <i class="fas fa-radar"></i>
                        </a>
                    </div>

                    @if(session('new_account'))
                    <div class="bg-primary/10 border border-primary/20 p-8 rounded-[3rem] relative overflow-hidden">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-primary/10 rounded-full blur-2xl"></div>
                        <p class="text-[10px] font-black text-primary uppercase tracking-[0.2em] mb-3">Access Authorized</p>
                        <h4 class="text-lg font-display font-black text-secondary mb-4 leading-tight">Your account has been auto-generated.</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between bg-white px-5 py-3 rounded-2xl border border-primary/10">
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Email</span>
                                <span class="text-[10px] font-black text-secondary select-all">{{ $order->customer_email }}</span>
                            </div>
                            <div class="flex items-center justify-between bg-white px-5 py-3 rounded-2xl border border-primary/10">
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Password</span>
                                <span class="text-[10px] font-black text-primary select-all">{{ session('temp_password') }}</span>
                            </div>
                        </div>
                        <p class="mt-4 text-[9px] text-gray-400 font-bold uppercase tracking-widest opacity-60">Redirecting to history grid...</p>
                    </div>
                    @endif

                    <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-white">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6">Secondary Actions</p>
                        <div class="space-y-4">
                            <button onclick="downloadInvoice()" class="w-full flex items-center justify-center gap-4 bg-primary text-white py-5 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-blue-600 transition-all shadow-lg shadow-primary/20">
                                <i class="fas fa-download text-xs"></i> Download Invoice
                            </button>
                            <a href="{{ route('invoice', $order->order_number) }}" target="_blank" class="w-full flex items-center justify-center gap-4 bg-gray-50 text-secondary py-5 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-gray-100 transition-colors">
                                <i class="fas fa-print text-xs opacity-50"></i> Print Invoice
                            </a>
                            <a href="{{ route('shop') }}" class="w-full flex items-center justify-center gap-4 border-2 border-gray-50 text-gray-400 py-5 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:border-primary hover:text-primary transition-all">
                                <i class="fas fa-cart-shopping text-xs opacity-50"></i> Return to Grid
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function downloadInvoice() {
        // Redirect to invoice page with download parameter
        window.location.href = "{{ route('invoice', $order->order_number) }}?download=1";
    }
</script>
@endpush
@endsection
