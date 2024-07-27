<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $vegetables = [
            'Rau muống nước' => 'Rau, lá',
            'Cải thìa' => 'Rau, lá',
            'Rau ngót' => 'Rau, lá',
            'Rau má' => 'Rau, lá',
            'Rau muống hạt' => 'Rau, lá',
            'Giá sống' => 'Rau, lá',
            'Cải bẹ xanh' => 'Rau, lá',
            'Cải ngồng' => 'Rau, lá',
            'Cải ngọt' => 'Rau, lá',
            'Rau dền' => 'Rau, lá',
            'Rau mồng tơi' => 'Rau, lá',
            'Rau tần ô' => 'Rau, lá',
            'Xà lách búp mỡ' => 'Rau, lá',
            'Xà lách lô lô xanh' => 'Rau, lá',
            'Xà lách thủy tinh thủy canh' => 'Rau, lá',
            'Bắp cải trắng' => 'Rau, lá',
            'Bầu sao' => 'Củ, Quả',
            'Bắp cải thảo' => 'Rau, lá',
            'Su su' => 'Củ, Quả',
            'Bắp cải tím' => 'Rau, lá',
            'Hành tây' => 'Củ, Quả',
            'Chanh không hạt' => 'Trái cây',
            'Khoai lang Nhật' => 'Củ, Quả',
            'Bí đỏ non' => 'Củ, Quả',
            'Bắp cải trái tim' => 'Rau, lá',
            'Táo Ninh Thuận' => 'Trái cây',
            'Dưa lưới tròn ruột cam' => 'Trái cây',
            'Dưa hấu đỏ' => 'Trái cây',
            'Cam sành' => 'Trái cây',
            'Bưởi da xanh nguyên trái' => 'Trái cây',
            'Quýt giống Úc' => 'Trái cây',
            'Quả đào nhập khẩu Trung Quốc' => 'Trái cây',
            'Nho mẫu đơn nhập khẩu Trung Quốc' => 'Trái cây',
            'Lê đường nhập khẩu Trung Quốc' => 'Trái cây',
            'Thanh long ruột trắng' => 'Trái cây'
        ];

        // Chọn ngẫu nhiên loại rau củ quả
        $vegetable = $this->faker->randomElement(array_keys($vegetables));
        $categoryName = $vegetables[$vegetable];
        $category = Category::where('name', $categoryName)->first();
        if (!$category) {
            // Tạo category nếu chưa tồn tại
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'description' => "Các loại {$categoryName}",
            ]);
        }

        $brand = Brand::all()->random();
        // Tạo trọng lượng ngẫu nhiên từ 200g đến 1000g
        $weights = [200, 300, 400, 500, 600, 700, 800, 900, 1000];
        $weight = $this->faker->randomElement($weights);
        $weightString = $weight === 1000 ? '1kg' : "{$weight}g";

        return [
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => "{$vegetable} {$weightString}",
            'image' => $this->faker->imageUrl(640, 480, 'vegetables', true),
            'slug' => Str::slug("{$vegetable} {$weightString}"),
            'excerpt' => $this->faker->sentence(),
            'price_regular' => $this->faker->randomFloat(4, 10000, 50000),
            'price_sale' => $this->faker->optional()->randomFloat(4, 10000, 50000),
            'quantity' => $this->faker->numberBetween(1, 100),
            'length' => $this->faker->numberBetween(10, 100),
            'width' => $this->faker->numberBetween(10, 100),
            'height' => $this->faker->numberBetween(10, 100),
            'weight' => $weight,
            'is_home' => $this->rand(0, 1),
            'is_active' => $this->faker->rand(0, 1),
            'description' => $this->faker->paragraph(),
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
