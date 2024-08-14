<?php


namespace App\Models;

use App\Enums\OrderStatus;
use App\Jobs\SendOrderToGHN;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        'payment_method',
        'payment_status',
        'before_total_amount',
        'shipping',
        'after_total_amount',
        'note',
        'status',
        'order_code',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'status' => 'integer',
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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details')
            ->withPivot('quantity', 'price_regular', 'price_sale', 'image', 'name')
            ->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_code = 'PH' . fake()->imei;
        });

        static::updating(function ($order) {
            if ($order->status == OrderStatus::PROCESSING->value) {
                dispatch(new SendOrderToGHN($order));
            }
        });
    }

    public function order_histories()
    {
        return $this->hasMany(OrderHistory::class, 'order_id', 'id');
    }

    public function transfer_histories()
    {
        return $this->hasMany(TransferHistory::class, 'order_id', 'id');
    }

    public static function getStatusMap()
    {
        return [
            0 => 'Đang chờ xử lý',
            1 => 'Đang xử lý',
            2 => 'Vận chuyển',
            3 => 'Giao hàng',
            4 => 'Đã nhận hàng',
            5 => 'Hoàn thành',
            6 => 'Đã hủy',
        ];
    }
}
