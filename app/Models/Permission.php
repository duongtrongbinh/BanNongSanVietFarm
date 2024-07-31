<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Permission extends Model
{
    use HasFactory;

    public $timestamps = true;

    public $fillable = ['id','name','guard_name','created_at','updated_at'];

    public function roles() :BelongsToMany
    {
        return $this->belongsToMany(Role::class,'role_has_permissions');
    }
}
