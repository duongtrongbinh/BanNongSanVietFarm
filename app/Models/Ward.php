<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ward extends Model
{
    use HasFactory;

    protected $table = 'wards';

    protected $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = ['id','DistrictID','WardCode','WardName','created_at','created_at'];

    public function district()
    {
        return $this->belongsTo(District::class, 'DistrictID');
    }
    public function users() :HasMany
    {
       return $this->hasMany(User::class);
    }
}
