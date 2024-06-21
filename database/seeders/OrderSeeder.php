<?php

namespace Database\Seeders;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 100 orders
        for ($i = 0; $i < 100; $i++) {
            DB::table('orders')->insert([
                'user_id' => 1,
                'voucher_id' => rand(1, 15),
                'address' => $faker->address,
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'before_total_amount' => $faker->randomFloat(4, 100, 1000),
                'shipping' => $faker->randomFloat(4, 10, 50),
                'after_total_amount' => $faker->randomFloat(4, 110, 1050),
                'note' => $faker->sentence(),
                'status' => $faker->numberBetween(0, 5),
                'order_code' => strtoupper($faker->regexify('[A-Z]{4}[0-9]{4}')),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        
        for ($i = 0; $i < 100; $i++) {
            // Create 1-5 order details for each order
            $orderDetailsCount = $faker->numberBetween(1, 5);
            $products = Product::all();
            for ($j = 0; $j < $orderDetailsCount; $j++) {
                foreach ($products as $product) {
                    if ($product->id == rand(1, 100)) {
                        DB::table('order_details')->insert([
                            'order_id' => $i + 1,
                            'product_id' => $product->id,
                            'name' => $product->name,
                            'image' => $product->image,
                            'price_regular' => $product->price_regular,
                            'price_sale' => $product->price_sale,
                            'quantity' => $faker->numberBetween(1, 10),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }
        }
    }
}
