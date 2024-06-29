<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Rau, lá',
                'slug' => 'rau-la',
                'description' => 'Các loại rau, lá',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Củ, Quả',
                'slug' => 'cu-qua',
                'description' => 'Các loại củ và quả',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Trái cây',
                'slug' => 'trai-cay',
                'description' => 'Các loại trái cây',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
