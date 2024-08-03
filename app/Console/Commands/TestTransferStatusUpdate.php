<?php

namespace App\Console\Commands;

use App\Events\TransferStatusUpdated;
use App\Jobs\UpdateOrderStatusJob;
use App\Models\TransferHistory;
use Illuminate\Console\Command;

class TestTransferStatusUpdate extends Command
{
    protected $signature = 'test:transfer-status-update {orderId} {status}';
    protected $description = 'Test updating transfer status for an order';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $orderId = $this->argument('orderId');
        $status = (int)$this->argument('status');

        // Tạo mới một TransferHistory
        $transferHistory = TransferHistory::create([
            'order_id' => $orderId,
            'status' => $status,
        ]);

        $this->info('Transfer status updated and event triggered.');
    }
}
