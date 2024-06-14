<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'image',
        'slug',
        'excerpt',
        'cost',
        'price',
        'price_sale',
        'quantity',
        'description',
        'status',
    ];

    public function brands()
    {
        return $this->BelongsTo(Category::class, 'category_id');
    }

    public function categories()
    {
        return $this->BelongsTo(Brand::class, 'brand_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function flashSaleProducts()
    {
        return $this->hasMany(FlashSaleProduct::class, 'product_id');
    }
}
