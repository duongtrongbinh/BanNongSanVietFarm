@extends('client.layouts.master')
@section('title', 'Chi tiết bài vết')
@section('styles')
    <link href="{{ asset('client/assets/css/post.css') }}" rel="stylesheet">

    <style>
        .comment-container {
            display: flex;
            align-items: flex-start;
        }

        .comment-avatar {
            margin-right: 15px;
        }

        .comment-avatar img {
            width: 100px;
            height: 100px;
            padding: 3px;
        }

        .comment-content {
            flex: 1;
        }

        .comment-content p {
            margin-bottom: 8px;
        }

        .comment-content h5 {
            margin-bottom: 0;
        }

        .fa-star,
        .fa-star-half-alt,
        .fa-star-o {
            margin-right: 5px;
        }

        .fa-star-half-alt {
            margin-left: 2px; /* Điều chỉnh khoảng cách giữa ngôi sao đầy và nửa */
        }

        .carousel-item img {
            margin: 0 auto;
            max-width: 50%;
        }
    </style>
@endsection

@php
    $totalRatting = 0;
    $totalCount = count($post->comments);

    foreach ($post->comments as $comment) {
        $totalRatting += $comment->ratting;
    }
    $averageRatting = $totalCount > 0 ? $totalRatting / $totalCount : 0;
@endphp
@php
    $fullStars = floor($averageRatting); // Số sao nguyên
    $halfStar = ceil($averageRatting - $fullStars); // Số sao nửa
    $emptyStars = 5 - $fullStars - $halfStar; // Số sao trống
