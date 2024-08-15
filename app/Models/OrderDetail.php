<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'order_details';
    public $timestamps = true;
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'image',
        'price_regular',
        'price_sale',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->BelongsTo(Product::class, 'product_id')->withTrashed();
    }

    public static function getTopSellingProducts($limit = 5)
    {
        return self::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->with('product') // Eager load the product relationship
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'DESC')
            ->limit($limit)
            ->get();
    }
}
