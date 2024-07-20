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
use App\Enums\OrderStatus;
use Exception;

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
            Log::info('Order Data:', $orderData);

            // Kiểm tra phản hồi từ GHN
            if ($response->successful()) {
                Log::info('Tạo đơn hàng thành công.');

                // Xóa dữ liệu khỏi storage sau khi gửi thành công
                $ghnOrderService->deleteOrderDataFromStorage($this->order->order_code);
            } else {
                // Log response chi tiết nếu thất bại
                Log::error('Failed to send order to GHN', ['response' => $response->body()]);
                throw new Exception('Failed to send order to GHN: ' . $response->body());
            }
        } catch (Exception $e) {
            Log::error('Error sending order to GHN:', [
                'message' => $e->getMessage(),
                'order_id' => $this->order->id,
                'order_code' => $this->order->order_code,
            ]);
            $this->order->status = OrderStatus::RETRY->value;
            $this->order->save();
            $this->release($this->retryAfter);
        }
    }
    public function getOrder()
        {
            return $this->order;
        }

}