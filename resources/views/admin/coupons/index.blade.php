@extends('layouts.admin')

@section('title', 'Manage Coupons')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="glass-card rounded-[32px] p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8 border border-white/20">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-600 text-white rounded-[24px] flex items-center justify-center text-3xl shadow-xl shadow-purple-500/20">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div>
                <h1 class="text-secondary text-3xl font-black tracking-tight">Coupons & Promo</h1>
                <p class="text-gray-400 text-xs font-black uppercase tracking-widest mt-1">Manage ({{ $coupons->total() }}) active discount codes</p>
            </div>
        </div>
        <button onclick="document.getElementById('add-coupon-modal').classList.remove('hidden')" class="bg-primary hover:bg-brand-600 text-white text-[11px] font-black uppercase tracking-widest px-8 py-4 rounded-2xl transition shadow-xl shadow-primary/25 flex items-center gap-3 transform hover:-translate-y-1">
            <i class="fas fa-plus"></i> Create Coupon
        </button>
    </div>

    <!-- Coupons Table -->
    <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-50">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-400 text-[10px] font-black uppercase tracking-widest border-b border-gray-50">
                        <th class="pb-4">Code</th>
                        <th class="pb-4">Discount</th>
                        <th class="pb-4">Usage</th>
                        <th class="pb-4">Validity</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50/50">
                    @foreach($coupons as $coupon)
                    <tr class="group hover:bg-gray-50/50 transition">
                        <td class="py-5 font-black text-secondary text-sm">
                            <span class="px-3 py-1 bg-gray-100 rounded-lg border border-gray-200 uppercase tracking-tighter">{{ $coupon->code }}</span>
                        </td>
                        <td class="py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-secondary">
                                    {{ $coupon->discount_type === 'fixed' ? '৳' . number_format($coupon->discount_value) : $coupon->discount_value . '%' }}
                                </span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase">{{ $coupon->discount_type }}</span>
                            </div>
                        </td>
                        <td class="py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-secondary">{{ $coupon->usage_count ?? 0 }} / {{ $coupon->usage_limit ?? '∞' }}</span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase">Redemptions</span>
                            </div>
                        </td>
                        <td class="py-5">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-secondary uppercase">{{ $coupon->valid_from ? $coupon->valid_from->format('d M Y') : 'Anytime' }}</span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase">to {{ $coupon->valid_to ? $coupon->valid_to->format('d M Y') : '∞' }}</span>
                            </div>
                        </td>
                        <td class="py-5">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $coupon->status === 'active' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                {{ $coupon->status }}
                            </span>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:bg-primary/5 hover:text-primary transition border border-transparent hover:border-primary/10">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Archive this coupon asset?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 transition border border-transparent hover:border-red-100">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-8">
            {{ $coupons->links() }}
        </div>
    </div>
</div>

<!-- Add Coupon Modal -->
<div id="add-coupon-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-secondary/80 backdrop-blur-md">
    <div class="bg-white rounded-[40px] shadow-2xl w-full max-w-xl overflow-hidden transform animate-scale-in">
        <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="text-xl font-black text-secondary tracking-tight uppercase">Construct Promo Code</h3>
            <button onclick="document.getElementById('add-coupon-modal').classList.add('hidden')" class="text-gray-400 hover:text-red-500 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Protocol Code *</label>
                    <input type="text" name="code" required class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none text-secondary font-black transition" placeholder="SAVE50">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Logic Type *</label>
                    <select name="discount_type" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none text-secondary font-black transition uppercase text-xs">
                        <option value="fixed">Fixed Currency</option>
                        <option value="percentage">Percentage Offset</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Payload Value *</label>
                    <input type="number" name="discount_value" required class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none text-secondary font-black transition" placeholder="50.00">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Trigger Threshold (Min)</label>
                    <input type="number" name="min_purchase_amount" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 outline-none text-secondary font-black transition" placeholder="0.00">
                </div>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="button" onclick="document.getElementById('add-coupon-modal').classList.add('hidden')" class="flex-1 py-4 rounded-2xl font-black text-gray-400 text-[10px] uppercase tracking-widest hover:bg-gray-50 transition">Abort</button>
                <button type="submit" class="flex-[1.5] py-4 bg-secondary text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-xl hover:bg-black transition-all">Initialize Coupon</button>
            </div>
        </form>
    </div>
</div>
@endsection
