<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service_fee extends Model
{
    use HasFactory;

    protected $table = 'service_fees';

    public $timestamps = true;

    public $fillable = ['WardCode','DistrictID','service_fee','created_at','updated_at'];
}
