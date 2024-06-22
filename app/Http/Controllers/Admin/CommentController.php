<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductComment;
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

//    public function show($id)
//    {
//        $product = Product::with('comment')->findOrFail($id); // Lấy sản phẩm và các bình luận của nó
//        return view('admin.comment.show', compact('product'));
//    }
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

}
