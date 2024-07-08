<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('client.auth.password.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email này không tồn tại trong hệ thống của chúng tôi.'
        ]);
        $token = Str::random(10);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update(['token' => $token]);
            try {
                // Send reset link email
                Mail::send('client.email.sendResetLinkEmail', compact('user', 'token'), function ($message) use ($user) {
                    $message->subject('Nông sản Việt - Lấy lại mật khẩu tài khoản!');
                    $message->to($user->email, $user->name);
                });
                return  redirect()->route('login')->with('created', 'Link khôi phục mật khẩu đã được gửi đến email của bạn.');
            } catch (\Exception $e) {
                return back()->with('error', 'Đã xảy ra lỗi khi gửi email. Vui lòng thử lại sau.');
            }
        } else {
            return back()->with('error', 'Không tìm thấy người dùng với email này.');
        }
    }

    public function showResetForm(Request $request)
    {
        $token = $request->token;
        if ($token) {
            $user = User::where('token', $token)->first();
            if ($user) {
                return view('client.auth.password.reset', ['token' => $token, 'user' => $user]);
            }
        }
        return redirect()->back()->with('error', 'Đường dẫn đặt lại mật khẩu không hợp lệ.');
    }

    public function reset(Request $request)
    {
        $token = $request->token;
        $user = User::where('token', $token)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Token không hợp lệ.');
        }
        // Cập nhật mật khẩu
        $password = bcrypt($request->password);
        $user->password = $password;
        // Đặt lại token thành null
        $user->token = null;
        // Lưu thay đổi vào database
        $user->save();
        return redirect('login')->with('created', 'Đặt lại mật khẩu thành công!');
    }

}
