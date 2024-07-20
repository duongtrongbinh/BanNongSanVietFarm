<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProfileUserController extends Controller
{
    const token = '29ee235a-2fa2-11ef-8e53-0a00184fe694';
    const url = 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province';
    public function profile()
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
        return view('admin.profile.index',compact('provinces'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->except('avatar');
        if ($request->input('avatar')) {
            if ($user->avatar) {
                $oldImagePath = str_replace(url('storage'), 'public', $user->avatar);
                Storage::delete($oldImagePath);
            }
            $data['avatar'] = $request->input('avatar');
        }
        $user->update($data);
        return redirect()->back()->with('success', 'Cập nhật hồ sơ thành công.');
    }

    public function showChangePasswordForm()
    {
        return view('admin.profile.change_password');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra nếu người dùng đăng nhập bằng Google, không cho phép đổi mật khẩu
        if ($user->social_id) { // Sử dụng social_id hoặc provider_id tùy vào cách bạn đã đặt
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
