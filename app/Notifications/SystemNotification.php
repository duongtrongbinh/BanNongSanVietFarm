<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
class SystemNotification extends Notification
{
    use Queueable;

    protected  $order;
    public function __construct($order)
    {
       $this->order = $order;

    }
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Bạn có 1 đơn hàng mới từ ',
            'type' => 'Đơn hàng mới',
            'customer' => $this->order->user->name,
            'order_id' =>  $this->order->id,
            'order_code' =>  $this->order->order_code,
        ];
    }


}
