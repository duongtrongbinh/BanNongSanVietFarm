<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả các post_id và comment_id
        $postIds = DB::table('posts')->pluck('id')->toArray();
        $commentIds = DB::table('comments')->pluck('id')->toArray();

        // Kiểm tra xem có đủ dữ liệu không
        if (count($postIds) < 1 || count($commentIds) < 100) {
            echo "Không có đủ dữ liệu trong bảng posts hoặc comments.";
            return;
        }

        // Đảm bảo mỗi bài viết có ít nhất 1 đánh giá
        foreach ($postIds as $postId) {
            DB::table('post_comments')->insert([
                'post_id' => $postId,
                'comment_id' => $commentIds[array_rand($commentIds)] // Chọn ngẫu nhiên một comment_id
            ]);
        }

        // Thêm thêm đánh giá cho một số bài viết
        foreach (range(1, 100) as $index) {
            DB::table('post_comments')->insert([
                'post_id' => $postIds[array_rand($postIds)], // Chọn ngẫu nhiên một bài viết
                'comment_id' => $commentIds[array_rand($commentIds)] // Chọn ngẫu nhiên một comment_id
            ]);
        }
    }
}
