@extends('client.layouts.master')
@section('title', $brand->name)
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">{{ $brand->name }}</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('brand', $brand->slug) }}" class="active">{{ $brand->name }}</a></li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">{{ $brand->name }}</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <form action="{{ route('brand', $brand->slug) }}" method="GET">
                        <div class="row g-4">
                            <div class="col-xl-3">
                                <div class="input-group w-100 mx-auto d-flex">
                                    <input type="text" class="form-control p-3" name="search" value="{{ request()->input('search') }}" placeholder="Tìm kiếm..." aria-describedby="search-icon-1">
                                    <button type="submit" id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <div class="col-6"></div>
                            <div class="col-xl-3">
                                <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                    <label for="fruits">Sắp xếp:</label>
                                    <select id="sort" name="sort" class="border-0 form-select-sm bg-light me-3" onchange="this.form.submit()">
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                        <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Giá cao đến thấp</option>
                                        <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                        <option value="best_selling" {{ request('sort') == 'best_selling' ? 'selected' : '' }}>Bán chạy</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-3">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4>Thương hiệu</h4>
                                            <ul class="list-unstyled fruite-categorie">
                                                @foreach ($brands as $brand)
                                                    @if ($brand->products->isNotEmpty())
                                                        <li>
                                                            <div class="d-flex justify-content-between fruite-name">
                                                                <div>
                                                                    <a href="{{ route('brand', $brand->slug) }}" class="{{ $brand->slug == request()->route('slug') ? 'text-decoration-underline' : '' }}">
                                                                        {{ $brand->name }}
                                                                    </a>
                                                                </div>
                                                                <span>({{ count($brand->products) }})</span>
                                                            </div>
                                                        </li>  
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4>Danh mục</h4>
                                            <ul class="list-unstyled fruite-categorie">
                                                @foreach ($categories as $category)
                                                    @if ($category->products->isNotEmpty())
                                                        <li>
                                                            <div class="d-flex justify-content-between fruite-name">
                                                                <div>
                                                                    <input type="checkbox" name="categories[]" value="{{ $category->slug }}" {{ in_array($category->slug, (array)request()->input('categories', [])) ? 'checked' : '' }}>
                                                                    <a href="{{ route('category', $category->slug) }}">
                                                                        {{ $category->name }}
                                                                    </a>
                                                                </div>
                                                                <span>({{ count($category->products) }})</span>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4 class="mb-2">Giá (VNĐ)</h4>
                                            <div class="col">
                                                <label for="minPrice">Giá từ:</label>
                                                <input type="number" id="minPrice" name="minPrice" class="form-control" value="{{ request('minPrice') ?? 0 }}">
                                            </div>
                                            <div class="col">
                                                <label for="maxPrice">Đến:</label>
                                                <input type="number" id="maxPrice" name="maxPrice" class="form-control" value="{{ request('maxPrice') ?? (int)$priceLimits->max_price }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-danger rounded-pill">
                                                <i class="bi bi-funnel"></i>
                                                Lọc
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <h4 class="mb-3">Sản phẩm bán chạy</h4>
                                        <div class="d-flex align-items-center justify-content-start">
                                            <div class="rounded me-4" style="width: 100px; height: 100px;">
                                                <img src="{{ asset('client/assets/img/featur-1.jpg') }}" class="img-fluid rounded" alt="">
                                            </div>
                                            <div>
                                                <h6 class="mb-2">Big Banana</h6>
                                                <div class="d-flex mb-2">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="d-flex mb-2">
                                                    <h5 class="fw-bold me-2">2.99 $</h5>
                                                    <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center my-4">
                                            <a href="#" class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Xem thêm</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="position-relative">
                                            <img src="{{ asset('client/assets/img/banner-fruits.jpg') }}" class="img-fluid w-100 rounded" alt="">
                                            <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                                <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row g-4">
                                    @foreach ($products as $product)
                                        <div class="col-md-6 col-lg-6 col-xl-4">
                                            <a href="{{ route('product', $product) }}">
                                                <div class="rounded position-relative fruite-item border border-secondary">
                                                    <div class="fruite-img" style="height: 215px">
                                                        <img src="{{ $product->image }}" class="img-fluid w-100 rounded-top" alt="">
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">{{ $product->category->name }}</div>
                                                    <div class="p-4 border-top-0 rounded-bottom">
                                                        <h4 class="text-truncate" data-toggle="tooltip" data-placement="top" title="{{ $product->name }}">{{ $product->name }}</h4>
                                                        <p class="text-truncate">{{ $product->description }}</p>
                                                        <div class="d-flex justify-content-center flex-lg-wrap">
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
                                {{ $products->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
@endsection