<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\TransferStatus;
use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderHistoryRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\VoucherRepository;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\TransferHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    const PATH_VIEW = 'admin.orders.';
    public $orderRepository;
    public $orderHistoryRepository;
    public $voucherRepository;

    public function __construct(OrderRepository $orderRepository, OrderHistoryRepository $orderHistoryRepository, VoucherRepository $voucherRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderHistoryRepository = $orderHistoryRepository;
        $this->voucherRepository = $voucherRepository;
    }

    public function index()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    public static function getData($orders)
    {   
        $stt = 1;

        return DataTables::of($orders)
        ->addColumn('checked', function ($order) {
            return '<input type="checkbox" class="selectCheckbox" value="'.$order->id.'">';
        })
        ->addColumn('stt', function ($order) use (&$stt) {
            return $stt++;
        })
        ->addColumn('order_code', function ($order) {
            return $order->order_code;
        })
        ->addColumn('user_name', function ($order) {
            return $order->user->name;
        })
        ->addColumn('order_details', function ($order) {
            return count($order->order_details);
        })
        ->addColumn('created_at', function ($order) {
            return date('H:i:s d/m/Y', strtotime($order->created_at));
        })
        ->addColumn('after_total_amount', function ($order) {
            return number_format($order->after_total_amount) . ' VNĐ';
        })
        ->addColumn('payment', function ($order) {
            return $order->payment_method == 0 ? 'VNPAY' : 'COD';
        })
        ->addColumn('status', function ($order) {
            $statusData = [
                OrderStatus::PENDING->value => [
                    'label' => 'Đang chờ xử lý', 
                    'badgeClass' => 'badge bg-warning-subtle text-warning text-uppercase'
                ],
                OrderStatus::PROCESSING->value => [
                    'label' => 'Đang xử lý', 
                    'badgeClass' => 'badge bg-secondary-subtle text-secondary text-uppercase'
                ],
                OrderStatus::SHIPPING->value => [
                    'label' => 'Vận chuyển', 
                    'badgeClass' => 'badge bg-info-subtle text-info text-uppercase'
                ],
                OrderStatus::SHIPPED->value => [
                    'label' => 'Giao hàng', 
                    'badgeClass' => 'badge bg-success-subtle text-success text-uppercase'
                ],
                OrderStatus::DELIVERED->value => [
                    'label' => 'Đã nhận hàng', 
                    'badgeClass' => 'badge bg-primary-subtle text-primary text-uppercase'
                ],
                OrderStatus::COMPLETED->value => [
                    'label' => 'Hoàn thành', 
                    'badgeClass' => 'badge bg-primary text-white text-uppercase'
                ],
                OrderStatus::CANCELLED->value => [
                    'label' => 'Đã hủy', 
                    'badgeClass' => 'badge bg-danger-subtle text-danger text-uppercase'
                ],
                OrderStatus::RETURNED->value => [
                    'label' => 'Trả hàng/Hoàn tiền', 
                    'badgeClass' => 'badge bg-danger text-white text-uppercase'
                ],
            ];
            
            $status = $statusData[$order->status] ?? ['label' => 'Không xác định', 'badgeClass' => 'badge bg-danger-subtle text-danger text-uppercase'];
    
            return '<span class="'.$status['badgeClass'].'">'.$status['label'].'</span>';
        })
        ->addColumn('action', function($order) {
            return '<ul class="list-inline hstack gap-2 mb-0">
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Chỉnh sửa">
                            <a href="'.route('orders.edit', $order->id).'" class="text-primary d-inline-block">
                                <i class="ri-pencil-fill fs-16"></i>
                            </a>
                        </li>
                    </ul>';
        })
        ->rawColumns(['checked', 'after_total_amount', 'payment', 'status', 'action'])
        ->make(true);
    }

    public function getAll()
    {
        $orders = $this->orderRepository->getLatestAllWithRelations(['user', 'order_details']);

        return self::getData($orders);
    }

    public function getPending()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 0)->latest('id')->get();

        return self::getData($orders);
    }

    public function getProcessing()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 1)->latest('id')->get();

        return self::getData($orders);
    }

    public function getShipping()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 2)->latest('id')->get();

        return self::getData($orders);
    }

    public function getShipped()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 3)->latest('id')->get();

        return self::getData($orders);
    }

    public function getDelivered()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 4)->latest('id')->get();

        return self::getData($orders);
    }

    public function getCompleted()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 5)->latest('id')->get();

        return self::getData($orders);
    }

    public function getCancelled()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 6)->latest('id')->get();

        return self::getData($orders);
    }

    public function getReturned()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 7)->latest('id')->get();

        return self::getData($orders);
    }

    private function isValidStatusTransition(Order $order, int $newStatus): bool
    {
        $currentStatus = $order->status;

        // Transition from 0 to 1 requires no condition
        if ($currentStatus === OrderStatus::PENDING->value && $newStatus === OrderStatus::PROCESSING->value) {
            return true;
        }

        // Transition from 1 to 2 requires checking order_histories for statuses 0 to 4
        if ($currentStatus === OrderStatus::PROCESSING->value && $newStatus === OrderStatus::SHIPPING->value) {
            $validStatuses = range(TransferStatus::READY_TO_PICK->value, TransferStatus::STORING->value);

            $historyCount = TransferHistory::where('order_id', $order->id)
                ->whereIn('status', $validStatuses)
                ->count();

            if ($historyCount === count($validStatuses)) {
                return true;
            } else {
                return false;
            }
        }

        // Transition from 2 to 3 requires checking order_histories for statuses 0 to 8
        if ($currentStatus === OrderStatus::SHIPPING->value && $newStatus === OrderStatus::SHIPPED->value) {
            $validStatuses = range(TransferStatus::READY_TO_PICK->value, TransferStatus::DELIVERING->value);

            $historyCount = TransferHistory::where('order_id', $order->id)
                ->whereIn('status', $validStatuses)
                ->count();

            if ($historyCount === count($validStatuses)) {
                return true;
            } else {
                return false;
            }
        }

        // Transition from 3 to 4 requires checking order_histories for statuses 0 to 10
        if ($currentStatus === OrderStatus::SHIPPED->value && $newStatus === OrderStatus::DELIVERED->value) {
            $validStatuses = range(TransferStatus::READY_TO_PICK->value, TransferStatus::DELIVERED->value);

            $validCount = TransferHistory::where('order_id', $order->id)
                ->whereIn('status', $validStatuses)
                ->count();

            if ($validCount === count($validStatuses)) {
                return true;
            } else {
                return false;
            }
        }

        // Transition from 4 to 5 requires checking order_histories for statuses 0 to 10 and not having statuses 11 or higher
        if ($currentStatus === OrderStatus::DELIVERED->value && $newStatus === OrderStatus::COMPLETED->value) {
            $validStatuses = range(TransferStatus::READY_TO_PICK->value, TransferStatus::DELIVERED->value);
            $invalidStatuses = range(TransferStatus::WAITING_TO_RETURN->value, TransferStatus::CANCEL->value);

            $validCount = TransferHistory::where('order_id', $order->id)
                ->whereIn('status', $validStatuses)
                ->count();

            $invalidCount = TransferHistory::where('order_id', $order->id)
                ->whereIn('status', $invalidStatuses)
                ->count();

            if ($validCount === count($validStatuses) && $invalidCount === 0) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function edit(Order $order)
    {
        $order = Order::with(['user', 'order_details.product.category', 'order_details.product.brand'])->find($order->id);

        $statuses = $order->transfer_histories->pluck('status')->toArray();

        if ($order->payment_status == 1) {
            $statusData = [
                'label' => 'Thanh toán thành công',
                'badgeClass' => 'badge bg-success-subtle text-success text-uppercase'
            ];
        } else {
            $statusData = [
                'label' => 'Chờ thanh toán',
                'badgeClass' => 'badge bg-info-subtle text-info text-uppercase'
            ];
        }

        $orderHistoriesWithTransfers = $order->order_histories->map(function($orderHistory) use ($order) {
            $transferStatusRange = [];
            $showTransferHistory = false;
            switch ($orderHistory->status) {
                case OrderStatus::PROCESSING->value:
                    $transferStatusRange = range(0, 4);
                    $showTransferHistory = true;
                    break;
                case OrderStatus::SHIPPING->value:
                    $transferStatusRange = range(5, 8);
                    $showTransferHistory = true;
                    break;
                case OrderStatus::SHIPPED->value:
                    $transferStatusRange = [9, 10, 11];
                    $showTransferHistory = true;
                    break;
                case OrderStatus::RETURNED->value:
                    $transferStatusRange = [12, 13, 14, 15, 16, 17, 18];
                    $showTransferHistory = true;
                    break;
                default:
                    $transferStatusRange = [];
                    $showTransferHistory = false;
            }
    
            $transferHistories = $order->transfer_histories->filter(function($transferHistory) use ($transferStatusRange) {
                return in_array($transferHistory->status, $transferStatusRange);
            })->sortByDesc('created_at');

            $formattedOrderHistory = mb_convert_case(Carbon::parse($orderHistory->created_at)->translatedFormat('H:i:s l, d/m/Y'), MB_CASE_TITLE, "UTF-8");
            
            return [
                'orderHistory' => $orderHistory,
                'transferHistories' => $transferHistories,
                'formattedOrderHistory' => $formattedOrderHistory,
                'showTransferHistory' => $showTransferHistory
            ];
        })->sortByDesc(function($history) {
            return $history['orderHistory']->created_at;
        });
         
        return view(self::PATH_VIEW . __FUNCTION__, compact('order', 'statusData', 'orderHistoriesWithTransfers'));
    }

    public function update(Order $order)
    {
        $newStatus = '';
        $message = '';

        switch ($order->status) {
            case OrderStatus::PENDING->value:
                $newStatus = OrderStatus::PROCESSING->value;
                $message = 'Cập nhật sang trạng thái đang xử lý thành công!';
                break;
            case OrderStatus::PROCESSING->value:
                $newStatus = OrderStatus::SHIPPING->value;
                $message = 'Cập nhật sang trạng thái vận chuyển thành công!';
                break;
            case OrderStatus::SHIPPING->value:
                $newStatus = OrderStatus::SHIPPED->value;
                $message = 'Cập nhật sang trạng thái giao hàng thành công!';
                break;
            case OrderStatus::SHIPPED->value:
                $newStatus = OrderStatus::DELIVERED->value;
                $message = 'Cập nhật sang trạng thái đã nhận hàng thành công!';
                break;
            case OrderStatus::DELIVERED->value:
                $newStatus = OrderStatus::COMPLETED->value;
                $message = 'Cập nhật sang trạng thái hoàn thành thành công!';
                break;
            case OrderStatus::COMPLETED->value:
                $message = 'Đơn hàng đã hoàn thành, không thể cập nhật trạng thái!';
                return redirect()->back()->with('error', $message);
            case OrderStatus::CANCELLED->value:
                $message = 'Đơn hàng đã bị hủy, không thể cập nhật trạng thái!';
                return redirect()->back()->with('error', $message);
        }

        if ($this->isValidStatusTransition($order, $newStatus)) {
            $order->update(['status' => $newStatus]);

            OrderHistory::create([
                'order_id' => $order->id,
                'status' => $newStatus,
            ]);

            return redirect()
                ->back()
                ->with('updated', $message);
        } else {
            return redirect()
                ->back()
                ->with('error', 'Đơn hàng không đủ điều kiện để cập nhật trạng thái!');
        }
    }

    public function updateStatus(Request $request)
    {
        $orderIdsString = $request->input('order_ids');
        $orderIds = json_decode($orderIdsString, true);

        $orders = Order::whereIn('id', $orderIds)->get();

        $firstOrder = $orders->first();
        $sameStatus = $orders->every(function ($order) use ($firstOrder) {
            return $order->status === $firstOrder->status;
        });

        if (!$sameStatus) {
            return response()
                ->json(['message' => 'Không thể cập nhật hàng loạt vì các đơn hàng có trạng thái khác nhau.'], 400);
        }

        $newStatus = '';
        $message = '';

        switch ($firstOrder->status) {
            case OrderStatus::PENDING->value:
                $newStatus = OrderStatus::PROCESSING->value;
                $message = 'Cập nhật sang trạng thái đang xử lý thành công!';
                break;
            case OrderStatus::PROCESSING->value:
                $newStatus = OrderStatus::SHIPPING->value;
                $message = 'Cập nhật sang trạng thái vận chuyển thành công!';
                break;
            case OrderStatus::SHIPPING->value:
                $newStatus = OrderStatus::SHIPPED->value;
                $message = 'Cập nhật sang trạng thái giao hàng thành công!';
                break;
            case OrderStatus::SHIPPED->value:
                $newStatus = OrderStatus::DELIVERED->value;
                $message = 'Cập nhật sang trạng thái đã nhận hàng thành công!';
                break;
            case OrderStatus::DELIVERED->value:
                $newStatus = OrderStatus::COMPLETED->value;
                $message = 'Cập nhật sang trạng thái hoàn thành thành công!';
                break;
            case OrderStatus::COMPLETED->value:
                $message = 'Đơn hàng đã hoàn thành, không thể cập nhật trạng thái!';
                return response()->json(['message' => $message], 400);
            case OrderStatus::CANCELLED->value:
                $message = 'Đơn hàng đã bị hủy, không thể cập nhật trạng thái!';
                return response()->json(['message' => $message], 400);
        }

        foreach ($orders as $order) {
            if ($this->isValidStatusTransition($order, $newStatus)) {
                $order->update(['status' => $newStatus]);

                OrderHistory::create([
                    'order_id' => $order->id,
                    'status' => $newStatus,
                ]);
            }else {
                $message = 'Đơn hàng không đủ điều kiện để cập nhật trạng thái!';

                return response()
                    ->json(['message' => $message], 400);
            }
        }

        return response()
            ->json(['message' => $message], 200);
    }

    public function cancel(Order $order)
    {
        if ($order->status < OrderStatus::PROCESSING->value) {
            // Cập nhật trạng thái của order
            $order = $this->orderRepository->update($order->id, ['status' => OrderStatus::CANCELLED->value]);

            // Thêm bản ghi vào order_histories
            $data = [
                'order_id' => $order->id, 
                'status' => OrderStatus::CANCELLED->value,
            ];
            $this->orderHistoryRepository->create($data);

            return redirect()
                ->back()
                ->with('updated', 'Hủy đơn hàng thành công!');
        } else {
            // Nếu không, trả về thông báo lỗi
            return redirect()
                ->back()
                ->with('error', 'Không thể hủy đơn hàng vì đã qua trạng thái đang chờ xử lý!');
        }
    }
}