<?php

namespace App\Http\Controllers\Client;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\VoucherRepository;
use App\Models\District;
use App\Models\Order;
use App\Models\Product;
use App\Models\Provinces;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


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
       $orderAll = Order::With('order_details')->where('user_id',Auth::user()->id)->get();
       return view('client.order', compact('orderAll'));
   }
   public function create()
   {
       if(!session()->has('cart')){
           return redirect()->back();
       }
       $headers = [
           'Content-Type' => 'application/json',
           'token'=>self::token,
       ];
       $response = Http::withHeaders($headers)->get(self::url);
       if ($response->successful()) {
           $provinces = $response->json();
       }else{
           $provinces = null;
           dd('error system');
       }
       $user = auth()->user();
       $vouchers = $this->voucherRepository->getVoucherActive();
       return view('client.check-out',compact(['user','vouchers','provinces']));
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
