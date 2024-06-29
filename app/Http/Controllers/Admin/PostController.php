<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::withCount('comments as comment_count')
            ->withAvg('comments as average_ratting', 'ratting')
            ->orderByDesc('id')
            ->paginate(10);
        return view('admin.post.index',compact('post'));
    }

    public function create()
    {
        return view('admin/post.create');
    }
    public function store(StorePostRequest $request)
    {
        $data = $request->except('image');
        $data['image'] = $request->input('image');
        $post = Post::create($data);
        return redirect()->route('post.index')->with('thongbao','bạn đã thêm thành công !');
    }
    public function show(Post $post )
    {
        $post->load('comments');
        return view('admin.post.show',compact('post'));
    }
    public function edit(Post $post )
    {
        return view('admin.post.edit',compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {

        $data = $request->except('image');
        if ($request->input('image')) {

            if ($post->image) {
                $oldImagePath = str_replace(url('storage'), 'public', $post->image);
                Storage::delete($oldImagePath);
            }
            $data['image'] = $request->input('image');
        }
        $post->update($data);
        return redirect()->route('post.index')->with('thongbao', 'Bạn đã cập nhật thành công!');
    }

    public function storeComment(Request $request, Post $post)
    {
        $comment = new Comment();
        $comment->user_id = $request->user()->id;
        $comment->content = $request->input('content');
        $comment->ratting = $request->input('ratting');
        $comment->save();
        $post->comments()->attach($comment->id);

        return redirect()->route('post.show', $post->id);
    }
    public function destroy(Post $post)
    {
        // Kiểm tra và xóa hình ảnh nếu tồn tại
        if ($post->image && Storage::exists($post->image)) {
            Storage::delete($post->image);
        }
        // Xóa bài viết
        $post->delete();
        return response()->json(true);
    }

    public function destroyComment($postId, $commentId)
    {
        $post = Post::findOrFail($postId);
        // Xác định và xóa bình luận
        $post->comments()->detach($commentId);
        return response()->json(true);
    }
}
