<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;

class DashboardController extends Controller
{
    protected $healthService;

    public function __construct(\App\Services\SystemHealthService $healthService)
    {
        $this->healthService = $healthService;
    }

    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalRevenue = Order::where('order_status', 'delivered')->sum('total_amount');
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $recentOrders = Order::latest()->take(10)->get();
        $recentReviews = Review::with(['product', 'user'])->latest()->take(5)->get();
        $recentActivities = \App\Models\ActivityLog::with('user')->latest()->take(10)->get();
        $avgRating = Review::where('status', 'approved')->avg('rating') ?: 0;
        $activeCoupons = \App\Models\Coupon::count();

        // Get System Health Status
        $systemStatus = $this->healthService->getSystemStatus();

        $kpis = [
            'revenue' => ['value' => $totalRevenue],
            'orders' => ['value' => $totalOrders],
            'customers' => ['value' => $totalCustomers],
            'profit' => ['value' => $totalRevenue * 0.2], // Estimated 20% profit margin
            'avg_rating' => ['value' => number_format($avgRating, 1)],
            'coupons' => ['value' => $activeCoupons],
        ];

        return view('admin.dashboard', compact(
            'kpis', 'pendingOrders', 'recentOrders', 'recentReviews', 'recentActivities', 'systemStatus'
        ));
    }
}