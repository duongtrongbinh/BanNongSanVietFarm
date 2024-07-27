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
                    'image' => 'https://assets.unileversolutions.com/v1/60221576.png?im=AspectCrop=(1440,600);Resize=(1440,600)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'product_id' => $product->id,
                    'image' => 'https://thanhtra.com.vn/data/images/0/2022/09/10/congdinh/kiem-nghiem-rau-cu-qua-2.png?dpi=150&quality=100&w=630&mode=crop&anchor=topcenter&scale=both',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
