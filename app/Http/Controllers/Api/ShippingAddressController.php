<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShippingAddressController extends Controller
{

    public function districts(Request $request)
    {
        $districts  = District::query()->where('ProvinceID',$request->province_id)->get();
        $arr = [
            'message' => true,
            'data' => $districts
        ];
        return response()->json($arr,200);
    }

    public function wards(Request $request)
    {
        $wards  = Ward::query()->where('DistrictID',$request->district_id)->get();
        $arr = [
            'message' => true,
            'data' => $wards
        ];
        return response()->json($arr,200);
    }

}
