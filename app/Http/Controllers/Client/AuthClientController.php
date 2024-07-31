<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthClientController extends Controller
{
    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $remember = $request->filled('remember_token');
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->status == 0) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Tài khoản của bạn chưa được kích hoạt.');
            }
            return redirect()->route('home')->with('update', 'Đăng nhập thành công');
        }
        return redirect()->route('login')->with('error', 'Tên tài khoản hoặc mật khẩu không đúng, vui lòng thử lại');
    }
    public function showRegistrationForm()
    {
        return view('client.auth.register');
    }
    public function register(RegisterRequest $request)
    {
        $token = Str::random(10);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'token' => $token,
        ]);

        if ($user) {
            Mail::send('client.email.activated', compact('user'), function ($message) use ($user) {
                $message->subject('Nông sản Việt - Xác nhận tài khoản!');
                $message->to($user->email, $user->name);
            });
            Auth::guard('web')->login($user);
            session()->flash('success', 'Đăng ký thành công, xin vui lòng xác nhận tài khoản qua email.');
            session()->flash('user', $user);
            return redirect()->route('login')->with('success', 'Đăng ký thành công, xin vui lòng xác nhận tài khoản qua email.');
        }

        return redirect()->back()->with('error', 'Đăng ký không thành công.');
    }


    public function activated(Request $request)
    {
        $token = $request->token;
        // Find the user by the provided token
        $user = User::where('token', $token)->first();
        if ($user) {
            // Update user status and token
            $user->status = 1;
            $user->token = null;
            $user->save(); // Save the changes
            return redirect()->route('login')->with('success', 'Xác nhận tài khoản thành công, bạn có thể đăng nhập.');
        } else {
            return redirect()->route('login')->with('error', 'Mã xác nhận bạn gửi không hợp lệ');
        }
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }

}