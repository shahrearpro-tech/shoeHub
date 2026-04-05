<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->orderBy('display_order')->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);

        $data = [
            'name' => $request->name,
            'slug' => generateSlug($request->name),
            'description' => $request->description,
            'status' => $request->status ?? 'active',
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }

        Brand::create($data);

        return redirect()->route('admin.brands')->with('success', 'Brand created!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $data = [
            'name' => $request->name,
            'slug' => generateSlug($request->name),
            'description' => $request->description,
            'status' => $request->status ?? 'active',
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $brand->update($data);

        return redirect()->route('admin.brands')->with('success', 'Brand updated!');
    }

    public function destroy($id)
    {
        Brand::findOrFail($id)->delete();
        return redirect()->route('admin.brands')->with('success', 'Brand deleted!');
    }
}