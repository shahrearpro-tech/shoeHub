@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Dashboard V2 Main Container -->
<div class="space-y-8 animate-fade-in">

    <!-- KPI Metrics Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue Card -->
        <div class="glass-card p-6 rounded-[24px] shadow-sm hover:shadow-xl transition-all duration-300 group bg-white border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform">
                    <i class="fas fa-wallet"></i>
                </div>
                <div id="revenue-sparkline" class="w-24"></div>
            </div>
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Monthly Revenue</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-secondary tracking-tight" id="kpi-revenue">৳{{ number_format($kpis['revenue']['value'] ?? 0) }}</h3>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-green-50 text-green-600 mb-1.5">+0%</span>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="glass-card p-6 rounded-[24px] shadow-sm hover:shadow-xl transition-all duration-300 group bg-white border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div id="orders-sparkline" class="w-24"></div>
            </div>
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Monthly Orders</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-secondary tracking-tight" id="kpi-orders">{{ number_format($kpis['orders']['value'] ?? 0) }}</h3>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-green-50 text-green-600 mb-1.5">+0%</span>
                </div>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="glass-card p-6 rounded-[24px] shadow-sm hover:shadow-xl transition-all duration-300 group bg-white border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform">
                    <i class="fas fa-users"></i>
                </div>
                <div id="customers-sparkline" class="w-24"></div>
            </div>
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Customers</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-secondary tracking-tight" id="kpi-customers">{{ number_format($kpis['customers']['value'] ?? 0) }}</h3>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-green-50 text-green-600 mb-1.5">+0%</span>
                </div>
            </div>
        </div>

        <!-- Rating Card -->
        <div class="glass-card p-6 rounded-[24px] shadow-sm hover:shadow-xl transition-all duration-300 group bg-white border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition-transform">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Avg Rating</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-black text-secondary tracking-tight">{{ $kpis['avg_rating']['value'] ?? '0.0' }}</h3>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-yellow-50 text-yellow-600 mb-1.5">★</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Feed Row -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Main Revenue Chart (8 Columns) -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-50">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-xl font-black text-secondary">Revenue Trends</h3>
                        <p class="text-gray-400 text-xs font-bold mt-1">Daily revenue overview for the current month</p>
                    </div>
                </div>
                <div id="main-revenue-chart" class="h-[350px]"></div>
            </div>

            <!-- Recent Orders Grid -->
            <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-50">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-secondary tracking-tight">Recent Orders</h3>
                    <a href="{{ route('admin.orders') }}" class="text-sm font-bold text-primary hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-400 text-[10px] font-black uppercase tracking-widest border-b border-gray-50">
                                <th class="pb-4">Order ID</th>
                                <th class="pb-4">Customer</th>
                                <th class="pb-4">Status</th>
                                <th class="pb-4">Total</th>
                                <th class="pb-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="recent-orders-list" class="divide-y divide-gray-50/50">
                            @foreach($recentOrders as $order)
                            <tr class="group hover:bg-gray-50/50 transition">
                                <td class="py-5 font-black text-secondary text-sm">#{{ $order->order_number }}</td>
                                <td class="py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-secondary">{{ $order->customer_name }}</span>
                                        <span class="text-[10px] text-gray-400">{{ $order->customer_email }}</span>
                                    </div>
                                </td>
                                <td class="py-5">
                                    @php
                                        $statusClasses = match($order->order_status) {
                                            'delivered' => 'bg-green-50 text-green-600',
                                            'pending' => 'bg-yellow-50 text-yellow-600',
                                            'processing' => 'bg-blue-50 text-blue-600',
                                            default => 'bg-gray-50 text-gray-500'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $statusClasses }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td class="py-5 font-black text-secondary text-sm">৳{{ number_format($order->total_amount) }}</td>
                                <td class="py-5 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:bg-primary hover:text-white flex items-center justify-center transition ml-auto shadow-sm">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Sidebar Widgets (4 Columns) -->
        <div class="lg:col-span-4 space-y-8">
            
            <!-- Activity Log -->
            <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-50 h-[450px] flex flex-col">
                <h3 class="text-lg font-black text-secondary mb-6 flex items-center gap-2">
                    <i class="fas fa-bolt text-yellow-400"></i> Activity Log
                </h3>
                <div class="flex-1 overflow-y-auto pr-2 space-y-6 custom-scrollbar">
                    @forelse($recentActivities as $log)
                        <div class="flex gap-4 group cursor-pointer">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex-shrink-0 flex items-center justify-center text-sm shadow-sm group-hover:scale-110 transition">
                                <i class="fas {{ str_contains($log->action, 'Order') ? 'fa-shopping-cart text-blue-500' : (str_contains($log->action, 'Product') ? 'fa-cube text-purple-500' : 'fa-circle text-gray-400') }}"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="text-xs font-black text-secondary group-hover:text-primary transition">{{ $log->action }}</h4>
                                    <span class="text-[10px] text-gray-400 font-bold">{{ $log->created_at->format('H:i') }}</span>
                                </div>
                                <p class="text-[10px] text-gray-400 font-medium line-clamp-1">{{ $log->description }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-center text-gray-400">No recent activity</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Reviews -->
            <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-50 max-h-[450px] flex flex-col">
                <h3 class="text-lg font-black text-secondary mb-6 flex items-center gap-2">
                    <i class="fas fa-star text-yellow-400"></i> Product Intel
                </h3>
                <div class="flex-1 overflow-y-auto pr-2 space-y-6 custom-scrollbar">
                    @forelse($recentReviews as $review)
                        <div class="flex gap-4 group">
                            <div class="w-10 h-10 rounded-xl bg-yellow-50 flex-shrink-0 flex items-center justify-center text-yellow-600 font-bold text-xs uppercase">
                                {{ $review->rating }}★
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="text-xs font-black text-secondary line-clamp-1">{{ $review->product->name }}</h4>
                                    <span class="text-[10px] text-gray-400 font-bold">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[10px] text-gray-400 italic">"{{ Str::limit($review->comment, 40) }}"</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-center text-gray-400">No recent reviews</p>
                    @endforelse
                </div>
            </div>

            <!-- System Features Panel -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-8 rounded-[32px] shadow-lg shadow-green-500/20 text-white relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-shield-alt text-2xl"></i>
                        <h3 class="text-lg font-black">Production Features</h3>
                    </div>
                    <p class="text-xs opacity-90 mb-4">Enhanced system protection active</p>
                    
                    <div class="space-y-3">
                        <!-- Validation -->
                        <div class="flex items-center gap-3 bg-white/10 p-3 rounded-xl">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold">Smart Validation</p>
                                <p class="text-[10px] opacity-75">Image size, price checks</p>
                            </div>
                            @if($systemStatus['validation'])
                                <span class="text-xs font-black px-2 py-1 bg-white/20 rounded text-white">ON</span>
                            @else
                                <span class="text-xs font-black px-2 py-1 bg-red-500/50 rounded text-white">OFF</span>
                            @endif
                        </div>

                        <!-- Transactions -->
                        <div class="flex items-center gap-3 bg-white/10 p-3 rounded-xl">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-database"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold">DB Transactions</p>
                                <p class="text-[10px] opacity-75">Auto rollback on error</p>
                            </div>
                            @if($systemStatus['transaction'])
                                <span class="text-xs font-black px-2 py-1 bg-white/20 rounded text-white">ON</span>
                            @else
                                <span class="text-xs font-black px-2 py-1 bg-red-500/50 rounded text-white">OFF</span>
                            @endif
                        </div>

                        <!-- File Cleanup -->
                        <div class="flex items-center gap-3 bg-white/10 p-3 rounded-xl">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-broom"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold">File Cleanup</p>
                                <p class="text-[10px] opacity-75">Auto-delete unused files</p>
                            </div>
                            @if($systemStatus['file_cleanup'])
                                <span class="text-xs font-black px-2 py-1 bg-white/20 rounded text-white">ON</span>
                            @else
                                <span class="text-xs font-black px-2 py-1 bg-red-500/50 rounded text-white">OFF</span>
                            @endif
                        </div>

                        <!-- Performance -->
                        <div class="flex items-center gap-3 bg-white/10 p-3 rounded-xl">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold">Performance</p>
                                <p class="text-[10px] opacity-75">10x faster queries</p>
                            </div>
                            @if($systemStatus['performance'])
                                <span class="text-xs font-black px-2 py-1 bg-white/20 rounded text-white">ON</span>
                            @else
                                <span class="text-xs font-black px-2 py-1 bg-red-500/50 rounded text-white">OFF</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-white/20">
                        <div class="flex items-center justify-between text-xs">
                            <span class="opacity-75">System Status</span>
                            @if(in_array(false, $systemStatus))
                                <span class="font-black flex items-center gap-1 text-yellow-300">
                                    <span class="w-2 h-2 bg-yellow-300 rounded-full animate-pulse"></span>
                                    Partial Optimized
                                </span>
                            @else
                                <span class="font-black flex items-center gap-1">
                                    <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></span>
                                    Production Ready
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-primary p-8 rounded-[32px] shadow-lg shadow-primary/20 text-white relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <h3 class="text-lg font-black mb-4 relative z-10">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-3 relative z-10 text-center">
                    <a href="{{ route('admin.products.create') }}" class="bg-white/10 hover:bg-white/20 p-3 rounded-2xl flex flex-col items-center gap-2 transition group">
                        <i class="fas fa-plus-circle text-xl group-hover:scale-110 transition"></i>
                        <span class="text-[10px] font-bold">Add Product</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="bg-white/10 hover:bg-white/20 p-3 rounded-2xl flex flex-col items-center gap-2 transition group">
                        <i class="fas fa-cog text-xl group-hover:scale-110 transition"></i>
                        <span class="text-[10px] font-bold">Settings</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
          series: [{ name: 'Revenue', data: [31, 40, 28, 51, 42, 109, 100] }],
          chart: { height: 350, type: 'area', toolbar: { show: false }, zoom: { enabled: false } },
          dataLabels: { enabled: false },
          stroke: { curve: 'smooth', width: 4 },
          colors: ['#4318FF'],
          grid: { borderColor: '#F4F7FE' },
          fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0, stops: [0, 90, 100] } },
          xaxis: { 
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            axisBorder: { show: false }, axisTicks: { show: false },
            labels: { style: { colors: '#A3AED0', fontWeight: '700' } }
          },
          yaxis: { labels: { style: { colors: '#A3AED0', fontWeight: '700' }, formatter: (v) => '৳' + v } }
        };
        var chart = new ApexCharts(document.querySelector("#main-revenue-chart"), options);
        chart.render();
    });
</script>
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #E0E5F2; border-radius: 10px; }
    .animate-fade-in { animation: fadeIn 0.5s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush
