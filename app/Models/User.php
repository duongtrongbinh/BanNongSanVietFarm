<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    public $table = 'users';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'user_code',
        'address',
        'social_id',
        'name_avatar',
        'image_avatar',
        'desc',
        'avatar',
        'user_code',
        'birthday'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'user_code';
    }

    public static function findOrCreateByGoogle($googleUser)
    {
        $user = static::where('social_id', $googleUser->id)->first();
        // If the user exists, return that user

        if ($user) {
            return $user;
        }
        // Generate a random integer for user_code
        $userCode = rand(100000, 999999); // Generate a random integer between 100000 and 999999
        // Otherwise, create a new user in your database

        $userCode = rand(100000, 999999);

        return static::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'social_id' => 1, // Set social_id to 1
            'phone' => $googleUser->phone,
            'user_code' => $userCode,
            'password' => bcrypt('randompassword'),
        ]);
    }

}
