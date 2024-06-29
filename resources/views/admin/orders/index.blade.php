@extends('admin.layout.master')
@section('title', 'List Order')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('content')
    <div class="pagetitle">
      <h1>List Order</h1>
      <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('orders.index') }}">Order</a></li>
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
                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Create Order</button>
                                <button type="button" class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i> Import</button>
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
                                All Orders
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#delivered">
                                <i class="ri-checkbox-circle-line me-1 align-bottom"></i>
                                Delivered
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pickups">
                                <i class="ri-truck-line me-1 align-bottom"></i>
                                Pickups
                                <span class="badge bg-danger align-middle ms-1">{{ count($pickups) }}</span>
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#returns">
                                <i class="ri-arrow-left-right-fill me-1 align-bottom"></i>
                                Returns
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cancelled">
                                <i class="ri-close-circle-line me-1 align-bottom"></i>
                                Cancelled
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">
                        <!-- All Orders -->
                        <div class="tab-pane fade show active all-orders" id="all-orders">
                            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-ordering="false">ID</th>
                                        <th>Mã hóa đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Số lượng sản phẩm</th>
                                        <th>Ngày đặt hàng</th>
                                        <th>Tổng tiền</th>
                                        <th>Phương thức thanh toán</th>
                                        <th>Trạng thái</th>
                                        <th>Chỉnh sửa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>
                                                {{ $key }}
                                            </td>
                                            <td>
                                                <a href="" class="fw-medium link-primary">{{ $order->order_code }}</a>
                                            </td>
                                            <td>
                                                {{ $order->user->name }}
                                            </td>
                                            <td>
                                                {{ count($order->order_details) }}
                                            </td>
                                            <td>
                                                {{ $order->created_at }}
                                            </td>
                                            <td>{{ number_format($order->after_total_amount) }}đ</td>
                                            <td>VNPAY</td>
                                            <td>
                                                @if ($order->status == 0)
                                                    <span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>
                                                @elseif ($order->status == 1)
                                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">Inprogress</span>
                                                @elseif ($order->status == 2)
                                                    <span class="badge bg-info-subtle text-info text-uppercase">Pickups</span>
                                                @elseif ($order->status == 3)
                                                    <span class="badge bg-success-subtle text-success text-uppercase">Delivered</span>
                                                @elseif ($order->status == 4)
                                                    <span class="badge bg-primary-subtle text-primary text-uppercase">Returns</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="{{ route('orders.show', $order->id) }}" class="text-primary d-inline-block">
                                                            <i class="ri-eye-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Delivered -->
                        <div class="tab-pane fade delivered pt-3" id="delivered">
                            <table id="table1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-ordering="false">ID</th>
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
                                <tbody>
                                    @foreach ($delivereds as $key => $delivered)
                                        <tr>
                                            <td>
                                                {{ $key }}
                                            </td>
                                            <td>
                                                <a href="" class="fw-medium link-primary">{{ $delivered->order_code }}</a>
                                            </td>
                                            <td>
                                                {{ $delivered->user->name }}
                                            </td>
                                            <td>
                                                {{ count($delivered->order_details) }}
                                            </td>
                                            <td>
                                                {{ $delivered->created_at }}
                                            </td>
                                            <td>{{ number_format($delivered->after_total_amount) }}đ</td>
                                            <td>VNPAY</td>
                                            <td>
                                                @if ($delivered->status == 0)
                                                    <span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>
                                                @elseif ($delivered->status == 1)
                                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">Inprogress</span>
                                                @elseif ($delivered->status == 2)
                                                    <span class="badge bg-info-subtle text-info text-uppercase">Pickups</span>
                                                @elseif ($delivered->status == 3)
                                                    <span class="badge bg-success-subtle text-success text-uppercase">Delivered</span>
                                                @elseif ($delivered->status == 4)
                                                    <span class="badge bg-primary-subtle text-primary text-uppercase">Returns</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="{{ route('orders.show', $delivered->id) }}" class="text-primary d-inline-block">
                                                            <i class="ri-eye-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pickups -->
                        <div class="tab-pane fade pickups pt-3" id="pickups">
                            <table id="table2" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-ordering="false">ID</th>
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
                                <tbody>
                                    @foreach ($pickups as $key => $pickup)
                                        <tr>
                                            <td>
                                                {{ $key }}
                                            </td>
                                            <td>
                                                <a href="" class="fw-medium link-primary">{{ $pickup->order_code }}</a>
                                            </td>
                                            <td>
                                                {{ $pickup->user->name }}
                                            </td>
                                            <td>
                                                {{ count($pickup->order_details) }}
                                            </td>
                                            <td>
                                                {{ $pickup->created_at }}
                                            </td>
                                            <td>{{ number_format($pickup->after_total_amount) }}đ</td>
                                            <td>VNPAY</td>
                                            <td>
                                                @if ($pickup->status == 0)
                                                    <span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>
                                                @elseif ($pickup->status == 1)
                                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">Inprogress</span>
                                                @elseif ($pickup->status == 2)
                                                    <span class="badge bg-info-subtle text-info text-uppercase">Pickups</span>
                                                @elseif ($pickup->status == 3)
                                                    <span class="badge bg-success-subtle text-success text-uppercase">Delivered</span>
                                                @elseif ($pickup->status == 4)
                                                    <span class="badge bg-primary-subtle text-primary text-uppercase">Returns</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="{{ route('orders.show', $pickup->id) }}" class="text-primary d-inline-block">
                                                            <i class="ri-eye-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Returns -->
                        <div class="tab-pane fade returns pt-3" id="returns">
                            <table id="table3" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-ordering="false">ID</th>
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
                                <tbody>
                                    @foreach ($returns as $key => $return)
                                        <tr>
                                            <td>
                                                {{ $key }}
                                            </td>
                                            <td>
                                                <a href="" class="fw-medium link-primary">{{ $return->order_code }}</a>
                                            </td>
                                            <td>
                                                {{ $return->user->name }}
                                            </td>
                                            <td>
                                                {{ count($return->order_details) }}
                                            </td>
                                            <td>
                                                {{ $return->created_at }}
                                            </td>
                                            <td>{{ number_format($return->after_total_amount) }}đ</td>
                                            <td>VNPAY</td>
                                            <td>
                                                @if ($return->status == 0)
                                                    <span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>
                                                @elseif ($return->status == 1)
                                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">Inprogress</span>
                                                @elseif ($return->status == 2)
                                                    <span class="badge bg-info-subtle text-info text-uppercase">Pickups</span>
                                                @elseif ($return->status == 3)
                                                    <span class="badge bg-success-subtle text-success text-uppercase">Delivered</span>
                                                @elseif ($return->status == 4)
                                                    <span class="badge bg-primary-subtle text-primary text-uppercase">Returns</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="{{ route('orders.show', $return->id) }}" class="text-primary d-inline-block">
                                                            <i class="ri-eye-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Cancelled -->
                        <div class="tab-pane fade cancelled pt-3" id="cancelled">
                            <table id="table4" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-ordering="false">ID</th>
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
                                <tbody>
                                    @foreach ($cancelleds as $key => $cancelled)
                                        <tr>
                                            <td>
                                                {{ $key }}
                                            </td>
                                            <td>
                                                <a href="" class="fw-medium link-primary">{{ $cancelled->order_code }}</a>
                                            </td>
                                            <td>
                                                {{ $cancelled->user->name }}
                                            </td>
                                            <td>
                                                {{ count($cancelled->order_details) }}
                                            </td>
                                            <td>
                                                {{ $cancelled->created_at }}
                                            </td>
                                            <td>{{ number_format($cancelled->after_total_amount) }}đ</td>
                                            <td>VNPAY</td>
                                            <td>
                                                @if ($cancelled->status == 0)
                                                    <span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>
                                                @elseif ($cancelled->status == 1)
                                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">Inprogress</span>
                                                @elseif ($cancelled->status == 2)
                                                    <span class="badge bg-info-subtle text-info text-uppercase">Pickups</span>
                                                @elseif ($cancelled->status == 3)
                                                    <span class="badge bg-success-subtle text-success text-uppercase">Delivered</span>
                                                @elseif ($cancelled->status == 4)
                                                    <span class="badge bg-primary-subtle text-primary text-uppercase">Returns</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="{{ route('orders.show', $cancelled->id) }}" class="text-primary d-inline-block">
                                                            <i class="ri-eye-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Bordered Tabs -->
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

    <!--Delete js-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#table1').DataTable();
            $('#table2').DataTable();
            $('#table3').DataTable();
            $('#table4').DataTable();
            // Khởi tạo cho các bảng khác nếu có
        });

      new DataTable("#example");
      function actionDelete(e) {
        e.preventDefault();
        let urlRequest = $(this).data("url");
        let that = $(this);
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: urlRequest,
                    data: {
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function (data) {
                        if (data == true) {
                            that.closest('tr').remove();
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success",
                            });
                        }
                    },
                    error: function (data) {
                        if (data == false) {
                            Swal.fire({
                                title: "Cancelled",
                                text: "Your imaginary file is safe :)",
                                icon: "error",
                            });
                        }
                    },
                });
            }
        });
      }
      $(function () {
        $(document).on("click", ".deleteSlide", actionDelete);
      });
    </script>
@endsection
