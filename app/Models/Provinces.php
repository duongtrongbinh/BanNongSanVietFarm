<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kjmtrue\VietnamZone\Models\District;

class Provinces extends Model
{
    use HasFactory;

    protected $table = 'provinces';

    protected $primaryKey = 'ProvinceID';

    public $timestamps = true;

    public $fillable = ['ProvinceID','ProvinceName','created_at','created_at'];

    public function districts()
    {
    return $this->hasMany(District::class, 'province_id');
    }
    public function users() :HasMany
    {
        return $this->hasMany(User::class);
    }
}
