<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $names = ['Rau', 'Củ', 'Quả'];

        foreach ($names as $name) {
            Category::insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $faker->sentence(5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
