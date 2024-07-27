<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateBannerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;

class ProfileUserController extends Controller
{
    const token = '29ee235a-2fa2-11ef-8e53-0a00184fe694';
    const url = 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province';

    public function profile(Request $request)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'token' => self::token,
        ];
        $response = Http::withHeaders($headers)->get(self::url);
        if ($response->successful()) {
            $provinces = $response->json();
        } else {
            $provinces = null;
            dd('error system');
        }
        return view('client.profile.index', compact('provinces'));
    }

    public function update(UpdateBannerRequest $request)
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
        return redirect()->back()->with('update', 'Cập nhật hồ sơ thành công.');
    }

    public function showChangePasswordForm()
    {
        $user = Auth::user();
        return view('client.profile.change-password',compact('user'));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        Auth::user()->update(['password' => Hash::make($request->new_password)]);

        return redirect()->back()->with('update', 'Đổi mật khẩu thành công.');
    }
}
