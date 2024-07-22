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
        $user = User::find($userId);
        $product = Product::findOrFail($productId);
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thực hiện bình luận.');
        }
        if (!$user->hasPurchasedProduct($productId)) {
            return redirect()->back()->with('error', 'Bạn cần mua sản phẩm này trước khi được phép bình luận.');
        }
        if ($product->comments()->where('user_id', $userId)->exists()) {
            return redirect()->back()->with('error', 'Bạn đã bình luận sản phẩm này trước đó.');
        }
        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->content = $request->input('comment');
        $comment->ratting = $request->input('ratting');
        $comment->save();
        $product->comments()->attach($comment->id);
        $comments = $product->comments()->orderBy('created_at', 'desc')->get();
        return redirect()->back()->with(['success' => 'Đã thêm bình luận thành công.', 'comments' => $comments]);
    }

}
