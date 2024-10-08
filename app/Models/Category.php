<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = str()->slug($category->name); 
        });

        static::updating(function ($category) {
            $category->slug = str()->slug($category->name); 
        });
    }
}