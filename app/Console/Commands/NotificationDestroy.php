<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NotificationDestroy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification-destroy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete notifications older than 3 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Lấy thời gian hiện tại
        $now = Carbon::now();

        // Lấy thời gian 3 ngày trước
        $threeDaysAgo = $now->subDays(3);

        // Tìm và xóa các thông báo có read_at đúng bằng thời điểm 3 ngày trước
        $notifications = DB::table('notifications')
            ->where('read_at', '<=', $threeDaysAgo)
            ->delete();

        // Thông báo số lượng thông báo đã bị xóa
        $this->info("Deleted {$notifications} notifications that were read exactly 3 days ago.");
    }
}
