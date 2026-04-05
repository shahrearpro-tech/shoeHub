@extends('layouts.admin')

@section('title', 'Brands')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- List -->
    <div class="lg:col-span-2 bg-white rounded-[40px] shadow-2xl border border-white/20 overflow-hidden animate-slide-in-left">
        <div class="px-10 py-8 border-b border-gray-50 bg-white flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black text-secondary tracking-tight">Brands</h2>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Manage your partners</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Name</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Products</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($brands as $brand)
                    <tr class="group hover:bg-gray-50/30 transition-colors">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-black text-sm">
                                    {{ substr($brand->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-secondary text-sm">{{ $brand->name }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-6 font-medium text-sm text-gray-500">
                             <span class="px-3 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-600">{{ $brand->products_count }}</span>
                        </td>
                        <td class="px-10 py-6">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $brand->status === 'active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                {{ $brand->status }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" onsubmit="return confirm('Delete this brand?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-10 py-12 text-center text-gray-400 font-medium">No brands found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-[40px] shadow-2xl border border-white/20 p-10 sticky top-8 animate-slide-in-right">
            <h3 class="text-xl font-black text-secondary tracking-tight mb-2">Add Brand</h3>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-8">Register new brand</p>
            
            <form action="{{ route('admin.brands.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Name</label>
                    <input type="text" name="name" required class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-purple-500/20 outline-none transition" placeholder="e.g. Nike">
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Description</label>
                    <textarea name="description" rows="3" class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-none text-secondary font-medium focus:ring-2 focus:ring-purple-500/20 outline-none transition" placeholder="Optional description..."></textarea>
                </div>

                <button type="submit" class="w-full py-4 bg-secondary text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-secondary/20 hover:bg-primary transition-all transform hover:-translate-y-1">
                    Create Brand
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
