@extends('client.layouts.master')
@section('title', 'Cảm ơn quý khách')
@section('styles')
    <link href="{{ asset('admin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    <style>
        .table-container {
            max-height: 300px;
            overflow: auto;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="row g-4 mt-3">
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
                                                @php
                                                    $totalRatting = 0;
                                                    $totalCount = count($order_detail->product->comments);

                                                    foreach ($order_detail->product->comments as $comment) {
                                                        $totalRatting += $comment->ratting;
                                                    }
                                                    $averageRatting = $totalCount > 0 ? $totalRatting / $totalCount : 0;
                                                @endphp
                                                <div class="text-warning fs-15">
                                                    @php
                                                        $fullStars = floor($averageRatting); // Số sao nguyên
                                                        $halfStar = ceil($averageRatting - $fullStars); // Số sao nửa
                                                        $emptyStars = 5 - $fullStars - $halfStar; // Số sao trống
                                                    @endphp
                                                    @for ($i = 1; $i <= $fullStars; $i++)
                                                        <i class="ri-star-fill" data-ratting="{{ $i }}"></i>
                                                    @endfor

                                                    @if ($halfStar > 0)
                                                        <i class="ri-star-half-fill" data-ratting="{{ $i }}"></i>
                                                        @php $i++; @endphp
                                                    @endif
                                                    @for ($j = 1; $j <= $emptyStars; $j++)
                                                        <i class="ri-star-line" data-ratting="{{ $i }}"></i>
                                                        @php $i++; @endphp
                                                    @endfor
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
                                        <p><b>{{ $order->payment_method == 0 ? "VNPAY" : "COD" }}</b></p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Trạng thái thanh toán:</p>
                                         @if($order->payment_status == \App\Enums\PaymentStatus::PENDING_PAYMENT->value)
                                            <p class="badge bg-warning-subtle text-warning text-uppercase">
                                             Chờ thanh toán
                                            </p>
                                            @else
                                            <p class="badge bg-success-subtle text-success text-uppercase">
                                              Đã thanh toán
                                            </p>
                                         @endif
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Phiếu giảm giá :</p>
                                            <p class="badge bg-warning-subtle text-success text-uppercase">
                                                {{ $order->voucher ? $order->voucher->title : 'Không áp dụng' }}
                                            </p>
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
                                    <div class="d-flex justify-content-between">
                                        <p>Áp dụng phiếu giảm giá<span class="text-muted"></span> :</p>
                                        <p>{{$order->voucher_apply ? '-'.number_format($order->voucher_apply) : 0.00 }} VNĐ</p>
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
                </div>
            </div>
        </div>
    </div>
@endsection
