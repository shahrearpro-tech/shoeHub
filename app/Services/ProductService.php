<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * Create a new product with all related data.
     * Uses database transaction for data integrity.
     *
     * @param array $data Validated product data
     * @return Product
     * @throws \Exception
     */
    public function createProduct(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            // Create the main product
            $product = Product::create($this->prepareProductData($data));

            // Process gallery images
            if (!empty($data['gallery'])) {
                $this->processGallery($product, $data['gallery']);
            }

            // Sync product attributes (sizes, colors)
            $this->syncAttributes($product, $data);

            return $product->load(['images', 'attributes']);
        });
    }

    /**
     * Update an existing product with all related data.
     * Uses database transaction for data integrity.
     *
     * @param Product $product
     * @param array $data Validated product data
     * @return Product
     * @throws \Exception
     */
    public function updateProduct(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            // Update main product data
            $product->update($this->prepareProductData($data));

            // Update existing image colors
            if (!empty($data['image_colors'])) {
                $this->updateImageColors($data['image_colors']);
            }

            // Process new gallery images
            if (!empty($data['gallery'])) {
                $this->processGallery($product, $data['gallery']);
            }

            // Sync product attributes
            $this->syncAttributes($product, $data);

            return $product->load(['images', 'attributes']);
        });
    }

    /**
     * Delete a product and clean up associated files.
     *
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public function deleteProduct(Product $product): bool
    {
        return DB::transaction(function () use ($product) {
            // Delete all product images from storage
            foreach ($product->images as $image) {
                $this->deleteImageFile($image->image_path);
            }

            // Delete product (cascades to images and attributes via model events)
            return $product->delete();
        });
    }

    /**
     * Prepare product data for create/update.
     *
     * @param array $data
     * @return array
     */
    protected function prepareProductData(array $data): array
    {
        // Generate slug from name if not provided
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = \Str::slug($data['name']) . '-' . time();
        }

        // Remove non-product fields
        return collect($data)->except([
            'gallery',
            'image_colors',
            'sizes',
            'colors',
            'product_type',
        ])->toArray();
    }

    /**
     * Process and save gallery images.
     *
     * @param Product $product
     * @param array $gallery
     * @return void
     */
    protected function processGallery(Product $product, array $gallery): void
    {
        $currentCount = $product->images()->count();

        foreach ($gallery as $index => $item) {
            if (isset($item['image'])) {
                try {
                    $path = $item['image']->store('products', 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'storage/' . $path,
                        'is_featured' => ($currentCount === 0 && $index === 0),
                        'display_order' => $currentCount + $index,
                        'color' => $item['color'] ?? null,
                    ]);
                } catch (\Exception $e) {
                    // Clean up on failure
                    if (isset($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    throw $e;
                }
            }
        }
    }

    /**
     * Update colors for existing images.
     *
     * @param array $imageColors [image_id => color]
     * @return void
     */
    protected function updateImageColors(array $imageColors): void
    {
        foreach ($imageColors as $imageId => $color) {
            ProductImage::where('id', $imageId)->update([
                'color' => $color
            ]);
        }
    }

    /**
     * Sync product attributes (sizes, colors).
     *
     * @param Product $product
     * @param array $data
     * @return void
     */
    protected function syncAttributes(Product $product, array $data): void
    {
        // Handle sizes
        if (array_key_exists('sizes', $data)) {
            $product->attributes()->where('attribute_name', 'size')->delete();
            
            if (!empty($data['sizes'])) {
                $sizes = array_map('trim', explode(',', $data['sizes']));
                foreach ($sizes as $size) {
                    if (!empty($size)) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'attribute_name' => 'size',
                            'attribute_value' => $size,
                        ]);
                    }
                }
            }
        }

        // Handle colors - merge from manual input and gallery
        if (array_key_exists('colors', $data) || !empty($data['gallery'])) {
            $manualColors = !empty($data['colors']) 
                ? array_map('trim', explode(',', $data['colors'])) 
                : [];

            $galleryColors = [];
            if (!empty($data['gallery'])) {
                foreach ($data['gallery'] as $item) {
                    if (!empty($item['color'])) {
                        $galleryColors[] = trim($item['color']);
                    }
                }
            }

            $allColors = array_unique(array_merge($manualColors, $galleryColors));

            // Delete existing and re-create
            $product->attributes()->where('attribute_name', 'color')->delete();
            
            foreach ($allColors as $color) {
                if (!empty($color)) {
                    ProductAttribute::create([
                        'product_id' => $product->id,
                        'attribute_name' => 'color',
                        'attribute_value' => $color,
                    ]);
                }
            }
        }
    }

    /**
     * Delete an image file from storage.
     *
     * @param string $path
     * @return void
     */
    protected function deleteImageFile(string $path): void
    {
        // Extract actual path from 'storage/products/...' format
        if (str_starts_with($path, 'storage/')) {
            $actualPath = str_replace('storage/', '', $path);
            Storage::disk('public')->delete($actualPath);
        } elseif (str_starts_with($path, 'http')) {
            // External URL, don't delete
            return;
        }
    }
}
