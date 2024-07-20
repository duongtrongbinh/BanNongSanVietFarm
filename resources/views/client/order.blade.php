@extends('client.layouts.master')
@section('title', 'Đơn Hàng ')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@php use App\Enums\OrderStatus; @endphp
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Đơn hàng</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#"> Đơn hàng </a></li>
        </ol>
    </div>
    <!-- End Page Title -->
    <section class="container-lg section" style="margin-top:50px">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all-orders">
                                    <i class="ri-store-2-fill me-1 align-bottom"></i>
                                    Tất cả
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#delivered">
                                    <i class="ri-checkbox-circle-line me-1 align-bottom"></i>
                                    Đang chuẩn bị
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pickups">
                                    <i class="ri-truck-line me-1 align-bottom"></i>
                                    Chờ thanh toán
{{--                                    <span class="badge bg-danger align-middle ms-1">{{ count($pickups) }}</span>--}}
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#returns">
                                    <i class="ri-arrow-left-right-fill me-1 align-bottom"></i>
                                    Sẵn sàng lấy hàng
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cancelled">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i>
                                    Đơn hàng hủy
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
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orderAll as $key => $order)
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
                                            <td>@if($order->payment_method == 0)
                                                   Nhận Hàng
                                                @else
                                                   VNPAY
                                                @endif
                                            </td>
                                            <td>
                                                @if ($order->status == OrderStatus::PENDING->value)
                                                    <span class="badge border border-warning text-warning">Chờ xử lý</span>
                                                @elseif ($order->status == OrderStatus::PREPARE->value)
                                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">Đang chuẩn bị</span>
                                                @elseif ($order->status == OrderStatus::PENDING_PAYMENT->value)
                                                    <span class="badge bg-info-subtle text-info text-uppercase">Chờ thanh toán</span>
                                                @elseif ($order->status == OrderStatus::READY_TO_PICK->value)
                                                    <span class="badge bg-success-subtle text-success text-uppercase">Sẵn sàng lấy hàng</span>
                                                @elseif ($order->status == OrderStatus::PICKING->value)
                                                    <span class="badge bg-primary-subtle text-primary text-uppercase">Đang lấy hàng</span>
                                                @elseif($order->status == OrderStatus::PICKED->value)
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">Đã lấy hàng</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('order.detail',$order->id) }}">view</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Đang chuẩn bị -->
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
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orderAll as $key => $delivered)
                                        @if($delivered->status == OrderStatus::PREPARE->value)
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
                                            <td>@if($delivered->payment_method == 0)
                                                    Nhận Hàng
                                                @else
                                                    VNPAY
                                                @endif
                                            </td>
                                            <td>
                                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">Đang chuẩn bị</span>
                                            </td>
                                              <td>
                                                <a href="{{ route('order.detail',$order->id) }}">view</a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Chờ thanh toán  -->
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
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orderAll as $key => $pickup)
                                        @if($pickup->status == OrderStatus::PENDING_PAYMENT->value)
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
                                            <td>@if($pickup->payment_method == 0)
                                                    Nhận Hàng
                                                @else
                                                    VNPAY
                                                @endif
                                            </td>
                                            <td>
                                                    <span class="badge bg-info-subtle text-info text-uppercase">Chờ thanh toán</span>
                                            </td>
                                              <td>
                                                <a href="{{ route('order.detail',$order->id) }}">view</a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Sẵn sàng lấy hàng -->
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
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orderAll as $key => $return)
                                        @if($return->status == OrderStatus::RETURNING->value)
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
                                            <td>@if($return->payment_method == 0)
                                                    Nhận Hàng
                                                @else
                                                    VNPAY
                                                @endif
                                            </td>
                                            <td>
                                                    <span class="badge bg-success-subtle text-success text-uppercase">Sẵn sàng lấy hàng</span>
                                            </td>
                                              <td>
                                                <a href="{{ route('order.detail',$order->id) }}">view</a>
                                            </td>
                                        </tr>
                                        @endif
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
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orderAll as $key => $cancelled)
                                        @if($cancelled->status == OrderStatus::CANCELLED->value)
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
                                            <td>@if($cancelled->payment_method == 0)
                                                    Nhận Hàng
                                                @else
                                                    VNPAY
                                                @endif
                                            </td>
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
                                                <a href="{{ route('order.detail',$order->id) }}">view</a>
                                            </td>

                                        </tr>
                                        @endif
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
