<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
            $googleUser = $this->socialite->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['login_failed' => 'Login failed, please try again.']);
        }

        // Proceed with finding or creating user and logging in
        $authenticatedUser = User::findOrCreateByGoogle($googleUser);

        Auth::login($authenticatedUser, true);

        return redirect()->route('home');
    }
}
