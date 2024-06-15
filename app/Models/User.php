<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory, SoftDeletes;
    use Notifiable;

    protected $table = 'users';
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

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
    
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

        if ($user) {
            return $user;
        }

        $userCode = rand(100000, 999999); 

        return static::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'social_id' => $googleUser->id,
            'phone' => $googleUser->phone,
            'user_code' => $userCode,
            'password' => bcrypt('randompassword'),
        ]);
    }

}