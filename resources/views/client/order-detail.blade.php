@extends('client.layouts.master')
@section('title', 'Chi tiết đơn hàng')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/order/order.css') }}">
    <style>
        .table-container {
            max-height: 300px;
            overflow: auto;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Chi tiết đơn hàng</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('order.index') }} "> Đơn hàng </a></li>
            <li class="breadcrumb-item active text-white">Chi tiết đơn hàng</li>
        </ol>
    </div>
    <!-- End Page Title -->
    <section class="section container-lg mt-5">
        <div class="row">
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0">Đơn hàng #{{ $order->order_code }}</h5>
                            <div class="flex-shrink-0">
                                <a href="apps-invoices-details.html" class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> Invoice</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card table-container" table-container>
                            <table class="table table-nowrap align-middle table-borderless mb-0 table-container">
                                <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">Chi tiết sản phẩm</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Đánh giá</th>
                                    <th scope="col" class="text-end">Thành tiền</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($order->order_details as $order_detail)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1" style="height: 80px; width: 80px;">
                                                    <img src="{{ $order_detail->image }}" class="img-fluid d-block">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-15"><a href="{{ route('product', $order_detail->product->id) }}" class="link-primary">{{ $order_detail->name }}</a></h5>
                                                    <p class="text-muted mb-0">Thương hiệu: <span class="fw-medium">{{ $order_detail->product->brand->name }}</span></p>
                                                    <p class="text-muted mb-0">Loại: <span class="fw-medium">{{ $order_detail->product->category->name }}</span></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($order_detail->price_sale) }} VNĐ</td>
                                        <td>{{ $order_detail->quantity }}</td>
                                        <td>
                                            <div class="text-warning fs-15">
                                                <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-half-fill"></i>
                                            </div>
                                        </td>
                                        <td class="fw-medium text-end">
                                            {{ number_format($order_detail->price_sale * $order_detail->quantity) }} VNĐ
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row border-top border-top-dashed d-flex justify-content-between mt-2 pt-4">
                            <div class="col-6">
                                <div class="d-flex justify-content-between">
                                    <p>Phương thức thanh toán:</p>
                                    <p><b> @if($order->payment_method == 1) VNPAY @else Thanh toán khi nhận hàng @endif</b></p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Trạng thái thanh toán:</p>
                                    <p class="badge bg-warning-subtle text-warning text-uppercase">
                                        @foreach(App\Enums\OrderStatus::values() as $key => $item)
                                            @if($order->status == $key)
                                               {{ $item }}
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="d-flex justify-content-between">
                                    <p>Giá tiền:</p>
                                    <p>{{ number_format($order->before_total_amount) }} VNĐ</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Phí vận chuyển <span class="text-muted"></span> :</p>
                                    <p>{{ number_format($order->shipping) }} VNĐ</p>
                                </div>
                                <div class="border-top border-top-dashed d-flex justify-content-between">
                                    <p><b>Tổng tiền:</b></p>
                                    <p>{{ number_format($order->after_total_amount) }} VNĐ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-->
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0">Trạng thái đơn hàng</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="profile-timeline">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                @php use App\Enums\OrderStatus; @endphp
                                @foreach($order->order_histories as $order_history)
                                    @foreach (OrderStatus::cases() as $status)
                                        @if($order_history->status == $status->value)
                                            <div class="accordion-item border-0">
                                                <div class="accordion-header" id="headingOne">
                                                    <a class="p-2 shadow-none">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 avatar-xs">
                                                                <div class="avatar-title bg-success rounded-circle">
                                                                    <i class="ri-shopping-bag-line"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <h6 class="fs-15 mb-0 fw-semibold">
                                                                    {{ $status->name }} - <span class="fw-normal">{{ $order_history->created_at }}</span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="accordion-body ms-2 ps-5 pt-0">
                                                    <h6 class="mb-1">{{ $order_history->warehouse }}</h6>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach

                                {{-- <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingTwo">
                                        <a class="p-2 shadow-none">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-success rounded-circle">
                                                        <i class="bi bi-gift"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-15 mb-1 fw-semibold">Packed - <span class="fw-normal">Thu, 16 Dec 2021</span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingThree">
                                        <a class="p-2 shadow-none">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-success rounded-circle">
                                                        <i class="bi bi-truck"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-15 mb-1 fw-semibold">Shipping - <span class="fw-normal">Thu, 16 Dec 2021</span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingFour">
                                        <a class="p-2 shadow-none">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-light text-success rounded-circle">
                                                        <i class="ri-takeaway-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-14 mb-0 fw-semibold">Out For Delivery</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingFive">
                                        <a class="p-2 shadow-none">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-light text-success rounded-circle">
                                                        <i class="bi bi-box-seam-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-14 mb-0 fw-semibold">Delivered</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div> --}}
                            </div>
                            <!--end accordion-->
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">Thông tin khách hàng</h5>
                            <div class="flex-shrink-0">
                                <a href="" class="link-secondary">Xem hồ sơ</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $order->user->avatar }}" alt="" class="avatar-sm rounded" width="100px">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-14 mb-1">{{ $order->user->name }}</h6>
                                        <p class="text-muted mb-0">Khách hàng</p>
                                    </div>
                                </div>
                            </li>
                            <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{  $order->user->email }}</li>
                            <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{  $order->user->phone }}</li>
                        </ul>
                    </div>
                </div>
                <!--end card-->
                <div class="card  mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Địa chỉ giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                            <li>{{ $order->address}},{{ $order->ward}},{{ $order->district}},{{ $order->province }}</li>
                        </ul>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </section>
@endsection
@section('js')

@endsection
