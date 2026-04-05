<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => "Men's Shoes", 'slug' => 'mens-shoes', 'description' => 'Shoes for men', 'display_order' => 1],
            ['name' => "Women's Shoes", 'slug' => 'womens-shoes', 'description' => 'Shoes for women', 'display_order' => 2],
            ['name' => "Kids Shoes", 'slug' => 'kids-shoes', 'description' => 'Shoes for children', 'display_order' => 3],
            ['name' => 'Sports Shoes', 'slug' => 'sports-shoes', 'description' => 'Athletic and sports shoes', 'display_order' => 4],
            ['name' => 'Formal Shoes', 'slug' => 'formal-shoes', 'description' => 'Formal and business shoes', 'display_order' => 5],
            ['name' => 'Casual Shoes', 'slug' => 'casual-shoes', 'description' => 'Casual everyday shoes', 'display_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::create(array_merge($cat, ['status' => 'active']));
        }

        echo "✓ 6 sample categories created\n";
    }
}