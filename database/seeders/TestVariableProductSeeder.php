<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestVariableProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'sports-shoes')->first() ?? Category::first();
        $brand = Brand::where('slug', 'nike')->first() ?? Brand::first();

        $productData = [
            'name' => 'Premium Sport Pro Max',
            'slug' => 'premium-sport-pro-max-' . time(),
            'sku' => 'TEST-VAR-001',
            'short_description' => 'The ultimate testing shoe with full variation support.',
            'description' => "This product is designed specifically to test the variable product features of ShoeHub.\n\nIt includes multiple sizes and colors to verify that:\n1. Variation selection works correctly.\n2. Stock management (per product) works.\n3. Image switching based on color selection is functional.",
            'regular_price' => 25000,
            'sale_price' => 19500,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'stock_quantity' => 100,
            'stock_status' => 'in_stock',
            'status' => 'active',
            'is_featured' => true,
        ];

        $product = Product::create($productData);

        // Add Attributes (Sizes)
        foreach (['40', '41', '42', '43', '44', '45'] as $size) {
            ProductAttribute::create([
                'product_id' => $product->id,
                'attribute_name' => 'size',
                'attribute_value' => $size,
            ]);
        }

        // Add Attributes (Colors) and Images
        $variations = [
            [
                'color' => 'Red',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1000&q=80',
                'is_featured' => true
            ],
            [
                'color' => 'Green',
                'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?auto=format&fit=crop&w=1000&q=80',
                'is_featured' => false
            ],
            [
                'color' => 'Blue',
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=1000&q=80',
                'is_featured' => false
            ],
            [
                'color' => 'Black',
                'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=1000&q=80',
                'is_featured' => false
            ],
        ];

        foreach ($variations as $index => $var) {
            // Add color attribute
            ProductAttribute::create([
                'product_id' => $product->id,
                'attribute_name' => 'color',
                'attribute_value' => $var['color'],
            ]);

            // Add image associated with color
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $var['image'],
                'is_featured' => $var['is_featured'],
                'display_order' => $index,
                'color' => $var['color'],
            ]);
        }
    }
}
