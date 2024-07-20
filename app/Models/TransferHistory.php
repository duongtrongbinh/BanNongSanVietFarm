<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferHistory extends Model
{
    use HasFactory;
    
    protected $table = 'transfer_histories';
    public $timestamps = true;
    protected $fillable = [
        'order_id',
        'status',
        'warehouse',
    ];

    public function order()
    {
        return $this->BelongsTo(Order::class, 'order_id')->withTrashed();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($transferHistory) {
            $order = Order::findOrFail($transferHistory->order_id);

            if (in_array($order->status, [OrderStatus::COMPLETED->value, OrderStatus::CANCELLED->value])) {
                throw new \Exception('Không thể thêm trạng thái vào bảng transfer_histories khi đơn hàng đã hoàn thành hoặc bị hủy.');
            }
        });
    }
}