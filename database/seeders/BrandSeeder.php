<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'name' => 'VinECO',
                'slug' => 'vineco',
                'image' => 'http://127.0.0.1:8000/storage/photos/1/brands/105605vineco_product.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đà Lạt GAP Store',
                'slug' => 'da-lat-gap-store',
                'image' => 'http://127.0.0.1:8000/storage/photos/1/brands/326803268_996716798420655_4179510502990593730_n.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Organica',
                'slug' => 'organica',
                'image' => 'http://127.0.0.1:8000/storage/photos/1/brands/323161250_1226863788211265_3882755900759034009_n.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '3Sach Food',
                'slug' => '3sach-food',
                'image' => 'http://127.0.0.1:8000/storage/photos/1/brands/431902374_744781104413752_1751726059077355725_n.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Organicfood',
                'slug' => 'organicfood',
                'image' => 'http://127.0.0.1:8000/storage/photos/1/brands/logo1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rau Sạch Việt Tâm - Veganic',
                'slug' => 'rau-sach-viet-tam-veganic',
                'image' => 'http://127.0.0.1:8000/storage/photos/1/brands/298612789_459785286158568_5440640451565624711_n.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'VietGreenFood',
                'slug' => 'vietgreenfood',
                'image' => 'http://127.0.0.1:8000/storage/photos/1/brands/315644665_783218973129227_8206020477256304524_n.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rau Cười Việt Nhật',
                'slug' => 'rau-cuoi-viet-nhat',
                'image' => 'http://127.0.0.1:8000/storage/photos/1/brands/301011161_763600591668450_8674657883259250719_n.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thực Phẩm Tấn Tài',
                'slug' => 'thuc-pham-tan-tai',
                'image' => 'http://127.0.0.1:8000/storage/photos/1/brands/302532697_767700384308017_6418043127829839244_n.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nông Nghiệp Bền Vững OriFarm',
                'slug' => 'nong-nghiep-ben-vung-orifarm',
                'image' => 'http://127.0.0.1:8000/storage/photos/1/brands/logo2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
