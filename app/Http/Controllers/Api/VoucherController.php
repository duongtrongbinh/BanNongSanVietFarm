<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function apply(Request $request)
    {
        $voucher = Voucher::query()->find($request->voucher_id);

        $total_after_apply = 0;

        $total = json_decode(Storage::get('checkout/serviceFee.json'), true);;


        if($voucher->type_unit == 0){

            $total_after_apply = $total['serviceFee'] - $voucher->amount;

        }else{
            $total_after_apply = $total['serviceFee'] * (100 - $voucher->amount) / 100;
        }

        $price_after_apply = $total['serviceFee'] - $total_after_apply;

        $data = [
            'message' => true,
            'price_after_apply' => $price_after_apply,
            'total_after_apply' => $total_after_apply,
            'session' => $total_after_apply
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
