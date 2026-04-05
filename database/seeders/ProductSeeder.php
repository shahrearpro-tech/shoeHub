<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $brands = Brand::all();

        if ($categories->isEmpty() || $brands->isEmpty()) {
            return;
        }

        $products = [
            [
                'name' => 'Nike Air Max 270',
                'description' => 'The Nike Air Max 270 delivers visible air under every step. Updated for modern comfort, it nods to the original 1991 Air Max 180 with its exaggerated tongue top and heritage tongue logo.',
                'short_description' => 'Big Air. All Day Comfort.',
                'regular_price' => 15000,
                'sale_price' => 12500,
                'sku' => 'NIKE-AM270-01',
                'stock_status' => 'in_stock',
                'stock_quantity' => 50,
                'is_featured' => true,
                'is_new' => true,
                'is_best_seller' => true,
                'status' => 'active',
                'category_id' => $categories->where('slug', 'sports-shoes')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->where('slug', 'nike')->first()->id ?? $brands->first()->id,
                'images' => [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
                ]
            ],
            [
                'name' => 'Adidas Ultraboost 22',
                'description' => 'Experience energy return like never before. The Ultraboost 22 features a Linear Energy Push system and Continental Rubber outsole for superior traction.',
                'short_description' => 'Ultimate energy return.',
                'regular_price' => 18000,
                'sale_price' => 16000,
                'sku' => 'ADI-UB22-02',
                'stock_status' => 'in_stock',
                'stock_quantity' => 45,
                'is_featured' => true,
                'is_new' => true,
                'is_best_seller' => false,
                'status' => 'active',
                'category_id' => $categories->where('slug', 'sports-shoes')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->where('slug', 'adidas')->first()->id ?? $brands->first()->id,
                'images' => [
                    'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
                ]
            ],
            [
                'name' => 'Classic Leather Loafers',
                'description' => 'Handcrafted from premium leather, these loafers offer timeless style and unmatched comfort. Perfect for formal occasions or office wear.',
                'short_description' => 'Timeless elegance.',
                'regular_price' => 5500,
                'sale_price' => null,
                'sku' => 'SH-LOAF-03',
                'stock_status' => 'in_stock',
                'stock_quantity' => 30,
                'is_featured' => false,
                'is_new' => false,
                'is_best_seller' => true,
                'status' => 'active',
                'category_id' => $categories->where('slug', 'formal-shoes')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->where('slug', 'bata')->first()->id ?? $brands->first()->id,
                'images' => [
                    'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
                ]
            ],
            [
                'name' => 'Urban High-Tops',
                'description' => 'Step up your street style with these urban high-tops. Featuring a durable canvas upper and a grippy rubber sole.',
                'short_description' => 'Street ready style.',
                'regular_price' => 5000,
                'sale_price' => 4200,
                'sku' => 'SH-HIGH-04',
                'stock_status' => 'in_stock',
                'stock_quantity' => 60,
                'is_featured' => true,
                'is_new' => false,
                'is_best_seller' => false,
                'status' => 'active',
                'category_id' => $categories->where('slug', 'casual-shoes')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->first()->id,
                'images' => [
                    'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
                ]
            ],
            [
                'name' => 'Running Trainers Pink',
                'description' => 'Lightweight and breathable, these trainers are perfect for your daily jog. The foam midsole provides excellent cushioning.',
                'short_description' => 'Lightweight comfort.',
                'regular_price' => 3500,
                'sale_price' => null,
                'sku' => 'PUMA-RUN-05',
                'stock_status' => 'in_stock',
                'stock_quantity' => 40,
                'is_featured' => true,
                'is_new' => true,
                'is_best_seller' => true,
                'status' => 'active',
                'category_id' => $categories->where('slug', 'womens-shoes')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->where('slug', 'puma')->first()->id ?? $brands->first()->id,
                'images' => [
                    'https://images.unsplash.com/photo-1562183241-b937e95585b6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'
                ]
            ]
        ];

        foreach ($products as $pData) {
            $images = $pData['images'];
            unset($pData['images']);
            
            $pData['slug'] = Str::slug($pData['name']);
            $product = Product::create($pData);

            foreach ($images as $index => $imageUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imageUrl,
                    'is_featured' => $index === 0,
                    'display_order' => $index
                ]);
            }

            // Simple attributes
            $product->attributes()->createMany([
                ['attribute_name' => 'size', 'attribute_value' => '40'],
                ['attribute_name' => 'size', 'attribute_value' => '41'],
                ['attribute_name' => 'size', 'attribute_value' => '42'],
                ['attribute_name' => 'color', 'attribute_value' => 'Black'],
                ['attribute_name' => 'color', 'attribute_value' => 'Blue'],
            ]);
        }
    }
}
