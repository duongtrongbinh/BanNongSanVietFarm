<?php

namespace App\Jobs;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\TransferStatus;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\TransferHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateOrderStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transferHistory;

    public function __construct($transferHistory)
    {
        $this->transferHistory = $transferHistory;
    }

    public function handle(): void
    {
        $order = Order::find($this->transferHistory->order_id);

        if (!$order) {
            Log::info('Order not found', ['order_id' => $this->transferHistory->order_id]);
            return;
        }
        
        // Lấy tất cả các trạng thái transfer hiện tại của đơn hàng
        $transferStatuses = TransferHistory::where('order_id', $order->id)
            ->orderBy('created_at', 'asc')
            ->pluck('status')
            ->toArray();

        $currentOrderStatus = $order->status;
        $newStatus = null;

        if ($currentOrderStatus === OrderStatus::PROCESSING->value) {
            $requiredStatuses = range(TransferStatus::READY_TO_PICK->value, TransferStatus::STORING->value);
            if (array_intersect($requiredStatuses, $transferStatuses) === $requiredStatuses) {
                $newStatus = OrderStatus::SHIPPING->value;
            }
        } elseif ($currentOrderStatus === OrderStatus::SHIPPING->value) {
            $requiredStatuses1 = range(TransferStatus::STORING->value, TransferStatus::MONEY_COLLECT_DELIVERING->value);
            $requiredStatuses2 = [TransferStatus::STORING->value, TransferStatus::DELIVERY_FAIL->value];

            if (array_intersect($requiredStatuses1, $transferStatuses) === $requiredStatuses1 || 
                array_intersect($requiredStatuses2, $transferStatuses) === $requiredStatuses2) {
                $newStatus = OrderStatus::SHIPPED->value;
            }
        } elseif ($currentOrderStatus === OrderStatus::SHIPPED->value) {
            $requiredStatuses1 = [
                TransferStatus::DELIVERY_FAIL->value,
                TransferStatus::MONEY_COLLECT_DELIVERING->value,
                TransferStatus::DELIVERED->value
            ];

            $requiredStatuses2 = [
                TransferStatus::MONEY_COLLECT_DELIVERING->value,
                TransferStatus::DELIVERED->value
            ];

            if (($failIndex = array_search(TransferStatus::DELIVERY_FAIL->value, $transferStatuses)) !== false) {
                $remainingStatuses = array_slice($transferStatuses, $failIndex);
                if (array_intersect($requiredStatuses2, $remainingStatuses) === $requiredStatuses2) {
                    $newStatus = OrderStatus::DELIVERED->value;
                }
            }
            if (array_intersect($requiredStatuses2, $transferStatuses) === $requiredStatuses2) {
                $newStatus = OrderStatus::DELIVERED->value;
            } elseif (in_array(TransferStatus::WAITING_TO_RETURN->value, $transferStatuses)) {
                $newStatus = OrderStatus::RETURNED->value;
            }
        }
        
        if ($newStatus && $newStatus !== $currentOrderStatus) {
            $order->status = $newStatus;

            if ($newStatus == OrderStatus::DELIVERED->value) {
                $order->payment_status = 1;
            }

            $order->save();

            OrderHistory::create([
                'order_id' => $order->id,
                'status' => $newStatus,
            ]);
        }
    }
}