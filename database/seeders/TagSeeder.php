<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            [
                'name' => 'Rau xanh',
                'slug' => 'rau-xanh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rau má',
                'slug' => 'rau-ma',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rau muống',
                'slug' => 'rau-muong',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cà chua',
                'slug' => 'ca-chua',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Khoai tây',
                'slug' => 'khoai-tay',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cà rốt',
                'slug' => 'ca-rot',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bí đỏ',
                'slug' => 'bi-do',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cam',
                'slug' => 'cam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dưa hấu',
                'slug' => 'dua-hau',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Táo',
                'slug' => 'tao',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
