<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = ['ProvinceID','DistrictID','DistrictName','created_at'];

    public function province()
    {
        return $this->belongsTo(Provinces::class, 'province_id');
    }

    public function ward()
    {
        return $this->hasMany(Ward::class, 'district_id');
    }
}