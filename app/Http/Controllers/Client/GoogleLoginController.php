<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class GoogleLoginController extends Controller
{
    protected $socialite;

    public function __construct()
    {
        $this->socialite = Socialite::driver('google');
    }

    public function redirectToGoogle()
    {
        return $this->socialite->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = $this->socialite->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['login_failed' => 'Login failed, please try again.']);
        }
        $authenticatedUser = User::where('social_id', $googleUser->id)->first();
        if (!$authenticatedUser) {
            $token = Str::random(10);

            $authenticatedUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'social_id' => $googleUser->id,
                'token' => $token,
            ]);

            Mail::send('client.email.email', compact('authenticatedUser'), function ($message) use ($authenticatedUser) {
                $message->subject('Nông sản Việt - Xác nhận tài khoản!');
                $message->to($authenticatedUser->email, $authenticatedUser->name);
            });
        }
        Auth::login($authenticatedUser, true);
        return redirect()->route('home');
    }

}
