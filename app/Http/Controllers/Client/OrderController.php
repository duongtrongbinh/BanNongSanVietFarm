<?php

namespace App\Http\Controllers\Client;

use App\Enums\OrderStatus;
use App\Enums\TransferStatus;
use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderHistoryRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\VoucherRepository;
use App\Models\Order;
use App\Models\Provinces;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public $orderRepository;
    public $orderHistoryRepository;
    public $voucherRepository;

    public function __construct(OrderRepository $orderRepository, OrderHistoryRepository $orderHistoryRepository, VoucherRepository $voucherRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderHistoryRepository = $orderHistoryRepository;
        $this->voucherRepository = $voucherRepository;
    }


    public function fetchOrders(Request $request)
    {
        // Xác định trạng thái (nếu có)
        $status = $request->input('status');
        $search = $request->input('search');

        $statusData = [
            OrderStatus::PENDING->value => [
                'label' => 'Đang chờ xử lý', 
                'badgeClass' => 'badge bg-warning text-white text-uppercase'
            ],
            OrderStatus::PROCESSING->value => [
                'label' => 'Đang xử lý', 
                'badgeClass' => 'badge bg-secondary text-white text-uppercase'
            ],
            OrderStatus::SHIPPING->value => [
                'label' => 'Vận chuyển', 
                'badgeClass' => 'badge bg-info text-white text-uppercase'
            ],
            OrderStatus::SHIPPED->value => [
                'label' => 'Giao hàng', 
                'badgeClass' => 'badge bg-success text-white text-uppercase'
            ],
            OrderStatus::DELIVERED->value => [
                'label' => 'Đã nhận hàng', 
                'badgeClass' => 'badge bg-primary text-white text-uppercase'
            ],
            OrderStatus::COMPLETED->value => [
                'label' => 'Hoàn thành', 
                'badgeClass' => 'badge bg-primary text-white text-uppercase'
            ],
            OrderStatus::CANCELLED->value => [
                'label' => 'Đã hủy', 
                'badgeClass' => 'badge bg-danger text-white text-uppercase'
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
        if(!session('cart')){
            return redirect()->route('home');
        }
        $provinces = Provinces::query()->get();
        $vouchers = $this->voucherRepository->getVoucherActive();
        $total = 0;
        foreach(session()->get('cart') as $items){
            $total += $items['price'] * $items['quantity'];
        }

        return view('client.check-out',compact(['vouchers','provinces','total']));
    }

    public function detail(Order $order)
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
                    $transferStatusRange = range(TransferStatus::READY_TO_PICK->value, TransferStatus::PICKED->value);
                    $showTransferHistory = true;
                    break;
                case OrderStatus::SHIPPING->value:
                    $transferStatusRange = range(TransferStatus::STORING->value, TransferStatus::DELIVERING->value);
                    $showTransferHistory = true;
                    break;
                case OrderStatus::SHIPPED->value:
                    $transferStatusRange = [
                        TransferStatus::MONEY_COLLECT_DELIVERING->value, 
                        TransferStatus::DELIVERED->value, 
                        TransferStatus::DELIVERY_FAIL->value
                    ];
                    $showTransferHistory = true;
                    break;
                case OrderStatus::RETURNED->value:
                    $transferStatusRange = [
                        TransferStatus::WAITING_TO_RETURN->value, 
                        TransferStatus::RETURN->value, 
                        TransferStatus::RETURN_TRANSPORTING->value, 
                        TransferStatus::RETURN_SORTING->value, 
                        TransferStatus::RETURNING->value, 
                        TransferStatus::RETURN_FAIL->value, 
                        TransferStatus::RETURNED->value
                    ];
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

        return view('client.order-detail', compact('order', 'statusData', 'orderHistoriesWithTransfers'));
    }

    public function success(string $code)
    {
        $order = Order::with(['order_details.product.category', 'order_details.product.brand'])->where('order_code', $code)->first();
        
        return view('thankyou', compact('order'));
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

    public function checking(Request $request) 
    {
        $order_code = $request->query('order_code');
        $order = Order::with(['order_details.product.category', 'order_details.product.brand'])->where('order_code', $order_code)->first();

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
                    $transferStatusRange = range(TransferStatus::READY_TO_PICK->value, TransferStatus::PICKED->value);
                    $showTransferHistory = true;
                    break;
                case OrderStatus::SHIPPING->value:
                    $transferStatusRange = range(TransferStatus::STORING->value, TransferStatus::DELIVERING->value);
                    $showTransferHistory = true;
                    break;
                case OrderStatus::SHIPPED->value:
                    $transferStatusRange = [
                        TransferStatus::MONEY_COLLECT_DELIVERING->value, 
                        TransferStatus::DELIVERED->value, 
                        TransferStatus::DELIVERY_FAIL->value
                    ];
                    $showTransferHistory = true;
                    break;
                case OrderStatus::RETURNED->value:
                    $transferStatusRange = [
                        TransferStatus::WAITING_TO_RETURN->value, 
                        TransferStatus::RETURN->value, 
                        TransferStatus::RETURN_TRANSPORTING->value, 
                        TransferStatus::RETURN_SORTING->value, 
                        TransferStatus::RETURNING->value, 
                        TransferStatus::RETURN_FAIL->value, 
                        TransferStatus::RETURNED->value
                    ];
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

        return view('client.order-detail', compact('order', 'statusData', 'orderHistoriesWithTransfers'));
    }
}
