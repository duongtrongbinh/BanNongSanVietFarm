@extends('admin.layout.master')
@section('content')

    <div class="pagetitle">
        <h1>Dashboard Order</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard')}}" class="active">Dashboard orders</a></li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-xxl-4 col-md-4 mb-4">
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
                                <h5 class="card-title">Đang chờ xử lý <span id="sales-filter-title-1">| Hôm nay</span>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="sales-order-count-1">145</h6>
                                        <span id="sales-order-increase-1"
                                              class="text-success small pt-1 fw-bold">12%</span>
                                        <span class="text-muted small pt-2 ps-1">tăng</span>
                                        <div>
                                            <span class="order-status-info-1 small text-muted"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4 mb-4">
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
                                <h5 class="card-title">Đang xử lý <span id="revenue-filter-title-1">| Tháng này</span>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="revenue-amount-1">$3,264</h6>
                                        <span id="revenue-increase-1" class="text-success small pt-1 fw-bold">8%</span>
                                        <span class="text-muted small pt-2 ps-1">tăng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4 mb-4">
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
                                <h5 class="card-title">Vận chuyển <span id="customers-filter-title-1">| Năm nay</span>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="customers-count-1">1244</h6>
                                        <span id="customers-increase-1" class="text-danger pt-1 fw-bold">100%</span>
                                        <span class="text-muted small pt-2 ps-1">giảm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4 mb-4">
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
                                <h5 class="card-title">Giao hàng <span id="sales-filter-title-3">| Hôm nay</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="sales-order-count-3">145</h6>
                                        <span id="sales-order-increase-3" class="text-success small pt-1 fw-bold">12%</span>
                                        <span class="text-muted small pt-2 ps-1">tăng</span>
                                        <div>
                                            <span class="order-status-info-3 small text-muted"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4 mb-4">
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
                                <h5 class="card-title">Đã nhận hàng <span id="revenue-filter-title-2">| Tháng này</span>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="revenue-amount-2">$3,264</h6>
                                        <span id="revenue-increase-2" class="text-success small pt-1 fw-bold">8%</span>
                                        <span class="text-muted small pt-2 ps-1">tăng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4 mb-4">
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
                                <h5 class="card-title">Hoàn thành <span id="customers-filter-title-2">| Năm nay</span>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="customers-count-2">1244</h6>
                                        <span id="customers-increase-2" class="text-success pt-1 fw-bold">15%</span>
                                        <span class="text-muted small pt-2 ps-1">tăng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4 mb-4">
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
                                <h5 class="card-title">Đã hủy <span id="customers-filter-title-3">| Năm nay</span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-x-circle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="customers-count-3">1244</h6>
                                        <span id="customers-increase-3" class="text-danger pt-1 fw-bold">100%</span>
                                        <span class="text-muted small pt-2 ps-1">giảm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4 mb-4">
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
                                <h5 class="card-title">Trả hàng hoàn tiền <span id="refund-filter-title">| Năm nay</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="refund-count">1244</h6>
                                        <span id="refund-increase" class="text-danger pt-1 fw-bold">100%</span>
                                        <span class="text-muted small pt-2 ps-1">giảm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4 mb-4">
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
                                <h5 class="card-title">Tổng đơn hàng <span id="sales-filter-title">| Hôm nay</span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-list-check"></i> <!-- Thay đổi biểu tượng tại đây -->
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
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/assets/js/dashboard/order/order.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/order/orderpending.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/order/orderprocessing.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/order/ordershipping.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/order/orderdelivery.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/order/orderreceived.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/order/orderscompleted.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/order/ordercancellation.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dashboard/order/orderreturns.js') }}"></script>
@endsection
