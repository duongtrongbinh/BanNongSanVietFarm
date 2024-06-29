<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_groups';
    public $timestamps = true;
    protected $fillable = [
        'product_id',
        'title',
    ];

    public function product()
    {
        return $this->BelongsTo(Product::class, 'product_id')->withTrashed();
    }
}
