<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReceipt extends Model
{
    use HasFactory;

    protected $table = 'purchase_receipts';

    protected $fillable = ['reference_code', 'supplier_id', 'created_by', 'updated_by'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'purchase_receipts', 'id', 'product_id')
                    ->withPivot('quantity', 'type_unit', 'order_code', 'cost', 'created_by', 'updated_by');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
