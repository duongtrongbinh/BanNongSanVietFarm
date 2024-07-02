@extends('admin.layout.master')
@section('title', 'List Post')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Danh sách bài viết</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('post.index') }}">Bài viết</a></li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="tab-content pt-2">
                            <!-- All Orders -->
                            <div class="tab-pane fade show active all-orders" id="all-orders">
                                <table id="example"
                                       class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th data-ordering="false">ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Hình ảnh</th>
                                        <th>Miêu tả</th>
                                        <th>Tổng số sao</th>
                                        <th>Tổng đánh giá</th>
                                        <th>Chỉnh sửa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($post as $row)
                                        <tr>
                                            <th scope="row">{{ $row->id }}</th>
                                            <td scope="row">{{ $row->title }}</td>
                                            <td>
                                                @if ($row->image)
                                                    <img src="{{asset($row->image)}}" width="50px">
                                                @else
                                                    <span class="text-muted">Không có ảnh</span>
                                                @endif
                                            </td>
                                            <td scope="row">{{ $row->description }}</td>
                                            <td>
                                                @php
                                                    $totalRatting = 0;
                                                    $totalCount = count($row->comments);

                                                    foreach ($row->comments as $comment) {
                                                        $totalRatting += $comment->ratting;
                                                    }
                                                    $averageRatting = $totalCount > 0 ? $totalRatting / $totalCount : 0;

                                                    // Tính toán số sao
                                                    $fullStars = floor($averageRatting); // Số sao nguyên
                                                    $halfStar = ceil($averageRatting - $fullStars); // Số sao nửa
                                                    $emptyStars = 5 - $fullStars - $halfStar; // Số sao trống
                                                @endphp

                                                <div class="d-flex mb-6 align-items-center">
                                                    @for ($i = 1; $i <= $fullStars; $i++)
                                                        <i class="fa fa-star text-warning" data-rating="{{ $i }}"></i>
                                                    @endfor
                                                    @if ($halfStar > 0)
                                                        <i class="fa fa-star-half-alt text-warning"
                                                           data-rating="{{ $i }}"></i>
                                                        @php $i++; @endphp
                                                    @endif
                                                    @for ($j = 1; $j <= $emptyStars; $j++)
                                                        <i class="fa fa-star-o text-secondary"
                                                           data-rating="{{ $i }}"></i>
                                                        @php $i++; @endphp
                                                    @endfor
                                                    <p class="mb-0">
                                                        <i class=" text-warning"></i> {{ number_format($averageRatting, 1) }}
                                                        <span class="text-muted">/5</span>
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($row->comment_count > 0)
                                                    {{ $row->comment_count }} (đánh giá)
                                                @else
                                                    Chưa có đánh giá
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                        title="Chi tiết">
                                                        <a href="{{route('post.show',$row)}}"
                                                           class="text-primary d-inline-block">
                                                            <i class="ri-eye-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Sửa">
                                                        <a href="{{ route('post.edit', $row) }}">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a data-url="{{ route('post.destroy', $row) }}"
                                                           class="btn btn-danger btn-sm deletepost">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </section>
@endsection
@section('js')
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="{{asset('admin/assets/js/deleteAll/delete.js')}}"></script>
    <!--Delete js-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
