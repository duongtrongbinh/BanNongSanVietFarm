<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Comment;
class ProductComment extends Model
{
    use HasFactory;
    protected $table = 'product_comments';
    protected $primaryKey = 'comment_id';
    protected  $fillable = [
        'product_id',
        'comment_id',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
