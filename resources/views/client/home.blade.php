@extends('client.layouts.master')
@section('title', 'Trang chủ')
@section('styles')
    <style>
        .product-div-a {
            color: inherit !important;
        }
    </style>
@endsection
@section('content')
    @php
        $updated= session('update');
    @endphp
        <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">Thực Phẩm Hữu Cơ 100%</h4>
                    <h1 class="mb-5 display-3 text-primary">Thực Phẩm Rau Củ Quả Hữu Cơ</h1>
                    <div class="position-relative mx-auto">
                        <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number"
                               placeholder="Search">
                        <button type="submit"
                                class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100"
                                style="top: 0; right: 25%;">Submit Now
                        </button>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            @foreach ($banners as $index => $row)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }} rounded">
                                    <img src="{{ $row->image }}" class="img-fluid w-100 h-100 bg-secondary rounded"
                                         alt="Slide {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                                data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                                data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- Featurs Section Start -->
    <div class="container-fluid featurs py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-car-side fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Miễn Phí Giao Hàng</h5>
                            <p class="mb-0">Đơn hàng từ 500,000 VNĐ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-user-shield fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Thanh Toán Bảo Mật</h5>
                            <p class="mb-0">Bảo mật thông tin 100%</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-exchange-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Hoàn Trả Trong 7 Ngày </h5>
                            <p class="mb-0">Bảo đảm hoàn tiền trong 7 ngày</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fa fa-phone-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Hỗ Trợ 24/7</h5>
                            <p class="mb-0">Hỗ trợ nhanh chóng mọi lúc</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featurs Section End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-6 text-start">
                        <h1>Sản phẩm</h1>
                    </div>
                    <div class="col-lg-6 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-0">
                                    <span class="text-dark" style="width: 130px;">Tất cả</span>
                                </a>
                            </li>
                            @foreach ($categories as $key => $category)
                                <li class="nav-item">
                                    <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-{{ $key + 1 }}">
                                        <span class="text-dark" style="width: 130px;">{{ $category->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-0" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @foreach ($products as $product)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <a href="{{ route('product', $product->slug) }}">
                                                <div class="rounded position-relative fruite-item border border-secondary">
                                                    <div class="fruite-img" style="height: 215px">
                                                        <img src="{{ $product->image }}" class="img-fluid w-100 rounded-top" alt="">
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">{{ $product->category->name }}</div>
                                                    <div class="p-4 border-top-0 rounded-bottom">
                                                        <h4 class="text-truncate" data-toggle="tooltip" data-placement="top" title="{{ $product->name }}">{{ $product->name }}</h4>
                                                        <p class="text-truncate">{{ $product->description }}</p>
                                                        <div class="flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-2">{{ number_format($product->price_sale) }} VNĐ</p>
                                                            <a class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart" data-url="{{ route('cart.add') }}" data-id="{{ $product->id }}" data-quantity="1">
                                                                <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                Thêm vào giỏ
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="justify-content-between mt-5">
                                    <a href="{{ route('shop') }}" class="btn text-white" style="background: #81c408;">Xem thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($categories as $key => $category)
                        <div id="tab-{{ $key + 1 }}" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        @foreach ($category->products as $product)
                                            <div class="col-md-6 col-lg-4 col-xl-3">
                                                <a href="{{ route('product', $product->slug) }}">
                                                    <div class="rounded position-relative fruite-item border border-secondary">
                                                        <div class="fruite-img" style="height: 215px">
                                                            <img src="{{ $product->image }}" class="img-fluid w-100 rounded-top">
                                                        </div>
                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">{{ $product->category->name }}</div>
                                                        <div class="p-4 border-top-0 rounded-bottom">
                                                            <h4 class="text-truncate" data-toggle="tooltip" data-placement="top" title="{{ $product->name }}">{{ $product->name }}</h4>
                                                            <p class="text-truncate">{{ $product->description }}</p>
                                                            <div class="justify-content-between flex-lg-wrap">
                                                                <p class="text-dark fs-5 fw-bold mb-1">{{ number_format($product->price_sale) }} VNĐ</p>
                                                                <a class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart" data-url="{{ route('cart.add') }}" data-id="{{ $product->id }}" data-quantity="1">
                                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                    Thêm vào giỏ
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="justify-content-between mt-5">
                                        <a href="{{ route('category', $category->slug) }}" class="btn text-white" style="background: #81c408;">Xem thêm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->


    <!-- Featurs Start -->
    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <a href="#">
                        <div class="service-item bg-secondary rounded border border-secondary">
                            <img src="{{ asset('client/assets/img/featur-1.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                            <div class="px-4 rounded-bottom">
                                <div class="service-content bg-primary text-center p-4 rounded">
                                    <h5 class="text-white">Fresh Apples</h5>
                                    <h3 class="mb-0">20% OFF</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#">
                        <div class="service-item bg-dark rounded border border-dark">
                            <img src="{{ asset('client/assets/img/featur-2.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                            <div class="px-4 rounded-bottom">
                                <div class="service-content bg-light text-center p-4 rounded">
                                    <h5 class="text-primary">Tasty Fruits</h5>
                                    <h3 class="mb-0">Free delivery</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#">
                        <div class="service-item bg-primary rounded border border-primary">
                            <img src="{{ asset('client/assets/img/featur-3.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                            <div class="px-4 rounded-bottom">
                                <div class="service-content bg-secondary text-center p-4 rounded">
                                    <h5 class="text-white">Exotic Vegitable</h5>
                                    <h3 class="mb-0">Discount 30$</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Featurs End -->


    <!-- Vesitable Shop Start-->
    <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h1 class="mb-0">Fresh Organic Vegetables</h1>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                <div class="border border-primary rounded position-relative vesitable-item">
                    <div class="vesitable-img">
                        <img src="{{ asset('client/assets/img/vegetable-item-6.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                    <div class="p-4 rounded-bottom">
                        <h4>Parsely</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="border border-primary rounded position-relative vesitable-item">
                    <div class="vesitable-img">
                        <img src="{{ asset('client/assets/img/vegetable-item-1.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                    <div class="p-4 rounded-bottom">
                        <h4>Parsely</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="border border-primary rounded position-relative vesitable-item">
                    <div class="vesitable-img">
                        <img src="{{ asset('client/assets/img/vegetable-item-3.png') }}" class="img-fluid w-100 rounded-top bg-light" alt="">
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                    <div class="p-4 rounded-bottom">
                        <h4>Banana</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="border border-primary rounded position-relative vesitable-item">
                    <div class="vesitable-img">
                        <img src="{{ asset('client/assets/img/vegetable-item-4.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                    <div class="p-4 rounded-bottom">
                        <h4>Bell Papper</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="border border-primary rounded position-relative vesitable-item">
                    <div class="vesitable-img">
                        <img src="{{ asset('client/assets/img/vegetable-item-5.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                    <div class="p-4 rounded-bottom">
                        <h4>Potatoes</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="border border-primary rounded position-relative vesitable-item">
                    <div class="vesitable-img">
                        <img src="{{ asset('client/assets/img/vegetable-item-6.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                    <div class="p-4 rounded-bottom">
                        <h4>Parsely</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="border border-primary rounded position-relative vesitable-item">
                    <div class="vesitable-img">
                        <img src="{{ asset('client/assets/img/vegetable-item-5.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                    <div class="p-4 rounded-bottom">
                        <h4>Potatoes</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="border border-primary rounded position-relative vesitable-item">
                    <div class="vesitable-img">
                        <img src="{{ asset('client/assets/img/vegetable-item-6.jpg') }}" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                    <div class="p-4 rounded-bottom">
                        <h4>Parsely</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod te incididunt</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">$7.99 / kg</p>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vesitable Shop End -->


    <!-- Banner Section Start-->
    <div class="container-fluid banner bg-secondary my-5">
        <div class="container py-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="py-4">
                        <h1 class="display-3 text-white">Fresh Exotic Fruits</h1>
                        <p class="fw-normal display-3 text-dark mb-4">in Our Store</p>
                        <p class="mb-4 text-dark">The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic words etc.</p>
                        <a href="#" class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">BUY</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="{{ asset('client/assets/img/baner-1.png') }}" class="img-fluid w-100 rounded" alt="">
                        <div class="d-flex align-items-center justify-content-center bg-white rounded-circle position-absolute" style="width: 140px; height: 140px; top: 0; left: 0;">
                            <h1 style="font-size: 100px;">1</h1>
                            <div class="d-flex flex-column">
                                <span class="h2 mb-0">50$</span>
                                <span class="h4 text-muted mb-0">kg</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Section End -->


    <!-- Bestsaler Product Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                <h1 class="display-4">Top sản phẩm bán chạy</h1>
                <p>Các sản phẩm bán chạy này được lựa chọn dựa trên số lượng bán ra, đánh giá tích cực từ khách hàng và mức độ phổ biến.</p>
            </div>
            <div class="row g-4">
                @foreach ($top6Products as $product)
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <img src="{{ $product->image }}" class="img-fluid rounded-circle w-100" alt="">
                                </div>
                                <div class="col-6 text-truncate">
                                    <a href="{{ route('product', $product->slug) }}" class="h5" data-toggle="tooltip" data-placement="top" title="{{ $product->name }}">{{ $product->name }}</a>
                                    @php
                                        $totalRatting = 0;
                                        $totalCount = count($product->comments);

                                        foreach ($product->comments as $comment) {
                                            $totalRatting += $comment->ratting;
                                        }
                                        $averageRatting = $totalCount > 0 ? $totalRatting / $totalCount : 0;
                                    @endphp
                                    <div class="d-flex my-3">
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
                                    <h4 class="mb-3" data-toggle="tooltip" data-placement="top" title="{{ number_format($product->price_sale) }} VNĐ">{{ number_format($product->price_sale) }} VNĐ</h4>
                                    <a class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart" data-url="{{ route('cart.add') }}" data-id="{{ $product->id }}" data-quantity="1">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                        Thêm vào giỏ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @foreach ($next4Products as $product)
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="text-center">
                            <img src="{{ $product->image }}" class="img-fluid rounded" alt="">
                            <div class="py-4 text-truncate">
                                <a href="{{ route('product', $product->slug) }}" class="h5" data-toggle="tooltip" data-placement="top" title="{{ $product->name }}">{{ $product->name }}</a>
                                @php
                                    $totalRatting = 0;
                                    $totalCount = count($product->comments);

                                    foreach ($product->comments as $comment) {
                                        $totalRatting += $comment->ratting;
                                    }
                                    $averageRatting = $totalCount > 0 ? $totalRatting / $totalCount : 0;
                                @endphp
                                <div class="d-flex my-3 justify-content-center">
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
                                <h4 class="mb-3" data-toggle="tooltip" data-placement="top" title="{{ number_format($product->price_sale) }} VNĐ">{{ number_format($product->price_sale) }} VNĐ</h4>
                                <a class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart" data-url="{{ route('cart.add') }}" data-id="{{ $product->id }}" data-quantity="1">
                                    <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                    Thêm vào giỏ
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Bestsaler Product End -->


    <!-- Fact Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="bg-light p-5 rounded">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>satisfied customers</h4>
                            <h1>1963</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>quality of service</h4>
                            <h1>99%</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>quality certificates</h4>
                            <h1>33</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>Available Products</h4>
                            <h1>789</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact Start -->
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('.pagination a').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $('#initiated').load(url + ' div#initiated');
            });
        });
    </script>
@endsection
