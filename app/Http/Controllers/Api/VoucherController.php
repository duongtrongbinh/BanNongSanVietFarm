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
            $voucherApply =  ( 100 - number_format($voucher->amount));
        }else{
            $voucherApply = $request->total_cart - $voucher->amount;
        }

        return response()->json([$voucherApply],200);
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
