<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provinces;

// Chú ý tên lớp đã được đổi thành Provinces
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    // Lấy tất cả các tỉnh/thành phố
    public function getProvinces()
    {
        $provinces = Provinces::all(); // Sử dụng tên lớp đúng
        return response()->json($provinces);
    }

    // Lấy tất cả các quận/huyện theo tỉnh/thành phố
    public function getDistricts($provinceId)
    {
        $districts = District::where('ProvinceID', $provinceId)->get();
        return response()->json($districts);
    }

    // Lấy tất cả các xã/phường theo quận/huyện
    public function getWards($districtId)
    {
        $wards = Ward::where('DistrictID', $districtId)->get();
        return response()->json($wards);
    }
}
