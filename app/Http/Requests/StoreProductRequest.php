<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by AdminMiddleware
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Basic Information
            'name' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:products,slug',
            'sku' => 'required|string|max:50|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            
            // Descriptions
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            
            // Pricing
            'regular_price' => 'required|numeric|min:0|max:999999.99',
            'sale_price' => 'nullable|numeric|min:0|max:999999.99|lt:regular_price',
            
            // Stock Management
            'stock_quantity' => 'required|integer|min:0',
            'stock_status' => 'nullable|in:in_stock,out_of_stock,backorder',
            'low_stock_threshold' => 'nullable|integer|min:0',
            
            // Dimensions & Weight
            'weight' => 'nullable|numeric|min:0|max:99999.99',
            'length' => 'nullable|numeric|min:0|max:99999.99',
            'width' => 'nullable|numeric|min:0|max:99999.99',
            'height' => 'nullable|numeric|min:0|max:99999.99',
            
            // Flags
            'is_featured' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'is_best_seller' => 'nullable|boolean',
            'status' => 'nullable|in:active,inactive',
            
            // SEO
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            
            // Gallery Images
            'gallery' => 'nullable|array',
            'gallery.*.image' => 'required_with:gallery|image|mimes:jpeg,jpg,png,webp|max:2048', // 2MB max
            'gallery.*.color' => 'nullable|string|max:50',
            
            // Attributes (for variable products)
            'sizes' => 'nullable|string|max:500',
            'colors' => 'nullable|string|max:500',
            
            // Product Type
            'product_type' => 'nullable|in:single,variable',
        ];
    }

    /**
     * Get custom attribute names for error messages.
     */
    public function attributes(): array
    {
        return [
            'name' => 'product name',
            'sku' => 'SKU code',
            'category_id' => 'category',
            'brand_id' => 'brand',
            'regular_price' => 'regular price',
            'sale_price' => 'sale price',
            'stock_quantity' => 'stock quantity',
            'gallery.*.image' => 'product image',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'sale_price.lt' => 'The sale price must be less than the regular price.',
            'gallery.*.image.max' => 'Each product image must not exceed 2MB.',
            'gallery.*.image.mimes' => 'Product images must be in JPEG, PNG, or WebP format.',
            'stock_quantity.min' => 'Stock quantity cannot be negative.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Auto-generate slug if not provided
        if (!$this->filled('slug') && $this->filled('name')) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->name),
            ]);
        }

        // Convert checkboxes to boolean
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_new' => $this->boolean('is_new'),
            'is_best_seller' => $this->boolean('is_best_seller'),
        ]);
    }
}
