<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{


    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart');

        $cartItems = getCartItemsFull();
        $addresses = Address::where('user_id', auth()->id())->get();
        $subtotal = getCartTotal();

        return view('pages.checkout', compact('cartItems', 'addresses', 'subtotal'));
    }

    public function processOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:100',
            'customer_phone' => 'required|string|max:20',
            'shipping_address_line1' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'nullable|string|max:100', // Made nullable
            'shipping_postal_code' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,bkash,nagad,card,bank_transfer',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart');

        $subtotal = getCartTotal();
        $deliveryCharge = 60;

        DB::beginTransaction();
        try {
            $userId = auth()->id();
            $newAccountCreated = false;

            // Automatic Account Creation Logic
            if (!$userId) {
                $user = \App\Models\User::where('email', $request->customer_email)->first();
                
                if (!$user) {
                    $user = \App\Models\User::create([
                        'name' => $request->customer_name,
                        'email' => $request->customer_email,
                        'phone' => $request->customer_phone,
                        'password' => $request->customer_phone, // Password is phone
                        'role' => 'customer',
                        'status' => 'active',
                    ]);
                    $newAccountCreated = true;
                }
                
                auth()->login($user);
                $userId = $user->id;
            }

            $order = Order::create([
                'order_number' => generateOrderNumber(),
                'user_id' => $userId,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address_line1' => $request->shipping_address_line1,
                'shipping_address_line2' => $request->shipping_address_line2,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_postal_code' => $request->shipping_postal_code,
                'delivery_option' => $request->delivery_option ?? 'standard',
                'delivery_charge' => $deliveryCharge,
                'subtotal' => $subtotal,
                'total_amount' => $subtotal + $deliveryCharge,
                'payment_method' => $request->payment_method,
                'order_notes' => $request->order_notes,
            ]);

            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'size' => $item['attributes']['size'] ?? null,
                        'color' => $item['attributes']['color'] ?? null,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['price'],
                        'total_price' => $item['price'] * $item['quantity'],
                    ]);

                    $product->decrement('stock_quantity', $item['quantity']);
                }
            }

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'notes' => 'Order placed',
                'created_by' => $userId,
            ]);

            DB::commit();
            session()->forget('cart');

            // Flash info about new account
            if ($newAccountCreated) {
                session()->flash('new_account', true);
                session()->flash('temp_password', $request->customer_phone);
            }

            return redirect()->route('order.confirmation', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }

    public function confirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items.product')
            ->firstOrFail();

        if ($order->user_id && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.order-confirmation', compact('order'));
    }
}