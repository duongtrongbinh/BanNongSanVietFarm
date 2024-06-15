<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = ['user_id','voucher_id','name','email','phone','address','before_total_amount',
        'shipping','after_total_amount','note','status','order_code','created_at','updated_at','deleted_at'];
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
