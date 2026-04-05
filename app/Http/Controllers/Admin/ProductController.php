<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index(Request $request)
    {
        $query = Product::with(['images', 'category', 'brand']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(20);
        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $brands = Brand::active()->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $product = $this->productService->createProduct($request->validated());

            return redirect()
                ->route('admin.products')
                ->with('success', 'Product created successfully! ID: ' . $product->id);
        } catch (\Exception $e) {
            \Log::error('Product creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'attributes'])->findOrFail($id);
        $categories = Category::active()->get();
        $brands = Brand::active()->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product = $this->productService->updateProduct($product, $request->validated());

            return redirect()
                ->route('admin.products')
                ->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Product update failed: ' . $e->getMessage(), [
                'product_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update product. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $this->productService->deleteProduct($product);

            return redirect()
                ->route('admin.products')
                ->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Product deletion failed: ' . $e->getMessage(), [
                'product_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'Failed to delete product. Please try again.');
        }
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $image->delete();
        return response()->json(['success' => true]);
    }
}