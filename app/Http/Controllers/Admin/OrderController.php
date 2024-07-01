<?php

namespace App\Http\Controllers\Admin;

use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderHistoryRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\VoucherRepository;
use App\Http\Requests\OrderUpdateStatusRequest;
use App\Models\Order;

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
        $orders = $this->orderRepository->getLatestAllWithRelations(['user', 'order_details']);

        return view(self::PATH_VIEW . __FUNCTION__, compact('orders'));
    }

    public function show(Order $order)
    {
        $order = Order::with(['user', 'order_details', 'order_histories'])->find($order->id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('order'));
    }

    public function edit(Order $order)
    {
        $order = Order::with(['user', 'order_details'])->find($order->id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('order'));
    }

    public function update(OrderUpdateStatusRequest $request, Order $order)
    {
        $validatedData = $request->validated();

        $order = $this->orderRepository->update($order->id, $validatedData);
        $data = [
            'order_id' => $order->id, 
            'status' => $order->status, 
            'warehouse' => 'Bưu cục'
        ];
        $this->orderHistoryRepository->create($data);

        return redirect()->back()->with('status', 'Success');
    }

    public function cancel(Order $order)
    {
        $order = $this->orderRepository->update($order->id, ['status' => OrderStatus::CANCELLED]);
        $data = [
            'order_id' => $order->id, 
            'status' => OrderStatus::CANCELLED, 
            'warehouse' => 'Bưu cục'
        ];
        $this->orderHistoryRepository->create($data);

        return redirect()->back()->with('status', 'Success');
    }
}