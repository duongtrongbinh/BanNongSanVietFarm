@extends('admin.layout.master')
@section('title', 'Chi tiết bình luận sản phẩm')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-1YCnBrcqXT2TVzjBVynjA1H/25llx1hA6YIWxUFOIj6Kh1Ev2kH+gj6Bg/Q4SY0g" crossorigin="anonymous">
@endsection
@section('content')
    <!-- Page Title and Breadcrumb -->
    <div class="pagetitle">
        <h3 class="card-title flex-grow-1 mb-0">Chi tiết bình luận sản phẩm : #{{ $product->name }}</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('comment.index') }}">Đánh giá sản phẩm</a></li>
                <li class="breadcrumb-item active">Chi tiết đánh giá sản phẩm</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <!-- Section Content -->
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <a href="" class="btn btn-success btn-sm">
                                    <i class="ri-download-2-fill align-middle me-1"></i> Tải bình luận sản phẩm
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Tên người dùng</th>
                                    <th scope="col">Bình luận</th>
                                    <th scope="col">Đánh giá</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($product->comments as $comment)
                                    <tr>
                                        <td>{{ $comment->id }}</td>
                                        <td>{{ $comment->user->name }}</td>
                                        <td>{{ $comment->content }}</td>
                                        <td style="white-space: nowrap;">
                                            @php
                                                // Tính toán số sao và điểm trung bình cho bình luận hiện tại
                                                $averageRatting = $comment->ratting;
                                                $fullStars = floor($averageRatting); // Số sao nguyên
                                                $halfStar = ($averageRatting - $fullStars) >= 0.5 ? 1 : 0; // Số sao nửa
                                                $emptyStars = 5 - $fullStars - $halfStar; // Số sao trống
                                            @endphp
                                            @for ($i = 1; $i <= $fullStars; $i++)
                                                <i class="fa fa-star text-warning" data-rating="{{ $i }}"></i>
                                            @endfor
                                            @if ($halfStar > 0)
                                                <i class="fa fa-star-half-alt text-warning" data-rating="{{ $fullStars + 1 }}"></i>
                                            @endif
                                            @for ($j = 1; $j <= $emptyStars; $j++)
                                                <i class="fa fa-star text-secondary" data-rating="{{ $fullStars + $halfStar + $j }}"></i>
                                            @endfor
                                            <p class="mb-0 d-inline">
                                                {{ number_format($averageRatting, 1) }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                <a data-url="{{ route('product.comment.destroy', ['productId' => $product->id, 'commentId' => $comment->id]) }}"
                                                   class="btn btn-danger btn-sm deletepost">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Section Content -->
@endsection

@section('js')
    <script src="{{asset('admin/assets/js/deleteAll/delete.js')}}"></script>

    <!--Delete js-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
