<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN'); // Sử dụng Faker với ngôn ngữ tiếng Việt

        // Danh sách các tiêu đề và mô tả tiếng Việt
        $titles = [
            'Táo Queen Baby', 'Quýt Citrus Úc', 'Táo Da 80', 'Táo Fuji',
            'Chuối Tiêu', 'Dưa Hấu', 'Xoài Cát Hòa Lộc', 'Nho Mỹ',
            'Dâu Tây', 'Bơ Sáp', 'Hồng Giòn', 'Lê Hàn Quốc',
            'Kiwi', 'Lựu', 'Nho Đen', 'Cam Sành',
            'Dưa Lê', 'Quả Mít', 'Nhãn', 'Bưởi Đỏ',
            'Măng Cụt', 'Dưa Chuột', 'Ớt Chuông', 'Cà Chua',
            'Củ Cải', 'Cà Rốt', 'Su Su', 'Súp Lơ',
            'Bắp Cải', 'Rau Cải', 'Rau Xà Lách', 'Rau Muống',
            'Khoai Lang', 'Khoai Tây', 'Nấm', 'Tỏi',
            'Gừng', 'Hành', 'Ớt', 'Dưa Chua',
            'Dưa Cải', 'Hành Tây', 'Tỏi Tây', 'Rau Ngót',
            'Cải Xoong', 'Cải Thảo', 'Cải Bắp', 'Cải Chíp'
        ];

        $images = [
            'https://luontuoisach.vn/public/files/upload/product/1718706187t%C3%A1o%20queen%20bayby.jpg',
            'https://luontuoisach.vn/public/files/upload/product/1720499404Qu%C3%BDt%20Citrus%20%C3%9Ac.jpg',
            'https://luontuoisach.vn/public/files/upload/product/1684204562t%C3%A1o%20da%2080.jpg',
            'https://luontuoisach.vn/public/files/upload/product/1696932698T%C3%A1o%20Fuji.jpg'
        ];

        // Danh sách các mô tả và nội dung tiếng Việt
        $descriptions = [
            'Mô tả sản phẩm rất chi tiết và đầy đủ.',
            'Sản phẩm này có chất lượng tuyệt vời.',
            'Đây là một sản phẩm phổ biến với nhiều ưu điểm.',
            'Sản phẩm được làm từ nguyên liệu cao cấp.',
            'Chúng tôi cam kết cung cấp sản phẩm chất lượng.'
        ];

        $contents = [
            'Nội dung bài viết chi tiết với thông tin hữu ích về sản phẩm. Đây là phần nội dung chính mà bạn có thể tham khảo để hiểu thêm về sản phẩm, bao gồm các thông tin liên quan và lợi ích của sản phẩm.',
            'Bài viết này sẽ cung cấp cho bạn thông tin chi tiết về các tính năng và ưu điểm của sản phẩm, giúp bạn đưa ra quyết định mua hàng tốt nhất.',
            'Chúng tôi cung cấp thông tin đầy đủ và chi tiết về sản phẩm, giúp bạn hiểu rõ hơn về cách sử dụng và lợi ích mà sản phẩm mang lại.',
            'Đây là bài viết chứa các thông tin hữu ích về sản phẩm, với các điểm nổi bật và lợi ích chính. Hãy đọc kỹ để hiểu rõ hơn về sản phẩm trước khi quyết định mua.',
            'Bài viết này sẽ giúp bạn tìm hiểu sâu về sản phẩm, từ thông tin cơ bản đến các lợi ích và tính năng nổi bật. Đọc để biết thêm chi tiết.'
        ];

        foreach (range(1, 50) as $index) {
            DB::table('posts')->insert([
                'title' => $titles[array_rand($titles)], // Chọn ngẫu nhiên tiêu đề tiếng Việt
                'image' => $images[array_rand($images)], // Chọn ngẫu nhiên hình ảnh
                'description' => $descriptions[array_rand($descriptions)], // Chọn ngẫu nhiên mô tả tiếng Việt
                'content' => $contents[array_rand($contents)], // Chọn ngẫu nhiên nội dung tiếng Việt
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ]);
        }
    }
}
