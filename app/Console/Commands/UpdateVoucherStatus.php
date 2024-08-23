<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateVoucherStatus extends Command
{
    protected $signature = 'voucher:update-status';
    protected $description = 'Update voucher status to 0 when end_date has passed';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Lấy thời gian hiện tại
        $currentDateTime = Carbon::now();

        // Cập nhật trạng thái của voucher có end_date <= thời gian hiện tại
        DB::table('vouchers')
            ->where('end_date', '<=', $currentDateTime)
            ->update(['is_active' => 0]);

        $this->info('Voucher status updated successfully.');
    }
}
