<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $faker = Faker::create();

    //     $users = User::all();
    //     foreach ($users as $user) {
    //         for ($i = 0; $i < 30; $i++) {
    //             DB::table('orders')->insert([
    //                 'user_id' => 1,
    //                 'voucher_id' => rand(1, 15),
    //                 'address' => $faker->address,
    //                 'name' => $user->name,
    //                 'phone' => $user->phone,
    //                 'email' => $user->email,
    //                 'before_total_amount' => $faker->randomFloat(4, 100, 1000),
    //                 'shipping' => $faker->randomFloat(4, 10, 50),
    //                 'after_total_amount' => $faker->randomFloat(4, 110, 1050),
    //                 'note' => $faker->sentence(),
    //                 'status' => OrderStatus::PENDING,
    //                 'order_code' => strtoupper($faker->regexify('[A-Z]{4}[0-9]{4}')),
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ]);
    //         }
    //     }

    //     $orders = Order::all();
    //     foreach ($orders as $order) {
    //         DB::table('order_histories')->insert([
    //             'order_id' => $order->id,
    //             'status' => $order->status,
    //             'warehouse' => 'Bưu cục',
    //         ]);
    //     }
        
    //     $products = Product::all();
    //     foreach ($orders as $order) {
    //         // Create 1-5 order details for each order
    //         $orderDetailsCount = rand(2, 10);
    //         $product = $products->random();
    //         for ($j = 0; $j < $orderDetailsCount; $j++) {
    //             DB::table('order_details')->insert([
    //                 'order_id' => $order->id,
    //                 'product_id' => $product->id,
    //                 'name' => $product->name,
    //                 'image' => $product->image,
    //                 'price_regular' => $product->price_regular,
    //                 'price_sale' => $product->price_sale,
    //                 'quantity' => $product->quantity,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ]);
    //         }
    //     }
    // }

    public function run(): void
    {
        $faker = Faker::create();

        $users = User::all();
        foreach ($users as $user) {
            for ($i = 0; $i < 30; $i++) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'voucher_id' => rand(1, 15),
                    'address' => $faker->address,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'before_total_amount' => $faker->randomFloat(4, 100, 1000),
                    'shipping' => $faker->randomFloat(4, 10, 50),
                    'after_total_amount' => $faker->randomFloat(4, 110, 1050),
                    'note' => $faker->sentence(),
                    'status' => rand(1, 5),
                    'order_code' => strtoupper($faker->regexify('[A-Z]{4}[0-9]{4}')),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Create 1-5 order details for each order
                $orderDetailsCount = rand(2, 10);
                $products = Product::inRandomOrder()->take($orderDetailsCount)->get();
                foreach ($products as $product) {
                    DB::table('order_details')->insert([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'image' => $product->image,
                        'price_regular' => $product->price_regular,
                        'price_sale' => $product->price_sale,
                        'quantity' => $faker->numberBetween(1, 5),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Create order history
                DB::table('order_histories')->insert([
                    'order_id' => $order->id,
                    'status' => $order->status,
                    'warehouse' => 'Bưu cục',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}