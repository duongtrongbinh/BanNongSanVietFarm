<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\VoucherRepository;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
   public $orderRepository;

   public $voucherRepository;

   public function __construct(OrderRepository $orderRepository, VoucherRepository $voucherRepository)
   {
         $this->orderRepository = $orderRepository;
         $this->voucherRepository = $voucherRepository;
   }
   public function create()
   {
       $products = Product::inRandomOrder()->take(3)->get();
       $user = Auth::user();
       $vouchers = $this->voucherRepository->getVoucherActive();
       return view('client.check-out',compact(['user','vouchers','products']));
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
       // create thành công
       dd($create);
   }
}
