<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;
class Role extends SpatieRole
{
    use HasFactory;

    protected $table = 'roles';

   public $timestamps = true;

   public $fillable = ['id','name','guard_name','created_at','updated_at'];
   public function permissions() :BelongsToMany
   {
        return $this->belongsToMany(Permission::class,'role_has_permissions');
   }
}
