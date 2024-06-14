<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Psy\Util\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 15 bản ghi giả định
        for ($i = 0; $i < 15; $i++) {
            Product::create([
                'category_id' => 1,
                'brand_id' => 1,
                'name' => 'Product ' . ($i + 1),
                'image' => 'product_' . ($i + 1) . '.jpg',
                'slug' => 'Product ' . ($i + 1),
                'excerpt' => 'Excerpt for Product ' . ($i + 1),
                'price_regular' => rand(10, 1000),
                'price_sale' => rand(5, 800),
                'quantity' => rand(1, 100),
                'is_home' => rand(0, 1),
                'is_active' => rand(0, 1),
                'description' => 'Description for Product ' . ($i + 1),
                'content' => 'Content for Product ' . ($i + 1),
            ]);
    }

    }
}
