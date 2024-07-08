@extends('client.layouts.master')
@section('title', 'Product')
@section('css')
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
            max-width: 100%;
        }

    </style>
@endsection
@section('content')
    @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">{{ $product->name }}</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product', $product->slug) }}" class="active">Sản phẩm</a></li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{ $product->image }}" class="d-block w-100" alt="...">
                                        </div>
                                        @foreach ($product->product_images as $product_image)
                                            <div class="carousel-item">
                                                <img src="{{ $product_image->image }}" class="d-block w-100" alt="...">
                                            </div>
                                        @endforeach

                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                            data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                  </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3">{{ $product->name }}</h4>
                            <p class="mb-3">Thương hiệu: {{ $product->brand->name }}</p>
                            <p class="mb-3">Loại: {{ $product->category->name }}</p>
                            <h5 class="fw-bold mb-3">{{ number_format($product->price_sale) }} VND</h5>
                            <p class="mb-4">{{ $product->description }}</p>
                            <div class="d-flex">
                                @foreach ($product->tags as $tag)
                                    <p>#{{ $tag->name }},</p>
                                @endforeach
                            </div>
                            @php
                                $totalRatting = 0;
                                $totalCount = count($product->comments);

                                foreach ($product->comments as $comment) {
                                    $totalRatting += $comment->ratting;
                                }
                                $averageRatting = $totalCount > 0 ? $totalRatting / $totalCount : 0;
                            @endphp
                            <div class="d-flex mb-4 align-items-center">
                                <div class="me-2">
                                    @php
                                        $fullStars = floor($averageRatting); // Số sao nguyên
                                        $halfStar = ceil($averageRatting - $fullStars); // Số sao nửa
                                        $emptyStars = 5 - $fullStars - $halfStar; // Số sao trống
                                    @endphp

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
                            <div class="input-group quantity mb-5" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm text-center border-0" value="1">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <p>{{ $product->quantity }} sản phẩm có sẵn</p>
                            <a class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary add-to-cart" data-url="{{ route('cart.add') }}" data-id="{{ $product->id }}" data-quantity="1">
                                <i class="fa fa-shopping-bag me-2 text-primary"></i> 
                                Thêm vào giỏ
                            </a>
                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                        id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="true">Chi tiết</button>
                                    <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                            id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                            aria-controls="nav-mission" aria-selected="false">Reviews
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    {!!  $product->content !!}
                                </div>
                                <div class="tab-pane" id="nav-mission" role="tabpanel"
                                     aria-labelledby="nav-mission-tab">
                                    <div class="container">
                                        <h4>{{ $product->comments()->count() }} Bình luận</h4>
                                        @foreach($product->comments as $comment)
                                            <div class="d-flex mb-4">
                                                <img src="{{ asset($comment->user->avatar) }}"
                                                     class="img-fluid rounded-circle p-3"
                                                     style="width: 100px; height: 100px;"
                                                     alt="">
                                                <div>
                                                    <p class="mb-2" style="font-size: 14px;">{{ $comment->created_at->format('F j, Y') }}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <h5>{{ $comment->user->name }}</h5>
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
                                                                    <i class="fa fa-star text-warning" data-rating="{{ $i }}"></i>
                                                                @endfor
                                                                @if ($halfStar > 0)
                                                                    <i class="fa fa-star-half-alt text-warning" data-rating="{{ $fullStars + 1 }}"></i>
                                                                @endif
                                                                @for ($j = 1; $j <= $emptyStars; $j++)
                                                                    <i class="fa fa-star" data-rating="{{ $fullStars + $halfStar + $j }}"></i>
                                                                @endfor
                                                                <p class="mb-0">
                                                                    {{ number_format($averageRatting, 1) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p>{{ $comment->content }}</p>
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                                <div class="tab-pane" id="nav-vision" role="tabpanel">
                                    <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et
                                        tempor sit. Aliqu diam
                                        amet diam et eos labore. 3</p>
                                    <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos
                                        labore.
                                        Clita erat ipsum et lorem et sit</p>
                                </div>
                            </div>
                        </div>
                        <form id="comment-form" action="{{ route('rating', $product->id) }}" method="post"
                              onsubmit="return validateForm()">
                            @csrf
                            <h4 class="mb-5 fw-bold">Comment bài viết</h4>
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="border-bottom rounded my-4">
                                        <textarea name="comment" class="form-control border-0" id="comment" cols="30"
                                                  rows="8" placeholder="Comment Bài Viết  *" spellcheck="false"
                                                  required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between py-3 mb-5">
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0 me-3">Please rate:</p>
                                            <div class="d-flex align-items-center" style="font-size: 12px;">
                                                <i class="fa fa-star fa-star1 text-muted" data-ratting="1"></i>
                                                <i class="fa fa-star fa-star1" data-ratting="2"></i>
                                                <i class="fa fa-star fa-star1" data-ratting="3"></i>
                                                <i class="fa fa-star fa-star1" data-ratting="4"></i>
                                                <i class="fa fa-star fa-star1" data-ratting="5"></i>
                                            </div>
                                        </div>
                                        <input type="hidden" name="ratting" id="ratting-input">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="user_id" id="user_id"
                                               value="{{ auth()->check() ? auth()->user()->id : '' }}">
                                        <button type="submit"
                                                class="btn border border-secondary text-primary rounded-pill px-4 py-3">
                                            Post Comment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <h1 class="fw-bold mb-0">Sản phẩm liên quan</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach ($relatedProduct as $key => $related)
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <a href="{{ route('product', $related->products->slug) }}">
                                <div class="vesitable-img">
                                    <img src="{{ $related->products->image }}" class="img-fluid w-100 rounded-top">
                                </div>
                                <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">{{ $related->products->category->name }}</div>
                                <div class="p-4 pb-0 rounded-bottom">
                                    <h4 class="text-truncate">{{ $related->products->name }}</h4>
                                    <p class="text-truncate">{{ $related->products->description }}</p>
                                    <div class="text-center flex-lg-wrap">
                                        <p class="text-dark fs-5 fw-bold">{{ number_format($related->products->price_sale) }} VNĐ</p>
                                        <a class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary add-to-cart" data-url="{{ route('cart.add') }}" data-id="{{ $product->id }}" data-quantity="1">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> 
                                            Thêm vào giỏ
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        const stars = document.querySelectorAll('.fa-star1');
        const rattingInput = document.getElementById('ratting-input');

        stars.forEach(star => {
            star.addEventListener('click', function() {
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

        function validateForm() {
            var hasCommented = false; // Biến để kiểm tra người dùng đã bình luận chưa
            var rattingInput = document.getElementById('ratting-input');
            var userId = document.getElementById('user_id').value;

            // Kiểm tra xem đã chọn rating chưa
            if (rattingInput.value === "") {
                alert("Please select a rating.");
                return false;
            }

            // Kiểm tra xem người dùng đã đăng nhập chưa
            if (userId === '') {
                alert('Bạn cần đăng nhập để thực hiện thao tác này.');
                return false;
            }
            if (hasCommented) {
                alert('Bạn đã bình luận sản phẩm này rồi.');
                return false;
            }
            // Nếu đã đăng nhập và đã chọn rating, cho phép submit form
            return true;
        }
    </script>
@endsection
@section('js')
<script src="path-to-your-tinymce/tinymce.min.js"></script>

@endsection
