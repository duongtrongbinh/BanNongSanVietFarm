<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            $name = $faker->sentence(2);
            Brand::insert([
                'name' => $name, 
                'slug' => Str::slug($name),
                'image' => 'https://thongtinchungcu.com.vn/wp-content/uploads/2023/11/logo-rau-cu-qua.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
