<!-- resources/views/admin/comment/show.blade.php -->

@extends('admin.layout.master')

@section('content')
    <h1>{{ $product->name }}</h1>

    <h2>Comments</h2>

    @if ($product->comments->isEmpty())
        <p>There are no comments for this product.</p>
    @else
        <table class="table">
            <thead>
            <tr>
                <th>User</th>
                <th>Comment</th>
                <th>Rating</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($product->comments as $comment)
                <tr>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>{{ $comment->ratting }}</td>
                    <td>
                        <form action="{{ route('product.comment.destroy', ['productId' => $product->id, 'commentId' => $comment->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

@endsection
