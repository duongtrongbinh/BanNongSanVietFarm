<?php

namespace App\Jobs;

use App\Enums\OrderStatus;
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
        $newStatus = '';

        switch ($currentOrderStatus) {
            case OrderStatus::PROCESSING->value:
                $requiredStatuses = range(TransferStatus::READY_TO_PICK->value, TransferStatus::STORING->value);
                if (empty(array_diff($requiredStatuses, $transferStatuses))) {
                    $newStatus = OrderStatus::SHIPPING->value;
                }
                break;

            case OrderStatus::SHIPPING->value:
                $requiredStatuses1  = range(TransferStatus::STORING->value, TransferStatus::MONEY_COLLECT_DELIVERING->value);
                $requiredStatuses2 = [TransferStatus::STORING->value, TransferStatus::DELIVERY_FAIL->value];

                // Kiểm tra xem transferStatuses có đủ các trạng thái trong $requiredStatuses1 không
                $hasRequiredStatuses1 = empty(array_diff($requiredStatuses1, $transferStatuses));
                // Kiểm tra xem transferStatuses có đủ các trạng thái trong $requiredStatuses2 không
                $hasRequiredStatuses2 = empty(array_diff($requiredStatuses2, $transferStatuses));

                if ($hasRequiredStatuses1 || $hasRequiredStatuses2) {
                    $newStatus = OrderStatus::SHIPPED->value;
                }
                break;

            case OrderStatus::SHIPPED->value:
                $requiredStatuses1 = [
                    TransferStatus::DELIVERY_FAIL->value,
                    TransferStatus::MONEY_COLLECT_DELIVERING->value,
                    TransferStatus::DELIVERED->value
                ];

                $requiredStatuses2 = [
                    TransferStatus::MONEY_COLLECT_DELIVERING->value,
                    TransferStatus::DELIVERED->value
                ];

                $hasRequiredStatuses1 = false;

                if (($failIndex = array_search(TransferStatus::DELIVERY_FAIL->value, $transferStatuses)) !== false) {
                    $remainingStatuses = array_slice($transferStatuses, $failIndex);
                    $hasRequiredStatuses1 = array_intersect($requiredStatuses2, $remainingStatuses) === $requiredStatuses2;
                }
                $hasRequiredStatuses2 = array_intersect($requiredStatuses2, $transferStatuses) === $requiredStatuses2;
                $hasRequiredStatuses3 = in_array(TransferStatus::WAITING_TO_RETURN->value, $transferStatuses);

                if ($hasRequiredStatuses1) {
                    $newStatus = OrderStatus::DELIVERED->value;
                } elseif ($hasRequiredStatuses2) {
                    $newStatus = OrderStatus::DELIVERED->value;
                } elseif ($hasRequiredStatuses3) {
                    $newStatus = OrderStatus::RETURNED->value;
                }
                break;
        }
        
        if ($newStatus) {
            $order->status = $newStatus;
            $order->save();

            OrderHistory::create([
                'order_id' => $order->id,
                'status' => $newStatus,
            ]);
        }
    }
}
