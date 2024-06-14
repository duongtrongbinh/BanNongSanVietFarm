<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::create([
            "name"=> "Long Ma Bắc Giang",
            "email"=> "admin@gmail.com",
            "password"=> bcrypt("12345678"),
            "phone" => "0123456789",
            "user_code" => "PH30417",
            "address" => "xa kin dang",
            'province_id' => 1,
            'district_id' => 1,
            'ward_id' => 1,
            "remember_token" => false
         ]);
    }
}
