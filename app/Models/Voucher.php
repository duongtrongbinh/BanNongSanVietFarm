<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Voucher extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'vouchers';

    protected $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = ['title','code','description','is_active','type_unit','quantity','amount','start_date','end_date','created_at','updated_at','deleted_at'];

    public function order()
    {
        return $this->hasMany(Order::class, 'voucher_id', 'id');
    }

}
