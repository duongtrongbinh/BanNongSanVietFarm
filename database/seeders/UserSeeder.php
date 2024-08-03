<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN'); // Sử dụng Faker với ngôn ngữ tiếng Việt

        // Lấy tất cả các ID từ bảng provinces, districts và wards
        $provinceIds = DB::table('provinces')->pluck('ProvinceID')->toArray();
        $districtIds = DB::table('districts')->pluck('DistrictID')->toArray();
        $wardIds = DB::table('wards')->pluck('id')->toArray();

        foreach (range(1, 1000) as $index) {
            DB::table('users')->insert([
                'social_id' => $faker->optional()->uuid,
                'name' => $faker->name,
                'avatar' => $faker->optional()->imageUrl(200, 200, 'people'),
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->optional()->phoneNumber,
                'password' => Hash::make('password'), 
                'remember_token' => Str::random(10),
                'user_code' => Str::uuid(),
                'type_social' => $faker->numberBetween(0, 1),
                'active' => $faker->boolean,
                'is_spam' => $faker->numberBetween(0, 1),
                'status' => $faker->boolean,
                'token' => Str::random(50),
                'address' => $faker->optional()->address,
                'province_id' => $faker->optional()->randomElement($provinceIds),
                'district_id' => $faker->optional()->randomElement($districtIds),
                'ward_id' => $faker->optional()->randomElement($wardIds),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => $faker->optional()->dateTime
            ]);
        }
    }
}