<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerVideo;

class CustomerVideoSeeder extends Seeder
{
    public function run()
    {
        $videos = [
            [
                'customer_name' => 'Alex Johnson',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Placeholder
                'thumbnail_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=600&auto=format&fit=crop',
                'comment' => 'The premium quality of these sneakers is unmatched. I\'ve never felt more comfortable and stylish at the same time!',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'customer_name' => 'Sarah Miller',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Placeholder
                'thumbnail_url' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=600&auto=format&fit=crop',
                'comment' => 'ShoeHub has the most exclusive drops. Their customer service handled my size exchange flawlessly. Highly recommended!',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'customer_name' => 'Michael Chen',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Placeholder
                'thumbnail_url' => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?q=80&w=600&auto=format&fit=crop',
                'comment' => 'Fastest delivery I\'ve ever experienced. The manifest was professionally packed and the authenticators did a great job.',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'customer_name' => 'Emma Davis',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Placeholder
                'thumbnail_url' => 'https://images.unsplash.com/photo-1512374382149-4332c6c021f1?q=80&w=600&auto=format&fit=crop',
                'comment' => 'Love the "manifest" design of the account page. It feels premium and high-end. The shoes are even better in person!',
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'customer_name' => 'David Wilson',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Placeholder
                'thumbnail_url' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=600&auto=format&fit=crop',
                'comment' => 'Sustainability and style go hand in hand here. I love that ShoeHub verifies every single pair before it reaches my door.',
                'is_featured' => true,
                'status' => 'active',
            ],
        ];

        foreach ($videos as $video) {
            CustomerVideo::create($video);
        }
    }
}
