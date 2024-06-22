<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Controllers\Admin\OrderController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductImageSeeder::class);
        $this->call(VoucherSeeder::class);

        User::create([
            "name"=> "Admin",
            "email"=> "admin@gmail.com",
            "password"=> bcrypt("12345678"),
            "phone" => "0123456789",
            "user_code" => "PH25966",
            "address" => "xa kin dang",
            "remember_token" => false
        ]);

        $this->call(OrderSeeder::class);
    }
}
