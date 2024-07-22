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
        <h1>Chi tiết bài viết</h1>
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
                            <h3>Chi tiết bài viết</h3>
                            <div class="tab-pane fade show active all-orders" id="all-orders">
                                <table id="example"
                                       class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Tiêu đề</th>
                                        <th scope="col">Hình ảnh</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$post->id}}</td>
                                        <td>{{$post->title}}</td>
                                        <td>
                                            <img src="{{asset($post->image)}}" width="80px">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </section>
    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="tab-content pt-2">
                            <!-- All Orders -->
                            <h3>Chi tiết bình luận bài viết</h3>
                            <div class="tab-pane fade show active all-orders" id="all-orders">
                                <table id="example"
                                       class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                       style="width:100%">
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
                                    @foreach($post->comments as $comment)
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
                                                    <i class="fa fa-star-half-alt text-warning"
                                                       data-rating="{{ $fullStars + 1 }}"></i>
                                                @endif
                                                @for ($j = 1; $j <= $emptyStars; $j++)
                                                    <i class="fa fa-star text-secondary"
                                                       data-rating="{{ $fullStars + $halfStar + $j }}"></i>
                                                @endfor
                                                <p class="mb-0 d-inline">
                                                    {{ number_format($averageRatting, 1) }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                @if($comment->user->is_spam == true)
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                        title="bỏ spam">
                                                        <a href="#" class="btn btn-success btn-sm unmark-as-spam"
                                                           data-comment-id="{{ $comment->id }}"
                                                           onclick="event.preventDefault(); unmarkAsSpam({{ $post->id }}, {{ $comment->id }});">
                                                            <i class="ri-checkbox-blank-circle-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                @else
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                        title="spam">
                                                        <a href="#" class="btn btn-warning btn-sm mark-as-spam"
                                                           data-comment-id="{{ $comment->id }}"
                                                           onclick="event.preventDefault(); confirmMarkSpam({{ $post->id }}, {{ $comment->id }});">
                                                            <i class="ri-spam-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                @endif
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
    <!--Delete js-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function confirmMarkSpam(postId, commentId) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn đánh dấu bình luận này là spam?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy',
            }).then((result) => {
                if (result.isConfirmed) {
                    markCommentAsSpam(postId, commentId);
                }
            });
        }

        function markCommentAsSpam(postId, commentId) {
            let url = "{{ route('post.comment.markAsSpam', ['postId' => ':postId', 'commentId' => ':commentId']) }}";
            url = url.replace(':postId', postId).replace(':commentId', commentId);

            axios.put(url)
                .then(response => {
                    if (response.data.success) {
                        Swal.fire('Đánh dấu thành công!', '', 'success');
                        let button = document.querySelector(`.mark-as-spam[data-comment-id="${commentId}"]`);
                        if (button) {
                            button.innerHTML = `<i class="ri-checkbox-blank-circle-fill fs-16"></i>`;
                            button.classList.remove('btn-warning');
                            button.classList.add('btn-success');
                            button.classList.remove('mark-as-spam');
                            button.classList.add('unmark-as-spam');
                            button.setAttribute('onclick', `event.preventDefault(); unmarkAsSpam(${postId}, ${commentId});`);
                            button.closest('li').setAttribute('title', 'Unmark as Spam');
                        }
                    } else {
                        Swal.fire('Đánh dấu thất bại!', '', 'error');
                    }
                })
                .catch(error => {
                    console.error('Đã xảy ra lỗi:', error);
                    Swal.fire('Đã xảy ra lỗi!', '', 'error');
                });
        }

        function unmarkAsSpam(postId, commentId) {
            let url = "{{ route('post.comment.unmarkAsSpam', ['postId' => ':postId', 'commentId' => ':commentId']) }}";
            url = url.replace(':postId', postId).replace(':commentId', commentId);

            axios.put(url)
                .then(response => {
                    if (response.data.success) {
                        Swal.fire('Bỏ đánh dấu thành công!', '', 'success');
                        let button = document.querySelector(`.unmark-as-spam[data-comment-id="${commentId}"]`);
                        if (button) {
                            button.innerHTML = `<i class="ri-spam-fill fs-16"></i>`;
                            button.classList.remove('btn-success');
                            button.classList.add('btn-warning');
                            button.classList.remove('unmark-as-spam');
                            button.classList.add('mark-as-spam');
                            button.setAttribute('onclick', `event.preventDefault(); confirmMarkSpam(${postId}, ${commentId});`);
                            button.closest('li').setAttribute('title', 'Mark as Spam');
                        }
                    } else {
                        Swal.fire('Bỏ đánh dấu thất bại!', '', 'error');
                    }
                })
                .catch(error => {
                    console.error('Đã xảy ra lỗi:', error);
                    Swal.fire('Đã xảy ra lỗi!', '', 'error');
                });
        }
    </script>
@endsection
