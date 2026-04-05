<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BlogPost;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Summer 2024: The Essential Sneaker Guide',
                'excerpt' => 'Discover the most anticipated sneaker releases and trends for the upcoming summer season. From vibrant colors to breathable mesh tech.',
                'content' => '<h1>Summer Sneaker Trends 2024</h1><p>The summer of 2024 is bringing a refreshing mix of nostalgia and futuristic performance. As the sun comes out, sneakerheads are looking for footwear that combines breathability with standout aesthetics.</p><h3>1. Neon Performance</h3><p>We are seeing a massive shift towards high-visibility trainers. The Nike Air Max and Adidas Ultraboost lines are leading the charge with neon accents that pop against city pavements.</p><h3>2. Breathable Mesh</h3><p>Comfort is king in the heat. Brands are doubling down on tech like Primeknit and Flyknit to ensure your feet stay cool during those long summer walks.</p><p>Explore our latest collection to find your perfect summer pair today!</p>',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
                'author_name' => 'Michael Scott',
            ],
            [
                'title' => 'How to Style Your Sneakers for Every Occasion',
                'excerpt' => 'Master the art of pairing your favorite footwear with both casual and formal outfits. Sneakers are no longer just for the gym.',
                'content' => '<h1>Versatile Sneaker Styling</h1><p>The lines between casual and formal wear are blurring. Today, a clean pair of leather sneakers can be perfectly appropriate for a business-casual meeting or a night out.</p><h3>Casual Friday</h3><p>Pair your classic white low-tops with tapered chinos and a simple linen shirt for an effortless, polished look.</p><h3>Evening Elegance</h3><p>Try dark-toned suede sneakers with a slim-fit blazer. It adds a touch of modern sophistication without sacrificing comfort.</p><p>Remember, the key is to keep your sneakers pristine and clean!</p>',
                'image' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a',
                'author_name' => 'Sarah Miller',
            ],
            [
                'title' => 'Ultimate Guide to Sneaker Cleaning and Maintenance',
                'excerpt' => 'Expert tips on how to keep your kicks looking brand new for as long as possible. Learn the best tools and techniques.',
                'content' => '<h1>Kicks Cleaning 101</h1><p>Your sneakers are an investment. Proper maintenance not only keeps them looking sharp but also extends their lifespan significantly.</p><h3>The Basic Kit</h3><p>You don\'t need expensive gadgets. A soft-bristled brush, mild detergent, and a microfiber cloth are your best friends.</p><h3>Avoid the Washing Machine</h3><p>While tempting, the heat and agitation of a washing machine can damage the glue and structure of your trainers. Always opt for a manual hand-clean when possible.</p><p>Stay ahead of the grime and keep that "fresh out of the box" feeling!</p>',
                'image' => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86',
                'author_name' => 'Alex Johnson',
            ],
            [
                'title' => 'The Rise of Sustainable Footwear in 2024',
                'excerpt' => 'How major brands are pivoting to eco-friendly materials and ethical manufacturing processes without compromising on style.',
                'content' => '<h1>Sustainability in Every Step</h1><p>The footwear industry is undergoing a green revolution. From recycled ocean plastics to mushroom-based "leather," the future of sneakers is undeniably sustainable.</p><h3>Recycled Tech</h3><p>Top brands are now utilizing post-consumer waste to create durable, high-performance midsoles. It\'s a win-win for both comfort and the planet.</p><p>Join the movement by choosing brands that prioritize ethical production and long-lasting quality.</p>',
                'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77',
                'author_name' => 'Emma Green',
            ]
        ];

        foreach ($posts as $post) {
            BlogPost::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'excerpt' => $post['excerpt'],
                'content' => $post['content'],
                'image' => $post['image'],
                'author_name' => $post['author_name'],
                'status' => 'active',
            ]);
        }
    }
}
