<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleProduct extends Model
{
    use HasFactory;

    protected $table = 'flash_sale_products';

    protected $primaryKey = 'id';

    public $timestamps = false; // Thêm dòng này để vô hiệu hóa timestamp

    public $fillable = ['flash_sale_id','product_id','discount','quantity','is_active'];

    public function flashSale()
    {
        return $this->belongsTo(FlashSale::class,'flash_sale_id');
    }

    // Quan hệ với bảng Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
