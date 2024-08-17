@extends('admin.layout.master')
@section('title', 'Dashboard')
@section('content')

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard')}}" class="active">Dashboard</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Bán hàng -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="filter sales-filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Bộ lọc</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#" data-filter="day">Hôm nay</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="month">Tháng này</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="year">Năm nay</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a href="{{route('dashboardorder.orders')}}">Bán hàng </a><span
                                        id="sales-filter-title">| Hôm nay</span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="sales-order-count">145</h6>
                                        <span id="sales-order-increase"
                                              class="text-success small pt-1 fw-bold">12%</span>
                                        <span class="text-muted small pt-2 ps-1">tăng</span>
                                        <div>
                                            <span class="order-status-info small text-muted"></span>
                                            <!-- Thêm class nhỏ cho chữ -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="filter revenue-filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Bộ lọc</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#" data-filter="day">Ngày hôm nay</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="month">Tháng này</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="year">Năm nay</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Doanh thu <span id="revenue-filter-title">| Tháng này</span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="revenue-amount">$3,264</h6>
                                        <span id="revenue-increase" class="text-success small pt-1 fw-bold">8%</span>
                                        <span class="text-muted small pt-2 ps-1">tăng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="filter customers-filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Bộ lọc</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#" data-filter="day">Hôm nay</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="month">Tháng này</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="year">Năm nay</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Khách hàng <span id="customers-filter-title">| Năm nay</span>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="customers-count">1244</h6>
                                        <span id="customers-increase" class="text-danger pt-1 fw-bold">100%</span>
                                        <span class="text-muted small pt-2 ps-1">giảm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card promotion-card">
                            <div class="filter promotion-filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Bộ lọc</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#" data-filter="day">Hôm nay</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="month">Tháng này</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="year">Năm nay</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Khuyến mãi <span id="promotion-filter-title">| Tháng này</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-gift"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="promotion-count">5</h6>
                                        <span id="promotion-increase" class="text-success small pt-1 fw-bold">20%</span>
                                        <span class="text-muted small pt-2 ps-1">tăng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#" data-filter="day">Today</a></li>
                                <li><a class="dropdown-item" href="#" data-filter="month">This Month</a></li>
                                <li><a class="dropdown-item" href="#" data-filter="year">This Year</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Báo cáo <span id="reports-filter-title">| Today</span></h5>
                            <div id="reportsChart"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">

                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="card-title">Top sản phẩn bán chạy</h5>
                        @foreach($topProducts as $product)
                            <div class="news">
                                <div class="post-item clearfix">
                                    @if($product->product->image)
                                        <img src="{{ asset($product->product->image) }}"  width="100">
                                    @else
                                        <img src="{{  asset('client/assets/img/NoImage.png') }}" alt="No Image Available" width="100">
                                    @endif
                                    {{ $product->product->name }}
                                    <p>Odit ut eveniet modi reiciendis. Atque cupiditate libero beatae dignissimos eius...</p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div><!-- End News & Updates -->

            </div><!-- End Right side columns -->

        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/assets/js/dashboard/order.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/user/user.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/total.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/dashboard.js') }}"></script>
@endsection
