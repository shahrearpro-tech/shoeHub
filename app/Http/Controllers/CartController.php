<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = getCartItemsFull();
        $subtotal = getCartTotal();

        return view('pages.cart', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session('cart', []);

        $attributes = [
            'size' => $request->size ?? '',
            'color' => $request->color ?? '',
        ];

        $key = $product->id . '_' . md5(json_encode($attributes));
        $price = getProductPrice($product->regular_price, $product->sale_price);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->get('quantity', 1);
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug, // Added slug
                'price' => $price,
                'quantity' => $request->get('quantity', 1),
                'attributes' => $attributes,
            ];
        }

        session(['cart' => $cart]);

        if ($request->has('redirect_checkout') && $request->redirect_checkout == 1) {
            return redirect()->route('checkout');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => getCartItemsCount(),
                'cart_total' => getCartTotal(),
            ]);
        }

        return back()->with('success', 'Product added to cart');
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        $key = $request->input('cart_key', $request->input('key'));

        if (isset($cart[$key])) {
            if ($request->has('action')) {
                if ($request->action == 'increase') {
                    $cart[$key]['quantity']++;
                } elseif ($request->action == 'decrease' && $cart[$key]['quantity'] > 1) {
                    $cart[$key]['quantity']--;
                }
            } elseif ($request->has('quantity')) {
                $cart[$key]['quantity'] = max(1, (int)$request->quantity);
            }
            
            session(['cart' => $cart]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => getCartItemsCount(), // snake_case
                'cart_total' => getCartTotal(), // snake_case
                'formatted_total' => formatPrice(getCartTotal()), // Added for JS
            ]);
        }

        return back();
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        $key = $request->input('cart_key', $request->input('key'));

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session(['cart' => $cart]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => getCartItemsCount(), // snake_case
                'cart_total' => getCartTotal(), // snake_case
                'formatted_total' => formatPrice(getCartTotal()), // Added for JS
            ]);
        }

        return back()->with('success', 'Item removed from cart');
    }

    public function count()
    {
        return response()->json(['count' => getCartItemsCount()]);
    }

    public function details()
    {
        $cartItems = getCartItemsFull();
        $items = [];

        foreach ($cartItems as $key => $item) {
            $items[] = array_merge($item, [
                'key' => $key,
                'image_url' => getProductImage($item['image']),
                'formatted_price' => formatPrice($item['price']),
                'formatted_total' => formatPrice($item['total']),
            ]);
        }

        return response()->json([
            'success' => true,
            'items' => $items,
            'count' => getCartItemsCount(),
            'total' => getCartTotal(),
            'formatted_total' => formatPrice(getCartTotal()),
        ]);
    }
}