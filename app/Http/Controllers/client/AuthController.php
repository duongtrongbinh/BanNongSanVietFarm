<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('client.auth.login');
    }
    public function login(Request $request)
    {
        $remember = $request->filled('remember_token');
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $remember)) {
            // Xác thực thành công
            return redirect('/');
        }
        // Xác thực thất bại
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không khớp với hồ sơ của chúng tôi.',
        ]);
    }
}
