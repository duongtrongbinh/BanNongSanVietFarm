<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'title',
        'image',
        'description',
        'content',
    ];
    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'post_comments', 'post_id', 'comment_id');
    }
}
