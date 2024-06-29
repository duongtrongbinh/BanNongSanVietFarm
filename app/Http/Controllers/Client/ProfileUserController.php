<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileUserController extends Controller
{
    public function profile()
    {
        return view('client.profile.index');
    }
    public function update(Request $request)
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
        return view('client.profile.change-password');
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
