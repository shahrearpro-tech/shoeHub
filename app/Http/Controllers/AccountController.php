<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{


    public function index()
    {
        $user = auth()->user();
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        return view('pages.account', compact('user', 'recentOrders'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('pages.orders', compact('orders'));
    }

    public function orderDetails($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with(['items', 'statusHistory'])
            ->firstOrFail();

        return view('pages.order-details', compact('order'));
    }

    public function profile()
    {
        return view('pages.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20|unique:users,phone,'.$user->id,
        ]);

        $user->update($request->only('name', 'phone'));

        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->update(['password' => Hash::make($request->new_password)]);
        }

        return back()->with('success', 'Profile updated!');
    }

    public function addresses()
    {
        $addresses = Address::where('user_id', auth()->id())->get();
        return view('pages.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        Address::create(array_merge($request->all(), ['user_id' => auth()->id()]));
        return back()->with('success', 'Address added!');
    }

    public function invoice($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        return view('pages.invoice', compact('order'));
    }

    public function trackOrder()
    {
        return view('pages.track-order');
    }

    public function reorder($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->with('items.product')
            ->firstOrFail();

        $addedCount = 0;
        $outOfStockCount = 0;

        $cart = session()->get('cart', []);

        foreach ($order->items as $item) {
            $product = $item->product;

            if (!$product || !$product->status === 'active' || $product->stock_quantity <= 0) {
                $outOfStockCount++;
                continue;
            }

            $attributes = [
                'size' => $item->size,
                'color' => $item->color
            ];

            $qtyToAdd = $item->quantity;
            if ($qtyToAdd > $product->stock_quantity) {
                $qtyToAdd = $product->stock_quantity;
            }

            $key = $product->id . '_' . md5(json_encode($attributes));

            if (isset($cart[$key])) {
                if (($cart[$key]['quantity'] + $qtyToAdd) <= $product->stock_quantity) {
                    $cart[$key]['quantity'] += $qtyToAdd;
                    $addedCount++;
                } else {
                    $outOfStockCount++;
                }
            } else {
                $cart[$key] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => getProductPrice($product->regular_price, $product->sale_price),
                    'quantity' => $qtyToAdd,
                    'image' => $product->images->first()?->image_path ?? $product->featured_image,
                    'slug' => $product->slug,
                    'sku' => $product->sku,
                    'attributes' => $attributes
                ];
                $addedCount++;
            }
        }

        session()->put('cart', $cart);

        if ($addedCount > 0) {
            $msg = $addedCount . " items added to cart.";
            if ($outOfStockCount > 0) {
                $msg .= " Some items were out of stock.";
                return redirect()->route('cart')->with('warning', $msg);
            }
            return redirect()->route('cart')->with('success', 'Order items added to cart!');
        }

        return back()->with('error', 'Could not add items to cart (Out of stock).');
    }
}