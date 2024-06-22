<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'user_code',
        'address',
        'social_id', // Thêm trường social_id vào fillable
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'user_code';
    }

    /**
     * Find or create a user based on Google's response.
     *
     * @param object $googleUser
     * @return User
     */
    public static function findOrCreateByGoogle($googleUser)
    {
        // Try to find the user by social_id in your database
        $user = static::where('social_id', $googleUser->id)->first();

        // If the user exists, return that user
        if ($user) {
            return $user;
        }

        // Generate a random integer for user_code
        $userCode = rand(100000, 999999); // Generate a random integer between 100000 and 999999

        // Otherwise, create a new user in your database
        return static::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'social_id' => $googleUser->id,
            'phone' => $googleUser->phone,
            'user_code' => $userCode,
            'password' => bcrypt('randompassword'),
        ]);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}

