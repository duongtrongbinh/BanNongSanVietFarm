<?php

namespace App\Http\Controllers\Client;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Repositories\VoucherRepository;
use App\Models\Order;
use App\Models\Provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public $voucherRepository;

    const token = '29ee235a-2fa2-11ef-8e53-0a00184fe694';
    const url = 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province';

    public function __construct(VoucherRepository $voucherRepository)
    {
            $this->voucherRepository = $voucherRepository;
    }

    public function index()
    {
        return view('client.order');
    }

    public function fetchOrders(Request $request)
    {
        // Xác định trạng thái (nếu có)
        $status = $request->input('status');
        $search = $request->input('search');

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

        $query = Order::with('order_details.product.category')
                    ->where('user_id', Auth::user()->id);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where('order_code', 'LIKE', "%{$search}%");
        }

        // Thực hiện phân trang
        $orders = $query->latest('id')->paginate(5);

        // Trả về dữ liệu dưới dạng JSON
        return response()->json([
            'orders' => $orders,
            'statusData' => $statusData
        ]);
    }

    public function orderCheckOut()
    {
        $provinces = Provinces::query()->get();
        $vouchers = $this->voucherRepository->getVoucherActive();
        return view('client.check-out',compact(['vouchers','provinces']));
    }

    public function detail(Order $order)
    {
        $order = Order::with(['user', 'order_details', 'order_histories'])->find($order->id);
        return view('client.order-detail', compact('order'));
    }

    public function success(string $code)
    {
        $order = Order::with('order_details')->where('order_code',$code)->first();
        return view('thankyou', compact('order'));
    }
}