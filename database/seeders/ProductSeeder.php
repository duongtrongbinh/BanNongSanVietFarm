<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use LengthException;

class ProductSeeder extends Seeder
{
    public function run(): void {
        DB::table('product_tags')->truncate();
        
        $products = Product::get();

        foreach ($products as $product) {
            DB::table('product_tags')->insert([
                [
                    'product_id' => $product->id,
                    'tag_id' => rand(1, 3),
                ],
                [
                    'product_id' => $product->id,
                    'tag_id' => rand(4, 6),
                ],
            ]);
        }

        foreach ($products as $product) {
            $relatedCount = rand(2, 5);
            $productRelatedIds = []; // Mảng lưu trữ các product_related_id đã chọn cho sản phẩm hiện tại

            while (count($productRelatedIds) < $relatedCount) {
                $relatedProduct = Product::inRandomOrder()->first(); // Chọn ngẫu nhiên một sản phẩm khác

                // Kiểm tra nếu sản phẩm ngẫu nhiên không phải là sản phẩm hiện tại và chưa được chọn
                if ($relatedProduct->id !== $product->id && !in_array($relatedProduct->id, $productRelatedIds)) {
                    DB::table('product_related')->insert([
                        'product_id' => $product->id,
                        'product_related_id' => $relatedProduct->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $productRelatedIds[] = $relatedProduct->id; // Thêm product_related_id vào mảng đã chọn
                }
            }
        }
    }
}

