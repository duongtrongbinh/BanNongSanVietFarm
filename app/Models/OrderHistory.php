<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $table = 'order_histories';
    public $timestamps = true;
    protected $fillable = [
        'order_id',
        'status',
        'warehouse',
    ];

    public function order()
    {
        return $this->BelongsTo(Order::class, 'product_id')->withTrashed();
    }
}
