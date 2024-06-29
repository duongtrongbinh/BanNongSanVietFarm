<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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
            $googleUser = $this->socialite->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['login_failed' => 'Login failed, please try again.']);
        }

        // Check if a user with this Google ID already exists
        $authenticatedUser = User::where('social_id', $googleUser->id)->first();

        if (!$authenticatedUser) {
            // If user does not exist, create a new user without a password
            $authenticatedUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'social_id' => $googleUser->id,
            ]);
        }

        // Log in the authenticated user
        Auth::login($authenticatedUser, true);

        return redirect()->route('home');
    }
}