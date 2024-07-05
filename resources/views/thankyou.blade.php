@extends('client.layouts.master')
@section('title', 'Cảm ơn quý khách');
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
    <!-- End Page Title -->
    <section class="section container-lg " style="margin-top: 170px">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0">Cảm ơn quý khách</h5>
                            <div class="flex-shrink-0">
                               <h5>Đơn hàng #{{ $order->order_code }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card table-container table-container">
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
                                     @if($order->status == \App\Enums\OrderStatus::PENDING_PAYMENT->value)
                                        <p class="badge bg-warning-subtle text-warning text-uppercase">
                                         Chờ thanh toán
                                        </p>
                                        @else
                                        <p class="badge bg-success-subtle text-success text-uppercase">
                                          Đã thanh toán
                                        </p>
                                     @endif
                                </div>
                                <div class="d-flex " style="gap: 10px">
                                        <p>Địa chỉ:</p>
                                        <p>{{ $order->address}}</p>
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

                <!--end card-->
            </div>
            <!--end col-->

            <!--end col-->
        </div>
        <!--end row-->
    </section>
@endsection
@section('js')

@endsection
