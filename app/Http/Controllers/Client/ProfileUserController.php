<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\District;
use App\Models\Ward;
class ProfileUserController extends Controller
{
    const token = '29ee235a-2fa2-11ef-8e53-0a00184fe694';
    const url = 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province';
    public function profile(Request $request)
    {
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
        return view('client.profile.index',compact('provinces'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('avatar');
        $user->update($data);
        return redirect()->back()->with('success', 'Cập nhật hồ sơ thành công.');
    }
    public function showChangePasswordForm()
    {
        return view('client.profile.change-password');
    }
    public function changePassword(Request $request)
    {
        $user = Auth::user();
        if ($user->social_id) {
            return redirect()->back()->with('error', 'Bạn không thể đổi mật khẩu khi đăng nhập bằng Google.');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        Auth::user()->update(['password' => Hash::make($request->new_password)]);

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công.');
    }
}
