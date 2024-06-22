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


    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'product_comments', 'product_id', 'comment_id');

    }
    
    public function flashSaleProducts()
    {
        return $this->hasMany(FlashSaleProduct::class, 'product_id');
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'purchase_receipts')
                    ->withPivot('reference_code', 'quantity', 'type_unit', 'order_code', 'cost');
    }

    public function purchaseReceipts()
    {
        return $this->belongsToMany(PurchaseReceipt::class, 'purchase_receipts', 'product_id', 'id')
                    ->withPivot('quantity', 'type_unit', 'order_code', 'cost', 'created_by', 'updated_by');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }

    public function productComments()
    {
        return $this->hasMany(ProductComment::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details')
                    ->withPivot('name', 'image', 'price_regular', 'price_sale', 'quantity')
                    ->withTimestamps();
    }
}