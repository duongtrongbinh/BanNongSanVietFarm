<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    use HasFactory;

    protected $table = 'provinces';

    protected $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = ['ProvinceID','ProvinceName','created_at','created_at'];

    public function district()
{
    return $this->hasMany(District::class, 'province_id');
}
}
