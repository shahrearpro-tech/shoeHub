<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with(['images', 'category', 'brand', 'attributes']);

        // Category Filter
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Brand Filter
        if ($request->filled('brand_ids')) {
            $query->whereIn('brand_id', $request->brand_ids);
        }
        elseif ($request->filled('brand')) {
            $query->whereHas('brand', fn($q) => $q->where('slug', $request->brand));
        }

        // Price Filter (Using effective price)
        if ($request->filled('min_price')) {
            $query->where(function($q) use ($request) {
                $q->where(function($sq) use ($request) {
                    $sq->whereNull('sale_price')->where('regular_price', '>=', $request->min_price);
                })->orWhere(function($sq) use ($request) {
                    $sq->whereNotNull('sale_price')->where('sale_price', '>=', $request->min_price);
                });
            });
        }
        if ($request->filled('max_price')) {
            $query->where(function($q) use ($request) {
                $q->where(function($sq) use ($request) {
                    $sq->whereNull('sale_price')->where('regular_price', '<=', $request->max_price);
                })->orWhere(function($sq) use ($request) {
                    $sq->whereNotNull('sale_price')->where('sale_price', '<=', $request->max_price);
                });
            });
        }

        // Attribute Filters (Color, Size)
        if ($request->filled('color')) {
            $query->whereHas('attributes', fn($q) => $q->where('attribute_name', 'color')->where('attribute_value', $request->color));
        }
        if ($request->filled('size')) {
            $query->whereHas('attributes', fn($q) => $q->where('attribute_name', 'size')->where('attribute_value', $request->size));
        }

        // Search Filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low': 
                $query->orderByRaw('COALESCE(sale_price, regular_price) ASC'); 
                break;
            case 'price_high': 
                $query->orderByRaw('COALESCE(sale_price, regular_price) DESC'); 
                break;
            case 'popular': 
                $query->orderBy('views_count', 'desc'); 
                break;
            default: 
                $query->orderBy('created_at', 'desc');
        }

        $paginator = $query->paginate(12)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'products_html' => view('partials.product-grid', ['products' => $paginator])->render(),
                'pagination_html' => $paginator->links()->toHtml(),
                'showing_text' => 'Showing <span class="text-secondary font-bold">' . $paginator->total() . '</span> results',
            ]);
        }

        $products = $paginator;
        $categories = Category::active()->withCount('products')->orderBy('display_order')->get();
        $brands = Brand::active()->orderBy('display_order')->get();

        // Get unique attributes for sidebar
        $availableColors = \App\Models\ProductAttribute::where('attribute_name', 'color')
            ->select('attribute_value')
            ->distinct()
            ->orderBy('attribute_value')
            ->get();
        
        $availableSizes = \App\Models\ProductAttribute::where('attribute_name', 'size')
            ->select('attribute_value')
            ->distinct()
            ->orderByRaw('CAST(attribute_value AS UNSIGNED) ASC, attribute_value ASC')
            ->get();

        // Calculate actual price bounds for the slider
        $priceRange = Product::active()
            ->selectRaw('MIN(COALESCE(sale_price, regular_price)) as min_p, MAX(COALESCE(sale_price, regular_price)) as max_p')
            ->first();
        
        $dbMinPrice = (int) floor($priceRange->min_p ?? 0);
        $dbMaxPrice = (int) ceil($priceRange->max_p ?? 10000);

        // Safety buffer if all products have same price
        if ($dbMinPrice === $dbMaxPrice) {
            $dbMinPrice = max(0, $dbMinPrice - 100);
            $dbMaxPrice = $dbMaxPrice + 100;
        }

        return view('pages.shop', compact(
            'products', 'categories', 'brands', 'availableColors', 'availableSizes', 'dbMinPrice', 'dbMaxPrice'
        ));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['images', 'category', 'brand', 'attributes', 'reviews' => function($q) {
                $q->where('status', 'approved')->with('user')->latest();
            }])
            ->firstOrFail();
        $product->increment('views_count');

        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->with('images')
            ->take(4)->get();

        return view('pages.product-detail', compact('product', 'relatedProducts'));
    }
}