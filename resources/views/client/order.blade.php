@extends('client.layouts.master')
@section('title', 'Đơn Hàng ')
@section('styles')
    <!-- Vendor CSS Files -->
    <link href="{{ asset('admin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    <style>
        .nav {
            display: flex;
            flex-wrap: wrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }

        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .nav-tabs .nav-item {
            flex: 1 1 auto;
        }

        .nav-tabs .nav-link {
            width: 100%;
            margin-bottom: -1px;
            background: none;
            border: none;
        }

        .nav.nav-tabs .nav-link.active {
            border-bottom: 2px solid #81c408 !important;
        }

        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
            color: #81c408;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }

        .nav-link {
            display: block;
            padding: 0.5rem 1rem;
            color: #495057;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }

        .search-bar {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .order-header {
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .order-header .d-flex {
            align-items: center;
        }

        .order-header span {
            font-size: 0.9rem;
        }

        .order-header .separator {
            color: #6c757d;
            font-weight: bold;
        }

        .order-header .badge {
            font-size: 0.8rem;
            padding: 0.25em 0.5em;
        }

        .order-body {
            margin: 5px 0;
            padding: 0 15px;
            max-height: 236px;
        }

        .order-footer {
            padding: 10px 15px;
            border-top: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .pagination a.active, .pagination a:hover {
            background-color: #81c408;
            color: #000000;
            border-color: 1px solid #81c408;
        }
    </style>
@endsection
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Đơn hàng</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#"> Đơn hàng </a></li>
        </ol>
    </div>
    <!-- End Page Title -->
    <section class="container-lg section" style="margin-top:50px;">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all-orders" data-status="">
                                <i class="ri-store-2-fill me-1 align-bottom"></i>
                                Tất cả
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipping" data-status="2">
                                <i class="ri-truck-fill me-1 align-bottom"></i> 
                                Vận chuyển
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipped" data-status="3">
                                <i class="ri-takeaway-fill me-1 align-bottom"></i> 
                                Giao hàng
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#completed" data-status="5">
                                <i class="ri-checkbox-circle-fill me-1 align-bottom"></i> 
                                Hoàn thành
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cancelled" data-status="6">
                                <i class="ri-close-circle-fill me-1 align-bottom"></i> 
                                Đã hủy
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#returned" data-status="7">
                                <i class="ri-reply-fill me-1 align-bottom"></i> 
                                Trả hàng/Hoàn tiền
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">
                        <!-- All Orders -->
                        <div class="tab-pane fade show active all-orders" id="all-orders">
                            <div class="search-bar">
                                <input type="text" id="search-input" class="form-control" placeholder="Bạn có thể tìm kiếm theo mã đơn hàng">
                            </div>
                            <!-- Order Item 1 -->
                            <div id="order-list" class="order-item">
                                <!-- Orders will be loaded here via AJAX -->
                            </div>
                            <!-- Pagination -->
                            <div id="pagination" class="pagination">
                                <!-- Pagination links will be loaded here via AJAX -->
                            </div>
                        </div>
                        <!-- Shipping -->
                        <div class="tab-pane fade shipping pt-3" id="shipping">
                            <div id="shipping-orders" class="order-item">
                                <!-- Orders will be loaded here via AJAX -->
                            </div>
                            <!-- Pagination -->
                            <div id="shipping-pagination" class="pagination">
                                <!-- Pagination links will be loaded here via AJAX -->
                            </div>
                        </div>
                        <!-- Shipped -->
                        <div class="tab-pane fade shipped pt-3" id="shipped">
                            <div id="shipped-orders" class="order-item">
                                <!-- Orders will be loaded here via AJAX -->
                            </div>
                            <!-- Pagination -->
                            <div id="shipped-pagination" class="pagination">
                                <!-- Pagination links will be loaded here via AJAX -->
                            </div>
                        </div>
                        <!-- Completed -->
                        <div class="tab-pane fade completed pt-3" id="completed">
                            <div id="completed-orders" class="order-item">
                                <!-- Orders will be loaded here via AJAX -->
                            </div>
                            <!-- Pagination -->
                            <div id="completed-pagination" class="pagination">
                                <!-- Pagination links will be loaded here via AJAX -->
                            </div>
                        </div>
                        <!-- Cancelled -->
                        <div class="tab-pane fade cancelled pt-3" id="cancelled">
                            <div id="cancelled-orders" class="order-item">
                                <!-- Orders will be loaded here via AJAX -->
                            </div>
                            <!-- Pagination --> 
                            <div id="cancelled-pagination" class="pagination">
                                <!-- Pagination links will be loaded here via AJAX -->
                            </div>
                        </div>
                        <!-- Returned -->
                        <div class="tab-pane fade returned pt-3" id="returned">
                            <div id="returned-orders" class="order-item">
                                <!-- Orders will be loaded here via AJAX -->
                            </div>
                            <!-- Pagination -->
                            <div id="returned-pagination" class="pagination">
                                <!-- Pagination links will be loaded here via AJAX -->
                            </div>
                        </div>
                    </div>
                    <!-- End Bordered Tabs -->
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Format mmoney
            function formatNumber(number) {
                // // Chuyển đổi số thành chuỗi và loại bỏ các chữ số thập phân không cần thiết
                let formattedNumber = Math.floor(number);

                // // Định dạng chuỗi số thành số có dấu phân cách hàng nghìn
                return Number(formattedNumber).toLocaleString('en-US');
            }

            // Hàm để render đơn hàng
            function renderOrders(orders, statusData, container, paginationContainer) {
                window.scroll(0, 0);
                let ordersHtml = '';

                if (orders.length > 0) {
                    orders.forEach(order => {
                        const status = statusData[order.status] || { label: 'Không xác định', badgeClass: 'badge bg-danger-subtle text-danger text-uppercase' };
                        let orderItemsHtml = '';

                        order.order_details.forEach(detail => {
                            orderItemsHtml += `
                                <div class="d-flex border-bottom py-3">
                                    <img src="${detail.image}" class="product-image me-3">
                                    <div>
                                        <a href="/san-pham/${detail.product.slug}" class="mb-1">${detail.name}</a>
                                        <p class="text-muted mb-0">Danh mục: ${detail.product.category.name}</p>
                                        <p class="mb-0">x${detail.quantity}</p>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <del class="text-muted">${formatNumber(detail.price_regular)} VNĐ</del>
                                        <p class="text-danger mb-0"><b>${formatNumber(detail.price_sale)} VNĐ</b></p>
                                    </div>
                                </div>
                            `;
                        });

                        ordersHtml += `
                            <div class="border-top border-bottom mb-5">
                                <div class="order-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>#${order.order_code}</h5>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="text-success me-2">
                                            ${new Date(order.created_at).toLocaleString('vi-VN', { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' })}
                                        </span>
                                        <span class="separator me-2">|</span>
                                        <span class="${status.badgeClass}">
                                            ${status.label}
                                        </span>
                                    </div>
                                </div>
                                <div class="overflow-auto order-body">
                                    ${orderItemsHtml}
                                </div>
                                <div class="order-footer d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="/chi-tiet-don-hang/${order.id}" class="btn btn-secondary">Xem chi tiết</a>
                                    </div>
                                    <div class="d-flex">
                                        <p class="me-1">Thành tiền:</p>
                                        <h5 class="text-danger">${formatNumber(order.after_total_amount)} VNĐ</h5>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    ordersHtml += `
                        <div id="no-orders-message h-100" style="text-align: center;">
                            <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/orderlist/5fafbb923393b712b964.png" alt="Clipboard icon" style="width: 100px; height: 100px;">
                            <p>Chưa có đơn hàng</p>
                        </div>
                    `;

                    $(paginationContainer).hide();
                }

                $(container).html(ordersHtml);
            }

            // Hàm để cập nhật phân trang
            function updatePagination(pagination, container) {
                let paginationHtml = '';

                pagination.links.forEach(link => {
                    paginationHtml += `
                        <a href="#" class="page-link ${link.active ? 'active' : ''}" data-page="${link.url}">
                            ${link.label}
                        </a>
                    `;
                });

                $(container).html(paginationHtml);
            }

            // Hàm để tải đơn hàng
            function fetchOrders(status = '', container = '#order-list', paginationContainer = '#pagination') {
                $.ajax({
                    url: '{{ route('fetch.orders') }}',
                    method: 'GET',
                    data: { 
                        status: status
                    },
                    success: function(response) {
                        if (response.error) {
                            console.error('Error:', response.error);
                            return;
                        }
                        
                        renderOrders(response.orders.data, response.statusData, container);
                        if (response.orders.data.length > 0) {
                            updatePagination(response.orders, paginationContainer);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        console.log(xhr.responseText); // In ra thông tin phản hồi lỗi từ server
                    }
                });
            }

            // Load dữ liệu cho tab mặc định
            fetchOrders();

            // Sự kiện khi người dùng chuyển tab
            $('button[data-bs-toggle="tab"]').on('click', function() {
                const status = $(this).data('status');
                const targetId = $(this).data('bs-target').substring(1); // Loại bỏ dấu #
                const container = `#${targetId}-orders`;
                const paginationContainer = `#${targetId}-pagination`;
                
                fetchOrders(status, container, paginationContainer);
            });

            // Xử lý phân trang
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                const url = $(this).data('page');
                $.ajax({
                    url: url,
                    success: function(response) {
                        renderOrders(response.orders.data, response.statusData, '#order-list');
                        updatePagination(response.orders, '#pagination');
                    }
                });
            });

            // Tìm kiếm theo order_code
            function searchOrders(query, status = '', container = '#order-list', paginationContainer = '#pagination') {
                $.ajax({
                    url: '{{ route('fetch.orders') }}',
                    method: 'GET',
                    data: { 
                        status: status,
                        search: query
                    },
                    success: function(response) {
                        if (response.error) {
                            console.error('Error:', response.error);
                            return;
                        }
                        
                        renderOrders(response.orders.data, response.statusData, container, paginationContainer);
                        if (response.orders.data.length > 0) {
                            updatePagination(response.orders, paginationContainer);
                            $(paginationContainer).show();
                        }else {
                            $(paginationContainer).hide(); // Ẩn phân trang nếu không có kết quả
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        console.log(xhr.responseText);
                    }
                });
            }

            $('#search-input').on('keyup', function() {
                const query = $(this).val();
                const status = '';
                const container = `#order-list`;
                const paginationContainer = `#pagination`;

                searchOrders(query, status, container, paginationContainer);
            });
        });
    </script>
@endsection
