<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $typeUnit = rand(0, 1);
            $amount = ($typeUnit == 0) ? rand(10, 1000) : rand(1, 100);

            DB::table('vouchers')->insert([
                'title' => 'Voucher ' . ($i + 1),
                'quantity' => rand(1, 100),
                'amount' => $amount,
                'start_date' => Carbon::now()->addDays(rand(-30, 30)),
                'end_date' => Carbon::now()->addDays(rand(1, 90)),
                'description' => 'Description for Voucher ' . ($i + 1),
                'is_active' => rand(0, 1),
                'type_unit' => $typeUnit,
                'code' => fake()->uuid(),
            ]);
        }
    }
}