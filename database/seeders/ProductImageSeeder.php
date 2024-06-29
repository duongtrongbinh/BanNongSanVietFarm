<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::get();

        foreach ($products as $product) {
            DB::table('product_images')->insert([
                [
                    'product_id' => $product->id,
                    'image' => 'http://127.0.0.1:8000/storage/photos/1/products/rau-cu-qua.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'product_id' => $product->id,
                    'image' => 'http://127.0.0.1:8000/storage/photos/1/products/0QDG8alS9V.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
