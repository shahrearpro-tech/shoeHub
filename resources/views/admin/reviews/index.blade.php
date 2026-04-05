@extends('layouts.admin')

@section('title', 'Manage Reviews')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="glass-card rounded-[32px] p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8 border border-white/20">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 text-white rounded-[24px] flex items-center justify-center text-3xl shadow-xl shadow-yellow-500/20">
                <i class="fas fa-star"></i>
            </div>
            <div>
                <h1 class="text-secondary text-3xl font-black tracking-tight">Product Intel</h1>
                <p class="text-gray-400 text-xs font-black uppercase tracking-widest mt-1">Manage ({{ $reviews->total() }}) Customer Reviews</p>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-50">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-400 text-[10px] font-black uppercase tracking-widest border-b border-gray-50">
                        <th class="pb-4">Product</th>
                        <th class="pb-4">Customer</th>
                        <th class="pb-4">Rating</th>
                        <th class="pb-4">Review</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50/50">
                    @foreach($reviews as $review)
                    <tr class="group hover:bg-gray-50/50 transition">
                        <td class="py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-secondary">{{ $review->product->name }}</span>
                                <span class="text-[10px] text-gray-400">SKU: {{ $review->product->sku }}</span>
                            </div>
                        </td>
                        <td class="py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-secondary">{{ $review->user->name }}</span>
                                <span class="text-[10px] text-gray-400">{{ $review->user->email }}</span>
                            </div>
                        </td>
                        <td class="py-5">
                            <div class="flex items-center gap-1 text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-[10px] {{ $i <= $review->rating ? '' : 'opacity-20' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td class="py-5">
                            <p class="text-xs text-gray-500 line-clamp-2 max-w-xs">{{ $review->review_text }}</p>
                        </td>
                        <td class="py-5">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase 
                                {{ $review->status === 'approved' ? 'bg-green-50 text-green-600' : ($review->status === 'pending' ? 'bg-yellow-50 text-yellow-600' : 'bg-red-50 text-red-600') }}">
                                {{ $review->status }}
                            </span>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <form action="{{ route('admin.reviews.status', $review->id) }}" method="POST" class="flex gap-1">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 flex items-center justify-center transition" title="Approve">
                                        <i class="fas fa-check text-[10px]"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.status', $review->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition" title="Reject">
                                        <i class="fas fa-times text-[10px]"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:bg-red-500 hover:text-white flex items-center justify-center transition">
                                        <i class="fas fa-trash text-[10px]"></i>
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
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection
