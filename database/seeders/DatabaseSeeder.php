<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Bước 1: Chạy đoạn seed thêm user, brand, category, tag trước và comment tất cả đoạn seed còn lại.
        */
        $users = [
            [
                'social_id' => '0',
                'name' => 'Ben',
                'avatar' => 'https://images.sftcdn.net/images/t_app-icon-m/p/6291b348-9b32-11e6-bf94-00163ec9f5fa/1046016500/talking-ben-logo.png',
                'email' => 'admin@gmail.com',
                'phone' => '0123456789',
                'password' => bcrypt('12345678'),
                'remember_token' => Str::random(10),
                'user_code' => 'USER001',
                'type_social' => 0,
                'active' => 1,
                'status' => true,
                'address' => 'Hà Nội',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'social_id' => '0',
                'name' => 'Tom',
                'avatar' => 'https://cdn.tgdd.vn/2020/03/GameApp/Untitled-5-200x200-2.jpg',
                'email' => 'customer@gmail.com',
                'phone' => '0987654321',
                'password' => bcrypt('12345678'),
                'remember_token' => Str::random(10),
                'user_code' => 'USER002',
                'type_social' => 0,
                'active' => 1,
                'status' => true,
                'address' => 'Hồ Chí Minh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('users')->insert($users);

        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);

        /**
         * Bước 2: Đăng nhập vào giao diện admin và vào import thêm sản phẩm.
        */

        /**
         * Bước 3: Comment đoạn seed ở bước 1 lại và chạy đoạn seed còn lại
        */
            // $this->call(ProductSeeder::class);
            // $this->call(ProductImageSeeder::class);
            // $this->call(VoucherSeeder::class);
            // $this->call(OrderSeeder::class);
    }
}