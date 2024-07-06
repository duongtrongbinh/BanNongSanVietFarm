<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Related extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'related';
    public $timestamps = true;
    protected $fillable = [
        'product_id',
    ];

    public function product()
    {
        return $this->BelongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_related', 'related_id', 'product_id')->withTrashed();
    }
}
