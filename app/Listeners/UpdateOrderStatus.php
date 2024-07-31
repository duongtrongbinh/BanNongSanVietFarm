<?php

namespace App\Listeners;

use App\Jobs\UpdateOrderStatusJob;

class UpdateOrderStatus
{
    public function handle(object $event): void
    {
        $transferHistory = $event->transferHistory;

        // Dispatch job vào queue
        UpdateOrderStatusJob::dispatch($transferHistory->order_id, $transferHistory->status);
    }
}