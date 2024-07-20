@extends('admin.layout.master')
@section('title', 'Danh sách đơn hàng')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <style>
        .update-status-div {
            display: none; /* Ẩn phần tử ban đầu */
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            z-index: 100;
            background-color: #f8f9fa;
            padding: 10px;
            border-top: 1px solid #dee2e6;
            justify-content: space-between; /* Flexbox alignment */
            align-items: center; /* Flexbox alignment */
            padding-left: 18%;
            padding-right: 2%;
        }
    </style>
@endsection
@section('content')
    <div class="pagetitle">
      <h1>Danh sách đơn hàng</h1>
      <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="active">Đơn hàng</a></li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center gy-3">
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <a type="button" class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i> Tạo mới</a>
                                <a id="export" class="btn btn-secondary"><i class="bi bi-file-earmark-arrow-up"></i> Xuất</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" id="demo-datepicker" placeholder="Select date">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idStatus">
                                        <option value="">Status</option>
                                        <option value="all" selected>All</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Inprogress">Inprogress</option>
                                        <option value="Cancelled">Cancelled</option>
                                        <option value="Pickups">Pickups</option>
                                        <option value="Returns">Returns</option>
                                        <option value="Delivered">Delivered</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idPayment">
                                        <option value="">Select Payment</option>
                                        <option value="all" selected>All</option>
                                        <option value="Mastercard">Mastercard</option>
                                        <option value="Paypal">Paypal</option>
                                        <option value="Visa">Visa</option>
                                        <option value="COD">COD</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" onclick="SearchData();"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        Filters
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all-orders">
                                <i class="ri-store-2-fill me-1 align-bottom"></i>
                                Đơn hàng
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pending">
                                <i class="ri-more-fill me-1 align-bottom"></i> 
                                Đang chờ xử lý
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#processing">
                                <i class="ri-loader-2-fill me-1 align-bottom"></i> 
                                Đang xử lý
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipping">
                                <i class="ri-truck-fill me-1 align-bottom"></i> 
                                Vận chuyển
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipped">
                                <i class="ri-takeaway-fill me-1 align-bottom"></i> 
                                Giao hàng
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#delivered">
                                <i class="ri-user-received-fill me-1 align-bottom"></i> 
                                Đã nhận hàng
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#completed">
                                <i class="ri-checkbox-circle-fill me-1 align-bottom"></i> 
                                Hoàn thành
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cancelled">
                                <i class="ri-close-circle-fill me-1 align-bottom"></i> 
                                Đã hủy
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#returned">
                                <i class="ri-reply-fill me-1 align-bottom"></i> 
                                Trả hàng/Hoàn tiền
                            </button>
                        </li>
                    </ul>
                    <form id="updateStatusForm" action="{{ route('orders.updateStatus') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="tab-content pt-2">
                            <!-- All Orders -->
                            <div class="tab-pane fade show active all-orders" id="all-orders">
                                <table id="table0" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%" 
                                        data-url="{{ route('orders.all') }}">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input class="form-check-input selectAll" type="checkbox">
                                            </th>
                                            <th>#</th>
                                            <th>Mã hóa đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Số lượng sản phẩm</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Pending -->
                            <div class="tab-pane fade pending pt-3" id="pending">
                                <table id="table1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%"
                                    data-url="{{ route('orders.pending') }}">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input class="form-check-input selectAll" type="checkbox">
                                            </th>
                                            <th>#</th>
                                            <th>Mã hóa đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Sản phẩm</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Chỉnh sửa</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Processing -->
                            <div class="tab-pane fade prepare pt-3" id="processing">
                                <table id="table2" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%"
                                    data-url="{{ route('orders.processing') }}">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input class="form-check-input selectAll" type="checkbox">
                                            </th>
                                            <th>#</th>
                                            <th>Mã hóa đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Sản phẩm</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Chỉnh sửa</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Shipping -->
                            <div class="tab-pane fade shipping pt-3" id="shipping">
                                <table id="table3" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%"
                                    data-url="{{ route('orders.shipping') }}">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input class="form-check-input selectAll" type="checkbox">
                                            </th>
                                            <th>#</th>
                                            <th>Mã hóa đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Sản phẩm</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Chỉnh sửa</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Shipped -->
                            <div class="tab-pane fade shipped pt-3" id="shipped">
                                <table id="table4" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%"
                                    data-url="{{ route('orders.shipped') }}">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input class="form-check-input selectAll" type="checkbox">
                                            </th>
                                            <th>#</th>
                                            <th>Mã hóa đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Sản phẩm</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Chỉnh sửa</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Delivered -->
                            <div class="tab-pane fade delivered pt-3" id="delivered">
                                <table id="table5" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%"
                                    data-url="{{ route('orders.delivered') }}">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input class="form-check-input selectAll" type="checkbox">
                                            </th>
                                            <th>#</th>
                                            <th>Mã hóa đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Sản phẩm</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Chỉnh sửa</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Completed -->
                            <div class="tab-pane fade completed pt-3" id="completed">
                                <table id="table6" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%"
                                    data-url="{{ route('orders.completed') }}">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input class="form-check-input selectAll" type="checkbox">
                                            </th>
                                            <th>#</th>
                                            <th>Mã hóa đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Sản phẩm</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Chỉnh sửa</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Cancelled -->
                            <div class="tab-pane fade cancelled pt-3" id="cancelled">
                                <table id="table7" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%"
                                    data-url="{{ route('orders.cancelled') }}">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input class="form-check-input selectAll" type="checkbox">
                                            </th>
                                            <th>#</th>
                                            <th>Mã hóa đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Sản phẩm</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Chỉnh sửa</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Returned -->
                            <div class="tab-pane fade returned pt-3" id="returned">
                                <table id="table8" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%"
                                    data-url="{{ route('orders.returned') }}">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input class="form-check-input selectAll" type="checkbox">
                                            </th>
                                            <th>#</th>
                                            <th>Mã hóa đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Sản phẩm</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Phương thức thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Chỉnh sửa</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- End Bordered Tabs -->
                        <div id="updateStatusDiv" class="update-status-div">
                            <div>
                                <p class="fw-bold">Đã chọn</p>
                                <div class="d-flex align-items-center">
                                    <p class="countOrders fs-3 fw-bold text-primary p-0"></p>
                                    <p>đơn hàng</p>
                                </div>
                            </div>
                            <button type="submit" id="updateStatusBtn" class="btn btn-primary" data-url="{{ route('orders.updateStatus') }}">Cập nhật trạng thái</button>
                        </div>
                    </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--Delete js-->
    <script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>

    <!--ShowMessage js-->
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>

    <script>
        $(document).ready(function() {
            var order_ids = [];
            var selectedIds = {};
            
            function initializeDataTable(tableId) {
                var table = $('#' + tableId).DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: $('#' + tableId).data('url'),
                    autoWidth: false,
                    columns: [
                        { data: 'checked', name: 'checked', orderable: false, searchable: false },
                        { data: 'stt', name: 'stt' },
                        { data: 'order_code', name: 'order_code' },
                        { data: 'user_name', name: 'user_name' },
                        { data: 'order_details', name: 'order_details' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'after_total_amount', name: 'after_total_amount' },
                        { data: 'payment', name: 'payment' },
                        { data: 'status', name: 'status' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    drawCallback: function(settings) {
                        var checkboxes = $('input[type="checkbox"]', '#' + tableId);
                        checkboxes.each(function() {
                            var checkbox = $(this);
                            var id = checkbox.val();
                            if (selectedIds[tableId] && selectedIds[tableId].indexOf(id) !== -1) {
                                checkbox.prop('checked', true);
                            }
                        });

                        $('#' + tableId + ' th:eq(0)').removeClass('sorting_asc');
                    }
                });

                order_ids = [];
                selectedIds[tableId] = [];

                $('#' + tableId + ' .selectAll').on('click', function() {
                    $('.selectAll').not(this).prop('checked', false);

                    for (var key in selectedIds) {
                        if (key !== tableId) {
                            selectedIds[key] = [];
                            $('input[type="checkbox"]', '#' + key).prop('checked', false);
                        }
                    }

                    var checkboxes = $('input[type="checkbox"]', '#' + tableId).not(this);
                    checkboxes.prop('checked', this.checked);
                    updateSelectedIds(tableId);

                    if (selectedIds[tableId].length > 0) {
                        document.getElementById('updateStatusDiv').style.display = 'flex';
                        $('.countOrders').text(selectedIds[tableId].length);
                    } else {
                        $('#updateStatusDiv').hide();
                    }
                });

                $('#' + tableId + ' tbody').on('change', 'input[type="checkbox"]', function() {
                    var checkbox = $(this);
                    var isChecked = checkbox.prop('checked');
                    var id = checkbox.val();

                    if (!selectedIds[tableId]) {
                        selectedIds[tableId] = [];
                    }

                    for (var key in selectedIds) {
                        if (key !== tableId) {
                            selectedIds[key] = [];
                            $('input[type="checkbox"]', '#' + key).prop('checked', false);
                        }
                    }

                    if (isChecked && selectedIds[tableId].indexOf(id) === -1) {
                        selectedIds[tableId].push(id); 
                        order_ids.push(id); 
                    } else if (!isChecked && selectedIds[tableId].indexOf(id) !== -1) {
                        // selectedIds[tableId].splice(selectedIds[tableId].indexOf(id), 1);
                        // order_ids.splice(order_ids.indexOf(id), 1);
                        var index = selectedIds[tableId].indexOf(id);
                        if (index !== -1) {
                            selectedIds[tableId].splice(index, 1);
                        }
                        order_ids.splice(order_ids.indexOf(id), 1);
                    }

                    if (selectedIds[tableId].length > 0) {
                        document.getElementById('updateStatusDiv').style.display = 'flex';
                        $('.countOrders').text(order_ids.length);
                    } else {
                        $('#updateStatusDiv').hide();
                    }
                });

                function updateSelectedIds(tableId) {
                    selectedIds[tableId] = [];
                    order_ids = [];
                    var checkboxes = $('input[type="checkbox"]:checked', '#' + tableId).not('.selectAll');
                    checkboxes.each(function() {
                        selectedIds[tableId].push($(this).val());
                        order_ids.push($(this).val());
                    });

                    var uncheckedCheckboxes = $('input[type="checkbox"]:not(:checked)', '#' + tableId).not('.selectAll');
                    uncheckedCheckboxes.each(function() {
                        var idToRemove = $(this).val();
                        var index = selectedIds[tableId].indexOf(idToRemove);
                        if (index !== -1) {
                            selectedIds[tableId].splice(index, 1); // Xóa ID khỏi selectedIds[tableId]
                            order_ids.splice(order_ids.indexOf(idToRemove), 1); // Xóa ID khỏi order_ids
                        }
                    });
                }
            }

            function reloadData(table) {
                table.DataTable().ajax.reload(function() {
                    $('.dataTables_paginate .paginate_button').each(function() {
                        $(this).addClass('current');

                        return false;
                    });
                }, false);
            }

            $('#updateStatusBtn').on('click', function() {
                var form = document.getElementById('updateStatusForm');
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'order_ids';
                input.value = JSON.stringify(order_ids);
                form.appendChild(input);

                let url = $(this).data("url");

                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: {
                        order_ids: JSON.stringify(order_ids)
                    },
                    success: function(response) {
                        order_ids = [];
                        selectedIds = {};

                        $('.selectAll').prop('checked', false);
                        $('#updateStatusDiv').hide();

                        let title = 'Cập nhật';
                        let message = response.message;
                        let icon = 'success';

                        showMessage(title, message, icon);

                        var allTables = $.fn.dataTable.tables();

                        for (let i = 0; i < allTables.length; i++) {
                            reloadData($(allTables[i]));
                        }
                    },
                    error: function(response) {
                        let title = 'Lỗi';
                        let icon = 'error';
                        if (response.status === 400) {
                            let errorMessage = response.responseJSON.message;
                            showMessage(title, errorMessage, icon);
                        }
                    }
                });

                return false;
            });

            initializeDataTable('table0');
            initializeDataTable('table1');
            initializeDataTable('table2');
            initializeDataTable('table3');
            initializeDataTable('table4');
            initializeDataTable('table5');
            initializeDataTable('table6');
            initializeDataTable('table7');
            initializeDataTable('table8');

            $('#export').click(function() {
                var table = document.getElementById("table0");
                var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
                XLSX.writeFile(wb, "orders.xlsx");
            });
        });
    </script>
@endsection
