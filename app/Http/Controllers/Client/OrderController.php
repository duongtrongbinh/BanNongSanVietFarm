<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\VoucherRepository;
use App\Models\District;
use App\Models\Product;
use App\Models\Provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


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
    //    $products = Product::inRandomOrder()->take(3)->get();
       $user = auth()->user();
       $provinces = Provinces::all();
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
       // create thành công

   }

   public function provinces(Request $request)
   {
       $districts = Provinces::with('district.ward')->find($request->input('province_id'));

       $array = [
           'status' => true,
           'data' => $districts,
       ];
       return response()->json($array,200);
   }

   public function district( Request $request)
   {

       $wards = District::with('ward')->find($request->input('district_id'));

       $array = [
           'status' => true,
           'data' => $wards,
       ];
       return response()->json($array,200);

   }
}