<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        $faker = Faker::create();

        for ($i = 0; $i < 15; $i++) {
            $typeUnit = rand(0, 1);

            // Đảm bảo 'amount' tuân theo quy tắc
            if ($typeUnit == 0) {
                $amount = rand(1000, 10000); // Số tiền phải từ 1000 trở lên
            } else {
                $amount = rand(1, 99); // Giá trị không quá 99
            }

            $applicableLimit = rand(1000, 10000); // applicable_limit phải từ 1000 trở lên

            $startDate = Carbon::now()->addDays(rand(-30, 30));
            $endDate = (clone $startDate)->addDays(rand(1, 90));

            DB::table('vouchers')->insert([
                'title' => 'Giảm ' . $amount . ' cho đơn hàng có giá trị ' . $applicableLimit . ' VNĐ',
                'quantity' => rand(1, 100), // Số lượng phải ít nhất là 1
                'amount' => $amount,
                'start_date' => $startDate->format('Y-m-d\TH:i'), // Định dạng ngày cho đúng yêu cầu
                'end_date' => $endDate->format('Y-m-d\TH:i'), // Ngày kết thúc phải sau ngày bắt đầu
                'description' => 'Description for Voucher ' . ($i + 1),
                'is_active' => rand(0, 1),
                'type_unit' => $typeUnit, // Phải là 0 hoặc 1
                'code' => $faker->uuid, // Đảm bảo mã duy nhất
                'applicable_limit' => $applicableLimit, // applicable_limit phải từ 1000 trở lên
            ]);
        }
    }
}
