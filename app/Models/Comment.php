<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;
use App\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'user_id',
        'content',
        'ratting'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_comments', 'comment_id', 'product_id');
    }
    public function productComments()
    {
        return $this->hasMany(ProductComment::class);
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_comments');
    }
}