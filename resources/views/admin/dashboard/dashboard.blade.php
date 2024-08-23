@extends('admin.layout.master')
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
                            <div class="card-body">
                                <h5 class="card-title">Bán hàng<span>| Hôm nay</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="sales-order-count">145</h6>
                                        <span id="sales-order-increase" class="text-success small pt-1 fw-bold">12%</span>
                                        <span class="text-muted small pt-2 ps-1">tăng</span>
                                        <div>
                                            <span class="order-status-info small text-muted"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Doanh thu <span>| Hôm nay</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
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
                            <div class="card-body">
                                <h5 class="card-title">Khách hàng <span>| Hôm nay</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
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
                    <div class="col-12">
                        <div class="card info-card warehouse-card">
                            <div class="card-body">
                                <h5 class="card-title">Thống kê Kho hàng <span>| Hôm nay</span></h5>
                                <div class="row">
                                    <!-- Tổng số phiếu nhập hàng -->
                                    <div class="col-md-4 text-center">
                                        <div class="stat-box">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </div>
                                            <h6 id="total-receipts-today">0</h6>
                                            <span id="receipts-percentage-change" class="text-success small pt-1 fw-bold">0%</span>
                                            <span class="text-muted small pt-2 ps-1">Phiếu nhập hàng</span>
                                        </div>
                                    </div>
                                    <!-- Tổng số lượng sản phẩm nhập kho -->
                                    <div class="col-md-4 text-center">
                                        <div class="stat-box">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-box-seam"></i>
                                            </div>
                                            <h6 id="total-quantity-today">0</h6>
                                            <span id="quantity-percentage-change" class="text-success small pt-1 fw-bold">0%</span>
                                            <span class="text-muted small pt-2 ps-1">Số lượng sản phẩm</span>
                                        </div>
                                    </div>
                                    <!-- Tổng giá trị sản phẩm nhập kho -->
                                    <div class="col-md-4 text-center">
                                        <div class="stat-box">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-currency-dollar"></i>
                                            </div>
                                            <h6 id="total-value-today">0 VND</h6>
                                            <span id="value-percentage-change" class="text-success small pt-1 fw-bold">0%</span>
                                            <span class="text-muted small pt-2 ps-1">Giá trị sản phẩm</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Báo cáo <span>| Hôm nay</span></h5>
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
    <script src="{{ asset('admin/assets/js/dashboard/order/order.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/user/user.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/total.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/dashboard.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/purchase_receipts/purchase_receipts.js') }}"></script>
@endsection
