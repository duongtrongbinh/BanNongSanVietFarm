<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brands';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            $brand->slug = str()->slug($brand->name); 
        });

        static::updating(function ($brand) {
            $brand->slug = str()->slug($brand->name); 
        });
    }
}
