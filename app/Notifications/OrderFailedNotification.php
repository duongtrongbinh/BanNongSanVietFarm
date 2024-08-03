<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderFailedNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Đơn hàng của bạn cần được cập nhật')
                    ->line('Chúng tôi không thể kết nối với đơn vị vận chuyển để cập nhật đơn hàng của bạn.')
                    ->action('Cập nhật đơn hàng', route('orders.edit', ['order' => $this->order->id, 'return' => true]))
                    ->line('Vui lòng cập nhật đơn hàng bằng tay.');
    }
}