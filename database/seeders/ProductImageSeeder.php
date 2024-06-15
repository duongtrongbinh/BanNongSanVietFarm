<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 300; $i++) {
            ProductImage::insert([
               'product_id' => rand(1, 100), 
                'image' => 'https://alokiddy.com.vn/Uploads/images/huong/tu-vung-tieng-anh-ve-cac-loai-rau-cu-qua.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
