<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with(['product.images'])
            ->latest()
            ->paginate(12);

        return view('pages.wishlist', compact('wishlistItems'));
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add to wishlist'
            ]);
        }

        $product_id = $request->product_id;
        $user_id = Auth::id();

        // Check if already in wishlist
        $existing = Wishlist::where('user_id', $user_id)->where('product_id', $product_id)->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Product removed from wishlist',
                'count' => Wishlist::where('user_id', $user_id)->count()
            ]);
        } else {
            Wishlist::create([
                'user_id' => $user_id,
                'product_id' => $product_id
            ]);

            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Product added to wishlist',
                'count' => Wishlist::where('user_id', $user_id)->count()
            ]);
        }
    }

    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        Wishlist::where('user_id', Auth::id())->where('product_id', $request->product_id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
            'count' => Wishlist::where('user_id', Auth::id())->count()
        ]);
    }

    public function details()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => true,
                'items' => [],
                'count' => 0
            ]);
        }

        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with(['product.images'])
            ->latest()
            ->get();

        $items = $wishlistItems->map(function ($item) {
            $product = $item->product;
            $price = getProductPrice($product->regular_price, $product->sale_price);
            return [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $price,
                'image_url' => getProductImage($product->images->first()?->image_path ?? $product->featured_image),
                'formatted_price' => formatPrice($price),
                'stock_status' => $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock'
            ];
        });

        return response()->json([
            'success' => true,
            'items' => $items,
            'count' => $wishlistItems->count()
        ]);
    }

    public function clear()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        Wishlist::where('user_id', Auth::id())->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Wishlist cleared successfully',
                'count' => 0
            ]);
        }

        return redirect()->route('wishlist')->with('success', 'Wishlist cleared successfully');
    }
}