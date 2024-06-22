@extends('admin.layout.master')
@section('content')
    <script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Danh sách comment</h5>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Image Product</th>
                                <th scope="col">Name Product</th>
                                <th scope="col">Total Rating</th>
                                <th scope="col">Tháo tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $index => $row)
                                <tr>
                                    <th scope="col">{{ $index + 1 }}</th>
                                    <td>
                                        @if ($row->image)
                                            <img src="{{ asset($row->image) }}" width="80px">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $row->name }}</td>
                                    <td>
                                        @if ($row->comment_count > 0)
                                            @php
                                                $averageRatting = $row->average_ratting;
                                                $displayRatting = (floor($averageRatting) == $averageRatting) ? number_format($averageRatting, 0) : number_format($averageRatting, 1);
                                            @endphp
                                            {{ $displayRatting }} ({{ $row->comment_count }} đánh giá)
                                        @else
                                            Chưa có đánh giá
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('comment.show', $row) }}" class="btn btn-primary btn-sm mr-1">
                                            <i class="fas fa-edit"></i> Chi tiết
                                        </a>
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


