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
        $faker = Faker::create();
        for ($i = 0; $i < 100; $i++) {
            $name = $faker->sentence(3);
            $priceRegular = $faker->randomFloat(4, 1000, 100000);
            Product::insert([
                'category_id' => rand(1, 3),
                'brand_id' => rand(1, 10),
                'name' => $name,
                'image' => 'https://mtcs.1cdn.vn/2023/05/30/rau-cu-qua.jpg',
                'slug' => Str::slug($name),
                'excerpt' => $faker->sentence,
                'price_regular' => $priceRegular,
                'price_sale' => $faker->randomFloat(4, 1000, $priceRegular),
                'quantity' => $faker->numberBetween(1, 100),
                'is_home' => $faker->boolean,
                'is_active' => $faker->boolean,
                'description' => $faker->paragraph,
                'content' => $faker->text,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 1; $i < 101; $i++) {
            DB::table('product_tags')->insert([
                [
                    'product_id' => $i,
                    'tag_id' => rand(1, 8),
                ],
                [
                    'product_id' => $i,
                    'tag_id' => rand(9, 15),
                ],
            ]);

        }

    }
}

