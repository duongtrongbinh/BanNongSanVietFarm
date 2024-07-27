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
    <section class="container-lg section" style="margin-top:50px ; height: 100vh">
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
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pending">
                                    <i class="ri-checkbox-circle-line me-1 align-bottom"></i>
                                     {{ OrderStatus::PENDING->label() }}
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#processing">
                                    <i class="ri-truck-line me-1 align-bottom"></i>
                                    {{ OrderStatus::PROCESSING->label() }}
{{--                                    <span class="badge bg-danger align-middle ms-1">{{ count($pickups) }}</span>--}}
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipping">
                                    <i class="ri-arrow-left-right-fill me-1 align-bottom"></i>
                                    {{ OrderStatus::SHIPPING->label() }}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipped">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i>
                                    {{ OrderStatus::SHIPPED->label() }}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#delivered">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i>
                                    {{ OrderStatus::DELIVERED->label() }}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#completed">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i>
                                    {{ OrderStatus::COMPLETED->label() }}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cancelled">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i>
                                    {{ OrderStatus::CANCELLED->label() }}
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#returned">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i>
                                    {{ OrderStatus::RETURNED->label() }}
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
                                        <th>Chi tiết</th>
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
                                            <td>  @if($order->payment_method == \App\Enums\PaymentStatus::PENDING_PAYMENT->value)
                                               COD
                                            @else
                                               VNPAY
                                            @endif
                                            </td>
                                            <td>
                                                @if ($order->status == OrderStatus::PENDING->value)
                                                    <span class="badge border border-warning text-warning">{{  OrderStatus::PENDING->label() }}</span>
                                                @elseif ($order->status == OrderStatus::PROCESSING->value)
                                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">{{  OrderStatus::PROCESSING->label() }}</span>
                                                @elseif ($order->status == OrderStatus::SHIPPING->value)
                                                    <span class="badge bg-info-subtle text-info text-uppercase">{{  OrderStatus::SHIPPING->label() }}</span>
                                                @elseif ($order->status == OrderStatus::SHIPPED->value)
                                                    <span class="badge bg-success-subtle text-success text-uppercase">{{  OrderStatus::SHIPPED->label() }}</span>
                                                @elseif ($order->status == OrderStatus::DELIVERED->value)
                                                    <span class="badge bg-primary-subtle text-primary text-uppercase">{{  OrderStatus::DELIVERED->label() }}</span>
                                                @elseif($order->status == OrderStatus::COMPLETED->value)
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">{{  OrderStatus::COMPLETED->label() }}</span>
                                                @elseif($order->status == OrderStatus::CANCELLED->value)
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">{{  OrderStatus::CANCELLED->label() }}</span>
                                                @elseif($order->status == OrderStatus::RETURNED->value)
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">{{  OrderStatus::RETURNED->label() }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('order.detail',$order->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-indent" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M3 8a.5.5 0 0 1 .5-.5h6.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H3.5A.5.5 0 0 1 3 8"/>
                                                        <path fill-rule="evenodd" d="M12.5 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5"/>
                                                    </svg></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @empty($orderAll)
                                    <div class="mt-5">
                                        <h5  class="text-center">Không có đơn hàng nào</h5>
                                    </div>
                                @endempty
                            </div>
                            <!-- Đang chuẩn bị -->
                            <div class="tab-pane fade delivered pt-3" id="pending">
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
                                        <th>Chi tiết</th>
                                    </tr>
                                    </thead>
                                    <tbody> @php $hasOrder = false;  @endphp
                                    @foreach ($orderAll as $key => $pending)
                                        @if($pending->status == OrderStatus::PENDING->value)
                                        <tr> @php $hasOrder = $key;  @endphp
                                            <td>
                                                {{ $key }}
                                            </td>
                                            <td>
                                                <a href="" class="fw-medium link-primary">{{ $pending->order_code }}</a>
                                            </td>
                                            <td>
                                                {{ $pending->user->name }}
                                            </td>
                                            <td>
                                                {{ count($pending->order_details) }}
                                            </td>
                                            <td>
                                                {{ $pending->created_at }}
                                            </td>
                                            <td>{{ number_format($pending->after_total_amount) }}đ</td>
                                            <td>@if($pending->payment_method == 0)
                                                    Nhận Hàng
                                                @else
                                                    VNPAY
                                                @endif
                                            </td>
                                            <td>
                                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">{{  OrderStatus::PENDING->label() }}</span>
                                            </td>
                                              <td>
                                                <a href="{{ route('order.detail',$order->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-indent" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M3 8a.5.5 0 0 1 .5-.5h6.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H3.5A.5.5 0 0 1 3 8"/>
                                                        <path fill-rule="evenodd" d="M12.5 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5"/>
                                                    </svg></a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($hasOrder == false)
                                    <div class="mt-5">
                                        <h5  class="text-center">Không có đơn hàng nào</h5>
                                    </div>
                                @endif
                            </div>

                            <!-- Chờ thanh toán  -->
                            <div class="tab-pane fade pickups pt-3" id="processing">
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
                                        <th>Chi tiết</th>
                                    </tr>
                                    </thead>
                                    <tbody> @php $hasOrder = false;  @endphp
                                    @foreach ($orderAll as $key => $processing)
                                        @if($processing->status == OrderStatus::PROCESSING->value)
                                        <tr> @php $hasOrder = $key;  @endphp
                                            <td>
                                                {{ $key }}
                                            </td>
                                            <td>
                                                <a href="" class="fw-medium link-primary">{{ $processing->order_code }}</a>
                                            </td>
                                            <td>
                                                {{ $processing->user->name }}
                                            </td>
                                            <td>
                                                {{ count($processing->order_details) }}
                                            </td>
                                            <td>
                                                {{ $processing->created_at }}
                                            </td>
                                            <td>{{ number_format($processing->after_total_amount) }}đ</td>
                                            <td>@if($processing->payment_method == 0)
                                                    Nhận Hàng
                                                @else
                                                    VNPAY
                                                @endif
                                            </td>
                                            <td>
                                                    <span class="badge bg-info-subtle text-info text-uppercase">{{  OrderStatus::PROCESSING->label() }}</span>
                                            </td>
                                              <td>
                                                <a href="{{ route('order.detail',$order->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-indent" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M3 8a.5.5 0 0 1 .5-.5h6.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H3.5A.5.5 0 0 1 3 8"/>
                                                        <path fill-rule="evenodd" d="M12.5 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($hasOrder == false)
                                    <div class="mt-5">
                                        <h5  class="text-center">Không có đơn hàng nào</h5>
                                    </div>
                                @endif
                            </div>

                            <!-- Sẵn sàng lấy hàng -->
                            <div class="tab-pane fade returns pt-3" id="shipping">
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
                                        <th>Chi tiết</th>
                                    </tr>
                                    </thead>
                                    <tbody> @php $hasOrder = false;  @endphp
                                    @foreach ($orderAll as $key => $shipping)
                                        @if($shipping->status == OrderStatus::SHIPPING->value)
                                        <tr> @php $hasOrder = $key;  @endphp
                                            <td>
                                                {{ $key }}
                                            </td>
                                            <td>
                                                <a href="" class="fw-medium link-primary">{{ $shipping->order_code }}</a>
                                            </td>
                                            <td>
                                                {{ $shipping->user->name }}
                                            </td>
                                            <td>
                                                {{ count($shipping->order_details) }}
                                            </td>
                                            <td>
                                                {{ $shipping->created_at }}
                                            </td>
                                            <td>{{ number_format($shipping->after_total_amount) }}đ</td>
                                            <td>@if($shipping->payment_method == 0)
                                                    Nhận Hàng
                                                @else
                                                    VNPAY
                                                @endif
                                            </td>
                                            <td>
                                                    <span class="badge bg-success-subtle text-success text-uppercase">{{ OrderStatus::SHIPPING->label() }}</span>
                                            </td>
                                              <td>
                                                 <a href="{{ route('order.detail',$order->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-indent" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M3 8a.5.5 0 0 1 .5-.5h6.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H3.5A.5.5 0 0 1 3 8"/>
                                                        <path fill-rule="evenodd" d="M12.5 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($hasOrder == false)
                                    <div class="mt-5">
                                        <h5  class="text-center">Không có đơn hàng nào</h5>
                                    </div>
                                @endif
                            </div>

                            <!-- Cancelled -->
                            <div class="tab-pane fade cancelled pt-3" id="shipped">
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
                                        <th>Chi tiết</th>
                                    </tr>
                                    </thead>
                                    <tbody> @php $hasOrder = false;  @endphp
                                    @foreach ($orderAll as $key => $shipped)
                                        @if($shipped->status == OrderStatus::SHIPPED->value)
                                        <tr> @php $hasOrder = $key;  @endphp
                                            <td>
                                                {{ $key }}
                                            </td>
                                            <td>
                                                <a href="" class="fw-medium link-primary">{{ $shipped->order_code }}</a>
                                            </td>
                                            <td>
                                                {{ $shipped->user->name }}
                                            </td>
                                            <td>
                                                {{ count($shipped->order_details) }}
                                            </td>
                                            <td>
                                                {{ $shipped->created_at }}
                                            </td>
                                            <td>{{ number_format($shipped->after_total_amount) }}đ</td>
                                            <td>@if($shipped->payment_method == 0)
                                                    Nhận Hàng
                                                @else
                                                    VNPAY
                                                @endif
                                            </td>
                                            <td>
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">{{  OrderStatus::SHIPPED->label() }}</span>
                                            </td>
                                            <td>
                                              <a href="{{ route('order.detail',$order->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-indent" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M3 8a.5.5 0 0 1 .5-.5h6.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H3.5A.5.5 0 0 1 3 8"/>
                                                        <path fill-rule="evenodd" d="M12.5 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($hasOrder == false)
                                    <div class="mt-5">
                                        <h5  class="text-center">Không có đơn hàng nào</h5>
                                    </div>
                                @endif
                            </div>

                            <div class="tab-pane fade cancelled pt-3" id="delivered">
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
                                        <th>Chi tiết</th>
                                    </tr>
                                    </thead>
                                    <tbody> @php $hasOrder = false;  @endphp
                                    @foreach ($orderAll as $key => $delivered)
                                        @if($delivered->status == OrderStatus::DELIVERED->value)
                                            <tr> @php $hasOrder = $key;  @endphp
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
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">{{  OrderStatus::DELIVERED->label() }}</span>
                                                </td>
                                                <td>
                                                     <a href="{{ route('order.detail',$order->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-indent" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M3 8a.5.5 0 0 1 .5-.5h6.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H3.5A.5.5 0 0 1 3 8"/>
                                                        <path fill-rule="evenodd" d="M12.5 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5"/>
                                                    </svg>
                                                </a>
                                                </td>

                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($hasOrder == false)
                                    <div class="mt-5">
                                        <h5  class="text-center">Không có đơn hàng nào</h5>
                                    </div>
                                @endif
                            </div>

                            <div class="tab-pane fade cancelled pt-3" id="completed">
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
                                        <th>Chi tiết</th>
                                    </tr>
                                    </thead>
                                    <tbody>  @php $hasOrder = false;  @endphp
                                    @foreach ($orderAll as $key => $completed)
                                        @if($completed->status == OrderStatus::COMPLETED->value)
                                            <tr>  @php $hasOrder = $key;  @endphp
                                                <td>
                                                    {{ $key }}
                                                </td>
                                                <td>
                                                    <a href="" class="fw-medium link-primary">{{ $completed->order_code }}</a>
                                                </td>
                                                <td>
                                                    {{ $completed->user->name }}
                                                </td>
                                                <td>
                                                    {{ count($completed->order_details) }}
                                                </td>
                                                <td>
                                                    {{ $completed->created_at }}
                                                </td>
                                                <td>{{ number_format($completed->after_total_amount) }}đ</td>
                                                <td>@if($completed->payment_method == 0)
                                                        Nhận Hàng
                                                    @else
                                                        VNPAY
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">{{  OrderStatus::COMPLETED->label() }}</span>
                                                </td>
                                                <td>
                                                     <a href="{{ route('order.detail',$order->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-indent" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M3 8a.5.5 0 0 1 .5-.5h6.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H3.5A.5.5 0 0 1 3 8"/>
                                                        <path fill-rule="evenodd" d="M12.5 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5"/>
                                                    </svg>
                                                    </a>
                                                </td>

                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($hasOrder == false)
                                    <div class="mt-5">
                                        <h5  class="text-center">Không có đơn hàng nào</h5>
                                    </div>
                                @endif
                            </div>

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
                                        <th>Chi tiết</th>
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
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">{{  OrderStatus::CANCELLED->label() }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('order.detail',$order->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-indent" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M3 8a.5.5 0 0 1 .5-.5h6.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H3.5A.5.5 0 0 1 3 8"/>
                                                        <path fill-rule="evenodd" d="M12.5 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5"/>
                                                    </svg>
                                                </a>
                                                </td>

                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($hasOrder == false)
                                    <div class="mt-5">
                                        <h5  class="text-center">Không có đơn hàng nào</h5>
                                    </div>
                                @endif
                            </div>

                            <div class="tab-pane fade cancelled pt-3" id="returned">
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
                                       <th>Chi tiết</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $hasOrder = false;  @endphp
                                    @foreach ($orderAll as $key => $returned)
                                        @if($returned->status == OrderStatus::RETURNED->value)
                                            @php $hasOrder = $key;  @endphp
                                            <tr>
                                                <td>
                                                    {{ $key }}
                                                </td>
                                                <td>
                                                    <a href="" class="fw-medium link-primary">{{ $returned->order_code }}</a>
                                                </td>
                                                <td>
                                                    {{ $returned->user->name }}
                                                </td>
                                                <td>
                                                    {{ count($returned->order_details) }}
                                                </td>
                                                <td>
                                                    {{ $returned->created_at }}
                                                </td>
                                                <td>{{ number_format($returned->after_total_amount) }}đ</td>
                                                <td>@if($returned->payment_method == 0)
                                                        Nhận Hàng
                                                    @else
                                                        VNPAY
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">{{  OrderStatus::RETURNED->label() }}</span>
                                                </td>
                                                <td>
                                                     <a href="{{ route('order.detail',$order->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-indent" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M3 8a.5.5 0 0 1 .5-.5h6.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H3.5A.5.5 0 0 1 3 8"/>
                                                        <path fill-rule="evenodd" d="M12.5 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5"/>
                                                    </svg>
                                                </a>
                                                </td>

                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                @if($hasOrder == false)
                                    <div class="mt-5">
                                        <h5  class="text-center">Không có đơn hàng nào</h5>
                                    </div>
                                @endif
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--Delete js-->
    <script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>

    <!--ShowMessage js-->
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>

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
