<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function apply(Request $request)
    {
        $voucher = Voucher::query()->find($request->voucher_id);
        $voucherApply = 0;
        if($voucher->type_unit == 0){
            $voucherApply = $request->total_cart - $voucher->amount;
        }else{
            $voucherApply = $request->total_cart * (100 - $voucher->amount) / 100;
        }

        $price =  $request->total_cart - $voucherApply;

        session(['voucher_amount' => $voucher->amount]);

        $data = [
            'message' => true,
            'total_apply_voucher' => $voucherApply,
            'amount' => $price
        ];

        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
