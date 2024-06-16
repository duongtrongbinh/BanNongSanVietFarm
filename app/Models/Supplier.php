<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        "name","contact_name","company","phone_number","tax_code","email","address","note"
        ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'purchase_receipts')
                    ->withPivot('reference_code', 'quantity', 'type_unit', 'order_code', 'cost');
    }

    public function purchaseReceipts()
    {
        return $this->hasMany(PurchaseReceipt::class);
    }
}