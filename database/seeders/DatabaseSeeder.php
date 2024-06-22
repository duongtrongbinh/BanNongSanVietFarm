<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        User::create([
            "name"=> "Admin",
            "email"=> "admin@gmail.com",
            "password"=> bcrypt("12345678"),
            "phone" => "0123456789",
            "user_code" => "PH25966",
            "address" => "xa kin dang",
            "remember_token" => false
         ]);
        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductImageSeeder::class);
        $this->call(VoucherSeeder::class);

        $users = [
            [
                'social_id' => '0',
                'name' => 'John Doe',
                'avatar' => 'https://example.com/avatar/johndoe.jpg',
                'email' => 'admin@gmail.com',
                'phone' => '123456789',
                'password' => bcrypt('12345678'),
                'remember_token' => Str::random(10),
                'user_code' => 'USER001',
                'type_social' => 0,
                'active' => 1,
                'status' => true,
                'address' => '123 Main St, Anytown USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'social_id' => '0',
                'name' => 'Jane Smith',
                'avatar' => 'https://example.com/avatar/janesmith.jpg',
                'email' => 'janesmith@example.com',
                'phone' => '987654321',
                'password' => bcrypt('password456'),
                'remember_token' => Str::random(10),
                'user_code' => 'USER002',
                'type_social' => 0,
                'active' => 1,
                'status' => true,
                'address' => '456 Oak Rd, Somewhere City',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        DB::table('users')->insert($users);

        $this->call(OrderSeeder::class);
    }
}