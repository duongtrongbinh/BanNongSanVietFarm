<?php

namespace App\Listeners;

use App\Enum\OrderStatus;
use App\Notifications\OrderFailedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
            $order = unserialize($event->job->payload()['data']['command'])->order;
            $user = $order->user;

            $order->status = OrderStatus::PENDING;
            $order->save();

            $user->notify(new OrderFailedNotification($order));
        }
    }
}