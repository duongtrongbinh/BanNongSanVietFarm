<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $table = 'flash_sales';

    protected $primaryKey = 'id';


    public $timestamps = true;


    public $fillable = ['status','start_date','end_date','created_at','updated_at'];

    public function flashSaleProducts()
    {
        return $this->hasMany(FlashSaleProduct::class);
    }

}
