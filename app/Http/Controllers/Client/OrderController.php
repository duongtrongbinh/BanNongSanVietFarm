<?php

namespace App\Http\Controllers\Client;

use App\Enum\OrderStatus;
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
       $orders = Order::where('user_id',Auth::user()->id);
       $orderAll = Order::where('user_id',Auth::user()->id)->get();
       $delivereds = $orders->where('status',OrderStatus::PENDING->value)->get();
       $pickups = Order::where('status', OrderStatus::PREPARE->value)->get();
       $returns = Order::where('status', OrderStatus::READY_TO_PICK->value)->get();
       $cancelleds = Order::where('status', OrderStatus::PICKING->value)->get();
       return view('client.order', compact('orderAll', 'delivereds', 'pickups', 'returns', 'cancelleds'));
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
   public function store(Request $request)
   {

       $request->validate([
           'user_id' => 'required|integer|exists:users,id',
           'voucher_id' => 'nullable|integer|exists:vouchers,id',
           'name'=>'required|min:3',
           'address' => 'required|min:5',
           'ward' => 'required',
           'city' => 'required',
           'district' => 'required',
           'before_total_amount' => 'required|numeric|min:0',
           'shipping' => 'required|numeric|min:0',
           'after_total_amount' => 'required|numeric|min:0',
           'note' => 'string|max:1000',
           'order_code' => 'required|string',
       ]);
       $detail = $request->input('address').','.$request->input('ward').','.  $request->input('district').','.$request->input('ward');
       $request->merge(['address' => $detail]);
       $create = $this->orderRepository->create($request->toArray());
   }
}