@endphp
@section('content')
    @php
        $created = session('created');
    @endphp
        <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Chi tiết bài viết</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Chi tiết bài viết</li>
        </ol>
    </div>

    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12 entries">
                    <article class="entry entry-single">
                        <div class="entry-img">
                            <img src="{{asset($post->image)}}" alt="" style="width: 100%;height: 600px"
                                 class="img-fluid">
                        </div>
                        <h2 class="entry-title">
                            <a href="#">{{$post->title}}</a>
                        </h2>
                        <div class="d-flex mb-4 align-items-center">
                            <div class="me-2">
                                @for ($i = 1; $i <= $fullStars; $i++)
                                    <i class="fa fa-star text-secondary" data-ratting="{{ $i }}"></i>
                                @endfor

                                @if ($halfStar > 0)
                                    <i class="fa fa-star-half-alt text-secondary" data-ratting="{{ $i }}"></i>
                                    @php $i++; @endphp
                                @endif
                                @for ($j = 1; $j <= $emptyStars; $j++)
                                    <i class="fa fa-star " data-ratting="{{ $i }}"></i>
                                    @php $i++; @endphp
                                @endfor
                            </div>
                            <p class="mb-0">{{ number_format($averageRatting, 1) }}</p>
                        </div>
                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a
                                        href="">{{ $commentsCount }} Bình luận</a></li>
                            </ul>
                        </div>
                        <div class="entry-content">
                            <p>{{$post->description}}</p>
                        </div>
                        <div class="entry-content">
                            <p>{!! $post->content !!}</p>
                        </div>
                    </article>
                    <div class="blog-comments">
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3" role="tablist">
                                    <button class="nav-link border-white border-bottom-0" type="button"
                                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                            aria-controls="nav-about" aria-selected="false">Chi tiết bình luận
                                    </button>
                                    <button class="nav-link active border-white border-bottom-0" type="button"
                                            id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                            aria-controls="nav-mission" aria-selected="true">Bình luận
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane" id="nav-about" role="tabpanel"
                                     aria-labelledby="nav-about-tab">
                                    <div class="container">
                                        <h4>{{ $commentsCount }} Bình luận</h4>
                                        @foreach($comments as $comment)
                                            <div class="d-flex mb-4">
                                                <img src="{{$comment->user && $comment->user->avatar ? $comment->user->avatar :  asset('client/assets/img/NoBanner.png') }}"
                                                     class="img-fluid rounded-circle p-3"
                                                     style="width: 100px; height: 100px;" alt="">
                                                <div>
                                                    <p class="mb-2"
                                                       style="font-size: 14px;">{{ $comment->created_at->format('F j, Y') }}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <h5>{{ $comment->user ? $comment->user->name : 'Người dùng ẩn danh' }}</h5>

                                                        <div class="d-flex mb-3">
                                                            @php
                                                                // Tính toán số sao và điểm trung bình cho bình luận hiện tại
                                                                $averageRatting = $comment->ratting;
                                                                $fullStars = floor($averageRatting); // Số sao nguyên
                                                                $halfStar = ($averageRatting - $fullStars) >= 0.5 ? 1 : 0; // Số sao nửa
                                                                $emptyStars = 5 - $fullStars - $halfStar; // Số sao trống
                                                            @endphp
                                                            <div class="d-flex align-items-center">
                                                                @for ($i = 1; $i <= $fullStars; $i++)
                                                                    <i class="fa fa-star text-warning"
                                                                       data-rating="{{ $i }}"></i>
                                                                @endfor
                                                                @if ($halfStar > 0)
                                                                    <i class="fa fa-star-half-alt text-warning"
                                                                       data-rating="{{ $fullStars + 1 }}"></i>
                                                                @endif
                                                                @for ($j = 1; $j <= $emptyStars; $j++)
                                                                    <i class="fa fa-star"
                                                                       data-rating="{{ $fullStars + $halfStar + $j }}"></i>
                                                                @endfor
                                                                <p class="mb-0">{{ number_format($averageRatting, 1) }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p >{{ $comment->content }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane active" id="nav-mission" role="tabpanel"
                                     aria-labelledby="nav-mission-tab">
                                    @if (Auth::check())
                                        @if (Auth::user()->is_spam)
                                            <div class="alert alert-danger" role="alert">
                                                Tài khoản của bạn đã bị đánh dấu là spam. Bạn không thể bình luận
                                                tại thời điểm này.
                                            </div>
                                        @else
                                            <div class="tab-pane active" id="nav-mission" role="tabpanel"
                                                 aria-labelledby="nav-mission-tab">
                                                <form id="comment-form" action="{{ route('ratingpost') }}"
                                                      method="post" onsubmit="return validateForm()">
                                                    @csrf
                                                    <h4 class="mb-5 fw-bold">Comment bài viết</h4>
                                                    <div class="row g-4">
                                                        <div class="col-lg-7">
                                                            <div class="border-bottom rounded my-4">
                                    <textarea name="comment" class="form-control border-0" id="comment" cols="30"
                                              rows="5"
                                              placeholder="Comment Bài Viết  *" spellcheck="false"
                                              style="resize: none; height: 150px;"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 d-flex align-items-center">
                                                            <div
                                                                class="d-flex justify-content-between w-100 align-items-center"
                                                                style="font-size: 14px;">
                                                                <div class="d-flex align-items-center">
                                                                    <p class="mb-0 me-3">Please rate:</p>
                                                                    <div class="d-flex align-items-center"
                                                                         style="font-size: 12px;">
                                                                        <i class="fa fa-star fa-star1 text-muted"
                                                                           data-ratting="1"></i>
                                                                        <i class="fa fa-star fa-star1"
                                                                           data-ratting="2"></i>
                                                                        <i class="fa fa-star fa-star1"
                                                                           data-ratting="3"></i>
                                                                        <i class="fa fa-star fa-star1"
                                                                           data-ratting="4"></i>
                                                                        <i class="fa fa-star fa-star1"
                                                                           data-ratting="5"></i>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="ratting"
                                                                       id="ratting-input">
                                                                <input type="hidden" name="post_id"
                                                                       value="{{ $post->id }}">
                                                                <input type="hidden" name="user_id" id="user_id"
                                                                       value="{{ auth()->user()->id }}">
                                                                <button type="submit"
                                                                        class="btn border border-secondary text-primary rounded-pill px-3 py-2 ms-3">
                                                                    Post Comment
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            Bạn cần đăng nhập để thực hiện bình luận. <a
                                                href="{{ route('login') }}">Đăng nhập tại đây</a>.
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>
    </section><!-- End Blog Single Section -->
@endsection
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const stars = document.querySelectorAll('.fa-star1');
        const rattingInput = document.getElementById('ratting-input');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const ratting = this.getAttribute('data-ratting');
                rattingInput.value = ratting;

                stars.forEach(star => {
                    if (star.getAttribute('data-ratting') <= ratting) {
                        star.classList.remove('text-muted');
                        star.classList.add('text-warning');
                    } else {
                        star.classList.remove('text-warning');
                        star.classList.add('text-muted');
                    }
                });
            });
        });
        $(document).ready(function () {
            // Hiển thị thông báo thành công nếu có
            let status = @json($created);
            let title = 'Bạn đã';
            let message = status;
            let icon = 'success';
            if (status) {
                showMessage(title, message, icon);
            }

            // Hiển thị thông báo lỗi nếu có
            @if (session('error'))
            Swal.fire({
                title: 'Lỗi',
                text: '{{ session('error') }}',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
            });
            @endif
        });

        function showMessage(title, message, icon) {
            Swal.fire({
                title: title,
                text: message,
                icon: icon,
                showConfirmButton: false,
                timer: 1500
            });
        }
    </script>
@endsection
