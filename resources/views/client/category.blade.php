@extends('client.layouts.master')
@section('title', $category->name)
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">{{ $category->name }}</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category', $category->slug) }}" class="active">{{ $category->name }}</a></li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">{{ $category->name }}</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <form action="{{ route('category', $category->slug) }}" method="GET">
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
                                            <ul class="list-unstyled fruite-categorie overflow-auto" style="height: 200px;">
                                                @foreach ($brands as $brand)
                                                    @if ($brand->products->isNotEmpty())
                                                        <li>
                                                            <div class="d-flex justify-content-between fruite-name">
                                                                <div>
                                                                    <input type="checkbox" name="brands[]" value="{{ $brand->slug }}" {{ in_array($brand->slug, (array)request()->input('brands', [])) ? 'checked' : '' }}>
                                                                    <a href="{{ route('brand', $brand->slug) }}">
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
                                            <ul class="list-unstyled fruite-categorie overflow-auto" style="height: 200px;">
                                                @foreach ($categories as $category)
                                                    @if ($category->products->isNotEmpty())
                                                        <li>
                                                            <div class="d-flex justify-content-between fruite-name">
                                                                <div>
                                                                    <a href="{{ route('category', $category->slug) }}" class="{{ $category->slug == request()->route('slug') ? 'text-decoration-underline' : '' }}">
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
                                            <div class="col mt-3">
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
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row g-4">
                                    @foreach ($products as $product)
                                        <div class="col-md-6 col-lg-6 col-xl-4">
                                            <a href="{{ route('product', $product->slug) }}">
                                                <div class="rounded position-relative fruite-item border border-secondary">
                                                    <div class="fruite-img" style="height: 215px">
                                                        <img src="{{ $product->image }}" class="img-fluid w-100 rounded-top" alt="">
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">{{ $product->category->name }}</div>
                                                    <div class="p-4 border-top-0 rounded-bottom">
                                                        <h4 class="text-truncate" data-toggle="tooltip" data-placement="top" title="{{ $product->name }}">{{ $product->name }}</h4>
                                                        <p class="text-truncate">{{ $product->description }}</p>
                                                        <div class="text-center flex-lg-wrap">
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