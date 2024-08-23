<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected $primaryKey = 'DistrictID';

    public $timestamps = true;

    public $fillable = ['ProvinceID','DistrictID','DistrictName','created_at'];

    public function province()
    {
        return $this->belongsTo(Provinces::class, 'ProvinceID');
    }

    public function ward()
    {
        return $this->hasMany(Ward::class, 'DistrictID');
    }
    public function users() :HasMany
    {
        return $this->hasMany(User::class);
    }
}
