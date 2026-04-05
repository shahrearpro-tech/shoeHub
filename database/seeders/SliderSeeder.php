<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'New Urban Collection',
                'subtitle' => 'Step into style with our latest urban sneakers. Designed for comfort, built for the city.',
                'image_path' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=1600&q=80',
                'button_text' => 'Shop Collection',
                'button_link' => '/shop',
                'display_order' => 1,
                'status' => 'active'
            ],
            [
                'title' => 'Performance Running',
                'subtitle' => 'Elite footwear for serious athletes. Experience unmatched cushioning and support.',
                'image_path' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=1600&q=80',
                'button_text' => 'View Running Shoes',
                'button_link' => '/shop?category=sports-shoes',
                'display_order' => 2,
                'status' => 'active'
            ],
            [
                'title' => 'Exclusive Summer Sale',
                'subtitle' => 'Get up to 50% off on selected summer styles. Limited time only!',
                'image_path' => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?auto=format&fit=crop&w=1600&q=80',
                'button_text' => 'Claim Discount',
                'button_link' => '/shop',
                'display_order' => 3,
                'status' => 'active'
            ]
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
