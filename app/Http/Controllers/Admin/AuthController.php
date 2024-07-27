<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Hiển thị trang đăng nhập.
     */
    public function index()
    {
        return view("admin.auth.user");
    }

    /**
     * Xử lý việc đăng nhập.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember_token') ? true : false;

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $remember)) {
            return redirect()->route('dashboard'); // Chuyển hướng đến trang dashboard sau khi đăng nhập thành công
        }

        return redirect()->back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])->withInput();
    }

    /**
     * Xử lý việc đăng xuất.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login'); // Chuyển hướng đến trang đăng nhập admin sau khi đăng xuất
    }
}
