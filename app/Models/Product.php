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
        'price_regular',
        'price_sale',
        'quantity',
        'description',
        'is_active',
        'is_home',
        'description',
        'content',
    ];

    public function brand()
    {
        return $this->BelongsTo(Brand::class, 'brand_id')->withTrashed();
    }

    public function category()
    {
        return $this->BelongsTo(Category::class, 'category_id')->withTrashed();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id')->withTrashed();
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}
