<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@classicweld.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'B2B Dealer',
            'email' => 'dealer@example.com',
            'password' => bcrypt('password'),
            'role' => 'b2b',
        ]);

        User::create([
            'name' => 'B2C Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'role' => 'b2c',
        ]);

        // 2. Create Products
        $products = [
            [
                'name' => 'ClassicWeld MIG-200 Pro',
                'description' => 'Professional Grade MIG Welder with Dual Voltage support. Ideal for fabrication shops.',
                'retail_price' => 899.99,
                'dealer_price' => 650.00,
                'moq' => 5,
                'stock' => 50,
                'category' => 'Machines',
                'image' => 'mig-200.jpg'
            ],
            [
                'name' => 'TIG Master 3000',
                'description' => 'High-frequency TIG welder for aluminum and stainless steel precision work.',
                'retail_price' => 1299.00,
                'dealer_price' => 950.00,
                'moq' => 3,
                'stock' => 25,
                'category' => 'Machines',
                'image' => 'tig-3000.jpg'
            ],
            [
                'name' => 'Solar Auto-Darkening Helmet',
                'description' => 'Premium viewing area with 4 arc sensors and true color technology.',
                'retail_price' => 149.99,
                'dealer_price' => 85.00,
                'moq' => 10,
                'stock' => 200,
                'category' => 'Safety',
                'image' => 'helmet-solar.jpg'
            ],
            [
                'name' => 'Heavy Duty Welding Gloves',
                'description' => 'Heat resistant split leather gloves with kevlar stitching.',
                'retail_price' => 29.99,
                'dealer_price' => 15.00,
                'moq' => 50,
                'stock' => 500,
                'category' => 'Safety',
                'image' => 'gloves-hd.jpg'
            ],
            [
                'name' => 'ER70S-6 MIG Wire (11lb)',
                'description' => 'General purpose MIG wire for mild steel. Consistent feeding and low spatter.',
                'retail_price' => 45.00,
                'dealer_price' => 28.00,
                'moq' => 20,
                'stock' => 1000,
                'category' => 'Consumables',
                'image' => 'wire-er70s6.jpg'
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
