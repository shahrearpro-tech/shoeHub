<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Nike', 'slug' => 'nike', 'description' => 'Just Do It'],
            ['name' => 'Adidas', 'slug' => 'adidas', 'description' => 'Impossible is Nothing'],
            ['name' => 'Puma', 'slug' => 'puma', 'description' => 'Forever Faster'],
            ['name' => 'Reebok', 'slug' => 'reebok', 'description' => 'Be More Human'],
            ['name' => 'New Balance', 'slug' => 'new-balance', 'description' => 'Always in Beta'],
            ['name' => 'Converse', 'slug' => 'converse', 'description' => 'Made Different'],
            ['name' => 'Vans', 'slug' => 'vans', 'description' => 'Off The Wall'],
            ['name' => 'Bata', 'slug' => 'bata', 'description' => 'Shoemaker to the World'],
        ];

        foreach ($brands as $i => $brand) {
            Brand::create(array_merge($brand, [
                'display_order' => $i + 1,
                'status' => 'active',
            ]));
        }

        echo "✓ 8 sample brands created\n";
    }
}