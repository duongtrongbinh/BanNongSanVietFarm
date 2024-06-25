<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::withCount(['comments as comment_count'])
            ->withAvg('comments as average_ratting', 'ratting')
            ->having('comment_count', '>', 0)
            ->get(['name', 'id']); // Lấy thêm id để có thể sử dụng nếu cần

        return view('admin.comment.index', compact('products'));
    }
    public function show($id)
    {
        $product = Product::with('comments')->findOrFail($id);
        return view('admin.comment.show', compact('product'));
    }
    public function destroy($productId, $commentId)
    {
        // Tìm bản ghi ProductComment có product_id và comment_id tương ứng
        $productComment = ProductComment::where('product_id', $productId)
            ->where('comment_id', $commentId)
            ->firstOrFail();
        // Xóa bản ghi ProductComment
        $productComment->delete();
        return redirect()->back()->with('success', 'Đã xóa bình luận thành công.');
    }
    public function rating(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'comment' => 'required|string',
            'ratting' => 'required|integer|between:1,5',
        ]);
        $userId = Auth::id();
        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->content = $request->input('comment');
        $comment->ratting = $request->input('ratting');
        $comment->save();
        $product = Product::findOrFail($request->input('product_id'));
        $product->comments()->attach($comment->id);
        $comments = $product->comments()->orderBy('created_at', 'desc')->get();
        return redirect()->back()->with(['success' => 'Đã thêm bình luận thành công.', 'comments' => $comments]);
    }
}