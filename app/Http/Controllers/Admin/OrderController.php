<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%'.$request->search.'%')
                  ->orWhere('customer_name', 'like', '%'.$request->search.'%')
                  ->orWhere('customer_email', 'like', '%'.$request->search.'%');
            });
        }

        $orders = $query->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product.images', 'statusHistory.createdBy', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->status]);

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => $request->status,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Order status updated!');
    }
}