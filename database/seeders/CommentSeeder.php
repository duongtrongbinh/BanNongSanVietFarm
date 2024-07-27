<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        // Lấy tất cả user_id từ bảng users
        $userIds = DB::table('users')->pluck('id')->toArray();

        if (empty($userIds)) {
            echo "Không có dữ liệu trong bảng users.";
            return;
        }

        foreach (range(1, 100) as $index) {
            DB::table('comments')->insert([
                'user_id' => $userIds[array_rand($userIds)], // Chọn ngẫu nhiên user_id
                'content' => $faker->text(100), // Nội dung bình luận bằng tiếng Việt
                'ratting' => $faker->numberBetween(1, 5), // Đánh giá ngẫu nhiên từ 1 đến 5
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ]);
        }
    }
}
