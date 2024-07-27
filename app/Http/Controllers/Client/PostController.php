<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::withCount('comments as comment_count')
            ->withAvg('comments as average_ratting', 'ratting')
            ->orderByDesc('id')
            ->paginate(3);
        $totalComments = $post->sum('comment_count');
        return view('client.post.index', compact('post', 'totalComments'));
    }

    public function show($id)
    {
        $post = Post::with('comments')->find($id);
        $comments = $post->comments()->with('user')->orderBy('created_at', 'desc')->get();
        $commentsCount = $comments->count();
        return view('client.post.show', compact('post', 'comments', 'commentsCount'));
    }

    public function ratingpost(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string',
            'ratting' => 'required|integer|between:1,5',
        ]);

        $userId = Auth::id();
        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->content = $request->input('comment');
        $comment->ratting = $request->input('ratting');
        $comment->save();

        $post = Post::findOrFail($request->input('post_id'));
        $post->comments()->attach($comment->id);

        // Chỉ thông báo thành công mà không kiểm tra spam ở đây
        return redirect()->back()->with('created', 'Đã thêm bình luận thành công.');
    }



}
