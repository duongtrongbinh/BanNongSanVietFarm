<?php

namespace App\Http\Controllers\Admin;

use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderHistoryRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\VoucherRepository;
use App\Models\Order;
use App\Models\OrderHistory;
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
            return 'VNPAY';
        })
        ->addColumn('status', function ($order) {
            $statusData = [
                0 => ['label' => 'Chờ xử lý', 'badgeClass' => 'badge bg-warning-subtle text-warning text-uppercase'],
                1 => ['label' => 'Đang chuẩn bị', 'badgeClass' => 'badge bg-secondary-subtle text-secondary text-uppercase'],
                2 => ['label' => 'Chờ thanh toán', 'badgeClass' => 'badge bg-info-subtle text-info text-uppercase'],
                3 => ['label' => 'Thanh toán thành công', 'badgeClass' => 'badge bg-success-subtle text-success text-uppercase'],
                4 => ['label' => 'Sẵn sàng lấy hàng', 'badgeClass' => 'badge bg-primary-subtle text-primary text-uppercase'],
                21 => ['label' => 'Đơn hàng đã huỷ', 'badgeClass' => 'badge bg-danger-subtle text-danger text-uppercase'],
            ];
            
            $status = $statusData[$order->status] ?? ['label' => 'Không xác định', 'badgeClass' => 'badge bg-danger-subtle text-danger text-uppercase'];
    
            return '<span class="'.$status['badgeClass'].'">'.$status['label'].'</span>';
        })
        ->addColumn('action', function($order) {
            return '<ul class="list-inline hstack gap-2 mb-0">
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Chi tiết">
                            <a href="'.route('orders.show', $order->id).'" class="text-primary d-inline-block">
                                <i class="ri-eye-fill fs-16"></i>
                            </a>
                        </li>
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Chỉnh sửa">
                            <a href="'.route('orders.edit', $order->id).'" class="text-primary d-inline-block">
                                <i class="ri-pencil-fill fs-16"></i>
                            </a>
                        </li>
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Xóa">
                            <a data-url="'.route('orders.delete', $order->id).'" class="text-danger d-inline-block deleteProduct">
                                <i class="ri-delete-bin-5-fill fs-16"></i>
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

    public function getPrepare()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 1)->latest('id')->get();

        return self::getData($orders);
    }

    public function getPendingPayment()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 2)->latest('id')->get();

        return self::getData($orders);
    }

    public function getSuccessPayment()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 3)->latest('id')->get();

        return self::getData($orders);
    }

    public function getReadyToPick()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 4)->latest('id')->get();

        return self::getData($orders);
    }

    public function getCancelled()
    {
        $orders = Order::with(['user', 'order_details'])->where('status', 21)->latest('id')->get();

        return self::getData($orders);
    }

    public function show(Order $order)
    {
        $order = Order::with(['user', 'order_details', 'order_histories'])->find($order->id);

        $statuses = $order->order_histories->pluck('status')->toArray();
        if (count(array_intersect([0, 1, 2, 3], $statuses)) == 4) {
            $statusData = [
                'label' => 'Thanh toán thành công',
                'badgeClass' => 'badge bg-success-subtle text-success text-uppercase'
            ];
        } else if (count(array_intersect([0, 1, 2], $statuses)) == 3) {
            $statusData = [
                'label' => 'Chờ thanh toán',
                'badgeClass' => 'badge bg-info-subtle text-info text-uppercase'
            ];
        } else {
            $statusData = [
                'label' => 'Chờ xử lý',
                'badgeClass' => 'badge bg-warning-subtle text-warning text-uppercase'
            ];
        }

        return view(self::PATH_VIEW . __FUNCTION__, compact('order', 'statusData'));
    }

    public function edit(Order $order)
    {
        $order = Order::with(['user', 'order_details'])->find($order->id);

        $statuses = $order->order_histories->pluck('status')->toArray();
        if (count(array_intersect([0, 1, 2, 3], $statuses)) == 4) {
            $statusData = [
                'label' => 'Thanh toán thành công',
                'badgeClass' => 'badge bg-success-subtle text-success text-uppercase'
            ];
        } else if (count(array_intersect([0, 1, 2], $statuses)) == 3) {
            $statusData = [
                'label' => 'Chờ thanh toán',
                'badgeClass' => 'badge bg-info-subtle text-info text-uppercase'
            ];
        } else {
            $statusData = [
                'label' => 'Chờ xử lý',
                'badgeClass' => 'badge bg-warning-subtle text-warning text-uppercase'
            ];
        }

        return view(self::PATH_VIEW . __FUNCTION__, compact('order', 'statusData'));
    }

    public function update(Order $order)
    {
        switch ($order->status) {
            case 0:
                $status = OrderStatus::PREPARE->value;
                break;
            case 1:
                $status = OrderStatus::PENDING_PAYMENT->value;
                break;
            case 2:
                $status = OrderStatus::SUCCESS_PAYMENT->value;
                break;
            case 3:
                $status = OrderStatus::READY_TO_PICK->value;
                break;
            case 4:
                break;
        }

        $exists = OrderHistory::where('order_id', $order->id)
            ->where('status', $status)
            ->exists();

        if ($exists) {
            return response()
                ->json(['message' => 'Trạng thái đã tồn tại trong lịch sử đơn hàng!'], 400);
        }

        $currentStatus = $order->status;
        if ($currentStatus < $status) {
            $order->update(['status' => $status]);

            $data = [
                'order_id' => $order->id, 
                'status' => $order->status, 
                'warehouse' => 'Bưu cục'
            ];

            $this->orderHistoryRepository->create($data);
        }

        return redirect()
            ->back()
            ->with('updated', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    public function updateStatus(Request $request)
    {
        $orderIdsString = $request->input('order_ids');
        $orderIds = json_decode($orderIdsString, true);

        $orders = Order::whereIn('id', $orderIds)->get();

        $status = '';

        foreach ($orders as $order) {
            switch ($order->status) {
                case 0:
                    $status = OrderStatus::PREPARE->value;
                    break;
                case 1:
                    $status = OrderStatus::PENDING_PAYMENT->value;
                    break;
                case 2:
                    $status = OrderStatus::SUCCESS_PAYMENT->value;
                    break;
                case 3:
                    $status = OrderStatus::READY_TO_PICK->value;
                    break;
                case 4:
                    continue 2;
            }

            $exists = OrderHistory::where('order_id', $order->id)
                        ->where('status', $status)
                        ->exists();

            if ($exists) {
                return response()
                    ->json(['message' => 'Trạng thái đã tồn tại trong lịch sử đơn hàng!'], 400);
            }

            $currentStatus = $order->status;
            if ($currentStatus < $status) {
                $order->update(['status' => $status]);

                $data = [
                    'order_id' => $order->id, 
                    'status' => $order->status, 
                    'warehouse' => 'Bưu cục'
                ];

                $this->orderHistoryRepository->create($data);
            }
        }

        return response()
            ->json(['message' => 'Cập nhật trạng thái đơn hàng thành công!'], 200);
    }

    public function cancel(Order $order)
    {
        $order = $this->orderRepository->update($order->id, ['status' => OrderStatus::CANCELLED->value]);
        $data = [
            'order_id' => $order->id, 
            'status' => OrderStatus::CANCELLED, 
            'warehouse' => 'Bưu cục'
        ];
        $this->orderHistoryRepository->create($data);

        return redirect()
            ->back()
            ->with('updated', 'Hủy đơn hàng thành công!');
    }

    public function delete(Order $order)
    {
        $this->orderRepository->delete($order->id);

        return response()->json(true);
    }
}