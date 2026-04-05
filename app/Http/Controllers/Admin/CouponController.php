<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric',
            'min_purchase_amount' => 'nullable|numeric',
            'usage_limit' => 'nullable|integer',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date',
        ]);

        Coupon::create($request->all());

        return back()->with('success', 'Coupon created successfully!');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        
        $request->validate([
            'code' => 'required|string|unique:coupons,code,'.$id,
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric',
        ]);

        $coupon->update($request->all());

        return redirect()->route('admin.coupons')->with('success', 'Coupon updated!');
    }

    public function destroy($id)
    {
        Coupon::findOrFail($id)->delete();
        return back()->with('success', 'Coupon deleted!');
    }
}
