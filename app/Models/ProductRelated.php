<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRelated extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_related';
    public $timestamps = true;
    protected $fillable = [
        'product_id',
        'product_ids',
        'is_active',
    ];

    public function product()
    {
        return $this->BelongsTo(Product::class, 'product_id')->withTrashed();
    }
}
