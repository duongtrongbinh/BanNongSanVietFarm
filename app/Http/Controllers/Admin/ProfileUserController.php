<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provinces;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ChangePasswordRequest;

class ProfileUserController extends Controller
{
    public function profile()
    {

        $provinces = Provinces::query()->get();
        return view('admin.profile.index', compact('provinces'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->except('avatar');
        if ($request->input('avatar')) {
            if ($user->avatar) {
                $oldImagePath = str_replace(url('storage'), 'public', $user->avatar);
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }
            $data['avatar'] = $request->input('avatar');
        }
        $user->update($data);
        return redirect()->back()->with('update', 'Cập nhật hồ sơ thành công.');
    }

    public function showChangePasswordForm()
    {
        $user = Auth::user();
        return view('admin.profile.change_password', compact('user'));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        Auth::user()->update(['password' => Hash::make($request->new_password)]);

        return redirect()->back()->with('update', 'Đổi mật khẩu thành công.');
    }
}
