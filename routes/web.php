<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\SocialPostController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\BlogController;

// ===================== Frontend Routes =====================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);



Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/ajax/get-cart-count', [CartController::class, 'count'])->name('cart.count');
Route::get('/ajax/get-cart-details', [CartController::class, 'details'])->name('cart.details');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'processOrder'])->name('order.store');
Route::get('/order-confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Chat
Route::get('/chat/fetch', [ChatController::class, 'fetch'])->name('chat.fetch');
Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');

// Account (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/orders', [AccountController::class, 'orders']);
    Route::get('/order-details/{orderNumber}', [AccountController::class, 'orderDetails'])->name('order.details');
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::get('/profile', [AccountController::class, 'profile']);
    Route::post('/profile/update', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::get('/account/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Route::get('/addresses', [AccountController::class, 'addresses']);
    Route::post('/addresses', [AccountController::class, 'storeAddress'])->name('address.store');
    Route::get('/track-order', [AccountController::class, 'trackOrder'])->name('track.order');
    Route::get('/order/reorder/{orderId}', [AccountController::class, 'reorder'])->name('order.reorder');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::get('/wishlist/details', [WishlistController::class, 'details'])->name('wishlist.details');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');

    // Reviews
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
});

// Invoices (Publicly accessible via link)
Route::get('/invoice/{orderNumber}', [AccountController::class, 'invoice'])->name('invoice');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/shipping-policy', [PageController::class, 'shippingPolicy'])->name('shipping.policy');
Route::get('/returns', [PageController::class, 'returns'])->name('returns');
Route::get('/size-guide', [PageController::class, 'sizeGuide'])->name('size.guide');
Route::get('/happy-customers', [PageController::class, 'happyCustomers'])->name('happy.customers');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');


// ===================== Admin Routes =====================

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Auth (no middleware)
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.process');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::get('/', fn() => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::get('/products', [AdminProductController::class, 'index'])->name('products');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        Route::delete('/product-image/{id}', [AdminProductController::class, 'deleteImage'])->name('products.deleteImage');

        // Categories
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('/edit-category/{id}', [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        // Brands
        Route::get('/brands', [AdminBrandController::class, 'index'])->name('brands');
        Route::post('/brands', [AdminBrandController::class, 'store'])->name('brands.store');
        Route::get('/edit-brand/{id}', [AdminBrandController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{id}', [AdminBrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{id}', [AdminBrandController::class, 'destroy'])->name('brands.destroy');

        // Orders
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
        Route::get('/order-details/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

        // Customers
        Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers');

        // Sliders
        Route::get('/sliders', [AdminSliderController::class, 'index'])->name('sliders');
        Route::post('/sliders', [AdminSliderController::class, 'store'])->name('sliders.store');
        Route::delete('/sliders/{id}', [AdminSliderController::class, 'destroy'])->name('sliders.destroy');

        // Settings
        Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
        Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');

        // Profile
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        // Coupons
        Route::get('/coupons', [AdminCouponController::class, 'index'])->name('coupons');
        Route::post('/coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
        Route::get('/edit-coupon/{id}', [AdminCouponController::class, 'edit'])->name('coupons.edit');
        Route::put('/coupons/{id}', [AdminCouponController::class, 'update'])->name('coupons.update');
        Route::delete('/coupons/{id}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');

        // Videos (Testimonials)
        Route::get('/videos', [AdminVideoController::class, 'index'])->name('videos');
        Route::post('/videos', [AdminVideoController::class, 'store'])->name('videos.store');
        Route::get('/edit-video/{id}', [AdminVideoController::class, 'edit'])->name('videos.edit');
        Route::put('/videos/{id}', [AdminVideoController::class, 'update'])->name('videos.update');
        Route::delete('/videos/{id}', [AdminVideoController::class, 'destroy'])->name('videos.destroy');
        Route::get('/videos/{id}/toggle-status', [AdminVideoController::class, 'toggleStatus'])->name('videos.toggleStatus');
        Route::get('/videos/{id}/toggle-featured', [AdminVideoController::class, 'toggleFeatured'])->name('videos.toggleFeatured');

        // Social Posts (Instagram Feed)
        Route::get('/social-posts', [SocialPostController::class, 'index'])->name('social-posts.index');
        Route::get('/social-posts/create', [SocialPostController::class, 'create'])->name('social-posts.create');
        Route::post('/social-posts', [SocialPostController::class, 'store'])->name('social-posts.store');
        Route::get('/social-posts/{id}/edit', [SocialPostController::class, 'edit'])->name('social-posts.edit');
        Route::put('/social-posts/{id}', [SocialPostController::class, 'update'])->name('social-posts.update');
        Route::delete('/social-posts/{id}', [SocialPostController::class, 'destroy'])->name('social-posts.destroy');
        Route::get('/social-posts/{id}/toggle-status', [SocialPostController::class, 'toggleStatus'])->name('social-posts.toggleStatus');

        // Reviews Management
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews');
        Route::post('/reviews/{id}/status', [AdminReviewController::class, 'updateStatus'])->name('reviews.status');
        Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    });
});

// Debug Route
Route::get('/debug-data', function() {
    return [
        'sliders' => \App\Models\Slider::count(),
        'active_sliders' => \App\Models\Slider::active()->count(),
        'products' => \App\Models\Product::count(),
        'active_products' => \App\Models\Product::active()->count(),
        'featured_products' => \App\Models\Product::active()->featured()->count(),
        'categories' => \App\Models\Category::count(),
        'brands' => \App\Models\Brand::count(),
    ];
});