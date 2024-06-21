<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';
    public $timestamps = true;
    public $fillable = [
        'user_id',
        'voucher_id',
        'name',
        'email',
        'phone',
        'address',
        'before_total_amount',
        'shipping',
        'after_total_amount',
        'note','status',
        'order_code',
    ];

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function voucher()
    {
        return $this->BelongsTo(Voucher::class, 'voucher_id')->withTrashed();
    }

    public function user()
    {
        return $this->BelongsTo(User::class, 'user_id')->withTrashed();
    }
}
