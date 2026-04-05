<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\CustomerVideo;
use App\Models\BlogPost;
use App\Models\SocialPost;
use App\Models\Setting;
use App\Services\InstagramService;

use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $cacheTtl = 3600; // 60 minutes

        $sliders = Cache::remember('home_sliders', $cacheTtl, fn() => Slider::active()->get());
        $featuredProducts = Cache::remember('home_featured_products', $cacheTtl, fn() => Product::active()->featured()->with(['attributes', 'images'])->take(8)->get());
        $trendingProducts = Cache::remember('home_trending_products', $cacheTtl, fn() => Product::active()->with(['attributes', 'images'])->take(8)->get()); // For demo
        $newArrivals = Cache::remember('home_new_arrivals', $cacheTtl, fn() => Product::active()->with(['attributes', 'images'])->latest()->take(8)->get());
        $bestSellers = Cache::remember('home_best_sellers', $cacheTtl, fn() => Product::active()->with(['attributes', 'images'])->take(8)->get()); // For demo
        $brands = Cache::remember('home_brands', $cacheTtl, fn() => Brand::active()->get());
        $categories = Cache::remember('home_categories', $cacheTtl, fn() => Category::active()->where('parent_id', null)->get());
        $videos = Cache::remember('home_videos', $cacheTtl, fn() => CustomerVideo::active()->featured()->take(6)->get());
        $blogPosts = Cache::remember('home_blog_posts', $cacheTtl, fn() => BlogPost::active()->latest()->take(3)->get());
        
        $instagramService = new InstagramService();
        $apiPosts = Cache::remember('home_instagram_api', $cacheTtl, fn() => $instagramService->getLatestMedia());
        
        $socialPosts = Cache::remember('home_social_posts', $cacheTtl, fn() => SocialPost::active()->get());
        $instagramWidget = Setting::getValue('instagram_widget_code');

        return view('pages.home', compact(
            'sliders', 'featuredProducts', 'trendingProducts', 
            'newArrivals', 'bestSellers', 'brands', 'categories', 'videos', 'blogPosts',
            'socialPosts', 'instagramWidget', 'apiPosts'
        ));
    }
}