<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
class ProductSeeder extends Seeder
{
    public function run(): void {
        DB::table('product_tags')->truncate();
        
        $products = Product::get();

        foreach ($products as $product) {
            DB::table('product_tags')->insert([
                [
                    'product_id' => $product->id,
                    'tag_id' => rand(1, 3),
                ],
                [
                    'product_id' => $product->id,
                    'tag_id' => rand(4, 6),
                ],
            ]);
        }
    }
}

