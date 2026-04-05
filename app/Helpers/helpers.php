<?php

use App\Models\Setting;

if (!function_exists('formatPrice')) {
    function formatPrice($price) {
        $symbol = Setting::getValue('currency_symbol', '৳');
        return $symbol . number_format($price, 0);
    }
}

if (!function_exists('calculateDiscount')) {
    function calculateDiscount($regular_price, $sale_price) {
        if ($regular_price <= 0 || $sale_price >= $regular_price) return 0;
        return round((($regular_price - $sale_price) / $regular_price) * 100);
    }
}

if (!function_exists('getProductPrice')) {
    function getProductPrice($regular_price, $sale_price = null) {
        return ($sale_price && $sale_price > 0 && $sale_price < $regular_price) ? $sale_price : $regular_price;
    }
}

if (!function_exists('getProductImage')) {
    function getProductImage($image) {
        if (empty($image)) return 'https://via.placeholder.com/300x300?text=No+Image';
        if (str_starts_with($image, 'http')) return $image;
        if (str_starts_with($image, 'assets/')) return asset($image);
        
        // Remove duplicate storage/ if it exists
        $path = ltrim($image, '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }
        
        // Check for common upload directories
        if (str_starts_with($path, 'products/')) {
            return asset('assets/uploads/' . $path);
        }
        
        // Default to storage disk
        return asset('storage/' . $path);
    }
}

if (!function_exists('getSliderImage')) {
    function getSliderImage($image) {
        if (empty($image)) return 'https://images.unsplash.com/photo-1556906781-9a412961c28c?auto=format&fit=crop&q=80&w=1920';
        if (str_starts_with($image, 'http')) return $image;
        if (str_starts_with($image, 'assets/')) return asset($image);
        
        $path = ltrim($image, '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }
        
        return asset('storage/' . $path);
    }
}

if (!function_exists('getCategoryThumb')) {
    function getCategoryThumb($image) {
        if (empty($image)) return 'https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=600&q=80';
        if (str_starts_with($image, 'http')) return $image;
        
        $path = ltrim($image, '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }
        
        return asset('storage/categories/' . $path);
    }
}

if (!function_exists('getSettingImage')) {
    function getSettingImage($image) {
        if (empty($image)) return null;
        if (str_starts_with($image, 'http')) return $image;

        $path = ltrim($image, '/');
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        return asset('storage/' . $path);
    }
}

if (!function_exists('generateOrderNumber')) {
    function generateOrderNumber() {
        return 'SH' . date('Ymd') . strtoupper(substr(uniqid(), -6));
    }
}

if (!function_exists('generateSlug')) {
    function generateSlug($string) {
        $slug = strtolower(trim($string));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }
}

if (!function_exists('displayStarRating')) {
    function displayStarRating($rating, $max = 5) {
        $html = '<div class="star-rating">';
        for ($i = 1; $i <= $max; $i++) {
            if ($i <= $rating) {
                $html .= '<i class="fas fa-star text-yellow-500"></i>';
            } elseif ($i - 0.5 <= $rating) {
                $html .= '<i class="fas fa-star-half-alt text-yellow-500"></i>';
            } else {
                $html .= '<i class="far fa-star text-gray-300"></i>';
            }
        }
        $html .= '</div>';
        return $html;
    }
}

if (!function_exists('getOrderStatusBadge')) {
    function getOrderStatusBadge($status) {
        $badges = [
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'processing' => '<span class="badge badge-info">Processing</span>',
            'on_hold' => '<span class="badge badge-secondary">On Hold</span>',
            'shipped' => '<span class="badge badge-primary">Shipped</span>',
            'out_for_delivery' => '<span class="badge badge-primary">Out for Delivery</span>',
            'delivered' => '<span class="badge badge-success">Delivered</span>',
            'cancelled' => '<span class="badge badge-danger">Cancelled</span>',
            'refunded' => '<span class="badge badge-dark">Refunded</span>',
        ];
        return $badges[$status] ?? $status;
    }
}

if (!function_exists('getCartItemsCount')) {
    function getCartItemsCount() {
        $cart = session('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
}

if (!function_exists('getCartTotal')) {
    function getCartTotal() {
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}

if (!function_exists('getCartItemsFull')) {
    function getCartItemsFull() {
        $cart = session('cart', []);
        $cartItems = [];

        foreach ($cart as $key => $item) {
            $product = \App\Models\Product::with('images')->find($item['product_id']);
            if ($product) {
                // Determine the best image path
                $imagePath = $product->images->first()?->image_path ?? $product->featured_image;
                
                $cartItems[$key] = array_merge($item, [
                    'product' => $product,
                    'image' => $imagePath,
                    'total' => $item['price'] * $item['quantity'],
                ]);
            }
        }
        return $cartItems;
    }
}