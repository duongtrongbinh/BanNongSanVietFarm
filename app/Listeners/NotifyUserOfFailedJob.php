<?php

namespace App\Listeners;

use App\Enums\OrderStatus;
use App\Models\OrderHistory;
use App\Notifications\OrderFailedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyUserOfFailedJob
{
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if ($event->job->resolveName() === 'App\Jobs\SendOrderToGHN') {
            $order = unserialize($event->job->payload()['data']['command'])->getOrder();
            $user = $order->user;

            $order_history = OrderHistory::where('order_id', $order->id)->orderBy('created_at', 'desc')->first();

            if ($order_history) {
                $order_history->delete();
            }

            Log::info($order_history);

            $order->status = OrderStatus::PENDING->value;
            $order->save();

            Log::info($order);

            $user->notify(new OrderFailedNotification($order));
        }
    }
}