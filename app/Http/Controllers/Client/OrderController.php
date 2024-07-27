<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\VoucherRepository;
use App\Models\Order;
use App\Models\Provinces;
use Illuminate\Support\Facades\Auth;
use  \App\Enums\TransferStatus;


class OrderController extends Controller
{
   public $orderRepository;

   public $voucherRepository;

   const token = '29ee235a-2fa2-11ef-8e53-0a00184fe694';
   const url = 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province';
   public function __construct(OrderRepository $orderRepository, VoucherRepository $voucherRepository)
   {
         $this->orderRepository = $orderRepository;
         $this->voucherRepository = $voucherRepository;
   }


   public function index()
   {
       $orderAll = Order::With('order_details')->where('user_id',Auth::user()->id)->paginate();
       return view('client.order', compact('orderAll'));
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
       $order = Order::with(['user', 'order_details', 'order_histories'])->find($order->id);
       return view('client.order-detail', compact('order'));
   }
   public function success(string $code)
   {
       $order = Order::with('order_details')->where('order_code',$code)->first();
       return view('thankyou', compact('order'));
   }
}