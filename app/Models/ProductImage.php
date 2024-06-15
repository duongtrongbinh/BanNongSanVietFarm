<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';
    public $timestamps = true;
    protected $fillable = [
        'product_id',
        'image',
    ];

    public function product()
    {
        return $this->BelongsTo(Product::class, 'product_id')->withTrashed();
    }
}
