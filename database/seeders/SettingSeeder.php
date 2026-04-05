<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'ShoeHub',
            'site_email' => 'info@shoehub.com',
            'site_phone' => '01700000000',
            'currency' => 'BDT',
            'currency_symbol' => '৳',
            'timezone' => 'Asia/Dhaka',
            'items_per_page' => '12',
            'free_shipping_threshold' => '1000',
            'tax_rate' => '0.00',
            'enable_reviews' => '1',
            'enable_coupons' => '1',
            'smtp_host' => '',
            'smtp_port' => '587',
            'smtp_username' => '',
            'smtp_password' => '',
            'smtp_encryption' => 'tls',
        ];

        foreach ($settings as $key => $value) {
            Setting::create([
                'setting_key' => $key,
                'setting_value' => $value,
            ]);
        }

        echo "✓ Default settings created\n";
    }
}