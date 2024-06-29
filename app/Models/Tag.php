<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tags';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'name',
        'slug',
    ];

    public function products()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'tag_id', 'product_id')->withTrashed();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            $tag->slug = str()->slug($tag->name); 
        });

        static::updating(function ($tag) {
            $tag->slug = str()->slug($tag->name); 
        });
    }
}
