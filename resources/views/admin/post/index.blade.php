@extends('admin.layout.master')
@section('content')
    <script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Danh sách bài viết</h5>
                        <a href="{{Route('post.create')}}">
                            <button type="submit" class="btn btn-sm btn-success float-right">
                                <i class="fas fa-trash"></i> Thêm Mới Bài Viết
                            </button>
                        </a>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Title</th>
                                <th scope="col">Image</th>
                                <th scope="col">Description</th>
                                <th scope="col">Content</th>
                                <th scope="col">Tháo tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($post as $row)
                                <tr>
                                    <th scope="row">{{ $row->id }}</th>
                                    <td scope="row">{{ $row->title }}</td>
                                    <td>
                                        @if ($row->image)
                                            <img src="{{asset($row->image)}}" width="80px">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td scope="row">{{ $row->description }}</td>
                                    <td scope="row">{{ $row->content }}</td>
                                    <td>

                                        <a href="{{ route('post.edit', $row) }}" class="btn btn-primary btn-sm mr-1">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
{{--                                        <a data-url="{{ route('post.destroy',$row) }}"  class="btn btn-warning deleteSlide">Delete</a>--}}
                                        <form action="{{ route('post.destroy', $row) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


