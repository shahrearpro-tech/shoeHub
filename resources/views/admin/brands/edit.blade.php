@extends('layouts.admin')

@section('title', 'Edit Brand')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-[40px] shadow-2xl border border-white/20 p-10 animate-scale-in">
        <div class="mb-8">
            <h2 class="text-3xl font-black text-secondary tracking-tight">Edit Brand</h2>
        </div>
        
        <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $brand->name) }}" required class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-purple-500/20 outline-none transition">
            </div>
            
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Status</label>
                <select name="status" class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none text-secondary font-bold focus:ring-2 focus:ring-purple-500/20 outline-none appearance-none cursor-pointer">
                    <option value="active" {{ $brand->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $brand->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Description</label>
                <textarea name="description" rows="4" class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-none text-secondary font-medium focus:ring-2 focus:ring-purple-500/20 outline-none transition">{{ old('description', $brand->description) }}</textarea>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.brands') }}" class="px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-200 transition">
                    Cancel
                </a>
                <button type="submit" class="px-10 py-4 bg-secondary text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-secondary/20 hover:bg-primary transition-all transform hover:-translate-y-1">
                    Update Brand
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
