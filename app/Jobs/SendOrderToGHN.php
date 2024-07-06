<?php

// app/Jobs/SendOrderToGHN.php
namespace App\Jobs;

use App\Http\Services\GHNTranform;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Enums\OrderStatus;

class SendOrderToGHN implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Số lần thử lại tối đa
    public $retryAfter = 300; // 5 phút

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(GHNTranform $ghnOrderService)
    {
        try {
            // Lấy dữ liệu đơn hàng từ storage
            $orderData = $ghnOrderService->getOrderDataFromStorage($this->order->order_code);

            // Gửi dữ liệu đến GHN
            $response = $ghnOrderService->sendToGHN($orderData);

            // Kiểm tra phản hồi từ GHN
            if ($response->successful()) {
                $this->order->status = OrderStatus::READY_TO_PICK;
                $this->order->save();

                // Xóa dữ liệu khỏi storage sau khi gửi thành công
                $ghnOrderService->deleteOrderDataFromStorage($this->order->order_code);
            } else {
                throw new \Exception('Failed to send order to GHN');
            }
        } catch (\Exception $e) {
            Log::error('Error sending order to GHN: ' . $e->getMessage());
            $this->order->status = OrderStatus::RETRY;
            $this->order->save();
            $this->release($this->retryAfter);
        }
    }


}