<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentClientController extends Controller
{
    public function rating(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'comment' => 'required|string',
            'ratting' => 'required|integer|between:1,5',
        ]);

        $userId = Auth::id();
        $productId = $request->input('product_id');

        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->content = $request->input('comment');
        $comment->ratting = $request->input('ratting');
        $comment->save();

        $product = Product::findOrFail($productId);
        $product->comments()->attach($comment->id);

        return redirect()->back()->with('success', 'Đã thêm bình luận thành công.');
    }


}
