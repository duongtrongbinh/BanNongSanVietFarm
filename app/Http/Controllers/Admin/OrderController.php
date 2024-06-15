<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\VoucherRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $orderRepository;

    public $voucherRepository;

    public function __construct(OrderRepository $orderRepository, VoucherRepository $voucherRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->voucherRepository = $voucherRepository;
    }

    public function index()
    {
        $params = [];
        $orders = $this->orderRepository->getPaginate($params);
        return view('admin.order.index',compact('orders'));
    }

    public function orderDetail()
    {

    }
}
