<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\VoucherRepository;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    const PATH_VIEW = 'admin.orders.';
    public $orderRepository;
    public $voucherRepository;

    public function __construct(OrderRepository $orderRepository, VoucherRepository $voucherRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->voucherRepository = $voucherRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->getLatestAllWithRelations(['user', 'order_details']);
        $delivereds = Order::where('status', '3')->latest('id')->get();
        $pickups = Order::where('status', '2')->latest('id')->get();
        $returns = Order::where('status', '4')->latest('id')->get();
        $cancelleds = Order::where('status', '5')->latest('id')->get();

        return view(self::PATH_VIEW . __FUNCTION__, compact('orders', 'delivereds', 'pickups', 'returns', 'cancelleds'));
    }

    public function show(Order $order)
    {
        $order = Order::with(['user', 'order_details'])->find($order->id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('order'));

    }
}
