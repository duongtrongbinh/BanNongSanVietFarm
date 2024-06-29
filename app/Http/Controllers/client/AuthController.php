<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('client.auth.login');
    }
    public function login(LoginRequest $request)
    {
        $remember = $request->has('remember_token') ? true : false;
        if (Auth::guard('web')->attempt($request->only('email', 'password'), $remember)) {
            return redirect()->route('home');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function showRegistrationForm()
    {
        return view('client.auth.register');
    }
    public function register(RegisterRequest $request)
    {
        // Đảm bảo đăng xuất người dùng hiện tại trước khi đăng ký mới
        Auth::guard('web')->logout();
        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        auth()->login($user);
        return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập để tiếp tục.');
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    }
}
