@extends('client.layouts.master')
@section('title', 'Chi tiết đơn hàng')
@section('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/order/order.css') }}">
    <link href="{{ asset('admin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    <style>
        .table-container {
            max-height: 300px;
            overflow: auto;
        }
        .no-hover:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .accordion-button.no-arrow:not(.collapsed)::after {
            display: none;
        }

        .accordion-item {
            position: relative;
        }

        .accordion-item:first-child::before {
            top: 20px;
        }

        .accordion-item::before {
            content: "";
            position: absolute;
            height: 100%;
            left: 23px;
            border-left: 2px dashed #626264;
        }

        .accordion-item:last-child::before {
            display: none;
        }

    </style>
@endsection
@php
    use App\Enums\OrderStatus;
    use App\Enums\TransferStatus;
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Chi tiết đơn hàng</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            @if (Auth::check())
                <li class="breadcrumb-item"><a href="{{ route('order.index') }} "> Đơn hàng </a></li>
            @endif
            <li class="breadcrumb-item active text-white">Chi tiết đơn hàng</li>
        </ol>
    </div>
    <!-- End Page Title -->

    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0">Đơn hàng #{{ $order->order_code }}</h5>
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
                                        @php
                                            $subtotal = 0;
                                        @endphp
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
                                            @php
                                                $total = $order_detail->price_sale * $order_detail->quantity;
                                                $subtotal += $total;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row border-top border-top-dashed d-flex justify-content-between mt-2 pt-3">
                                <div class="col-5">
                                    <div class="d-flex justify-content-between">
                                        <p>Phương thức thanh toán:</p>
                                        <p><b>{{ $order->payment_method == 1 ? 'VNPAY' : 'COD' }}</b></p>
                                    </div>

                                    <div class="row">
                                        <p class="col-xl-3">Giảm giá :</p>
                                        <p class="col-xl-9 badge bg-warning-subtle text-success text-uppercase text-wrap">
                                            {{ $order->voucher ? $order->voucher->title : 'Không áp dụng' }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Trạng thái thanh toán:</p>
                                        <p class="{{ $statusData['badgeClass'] }}">
                                            {{ $statusData['label'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-between">
                                        <p>Thành Tiền:</p>
                                        <p>{{ number_format($order->before_total_amount) }} VNĐ</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Áp dụng phiếu giảm giá<span class="text-muted"></span> :</p>
                                        <p>{{$order->voucher_apply ? '-'.number_format($order->voucher_apply) : 0.00 }} VNĐ</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Phí vận chuyển:</p>
                                        <p>{{ number_format($order->shipping) }} VNĐ</p>
                                    </div>
                                    <div class="border-top border-top-dashed d-flex justify-content-between">
                                        <p><b>Tổng tiền:</b></p>
                                        <p><b>{{ number_format($order->after_total_amount) }} VNĐ</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0">Trạng thái đơn hàng</h5>
                                <div class="d-flex flex-shrink-0 mt-2 mt-sm-0">
                                    @if ($order->status == OrderStatus::COMPLETED->value)
                                        <div class="btn btn-success btn-sm align-items-center" style="font-size: 0.9rem; cursor: default; pointer-events: none;">
                                            Đơn hàng đã hoàn thành
                                        </div>
                                    @elseif($order->status == OrderStatus::CANCELLED->value)
                                        <div class="btn btn-danger btn-sm align-items-center" style="font-size: 0.9rem; cursor: default; pointer-events: none;">
                                            Đơn hàng đã bị hủy
                                        </div>
                                    @else
                                        @if ($order->status < OrderStatus::PROCESSING->value && Auth::check())
                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm align-items-center" style="font-size: 0.9rem;">
                                                    Hủy đơn hàng
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="profile-timeline">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    @foreach ($orderHistoriesWithTransfers as $key => $historyWithTransfers)
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="heading{{ $key + 1 }}">
                                                <a class="accordion-button p-2 shadow-none {{ !$historyWithTransfers['showTransferHistory'] ? 'no-arrow' : '' }}" data-bs-toggle="collapse" href="#collapse{{ $key + 1 }}" aria-expanded="{{ $historyWithTransfers['showTransferHistory'] ? 'true' : 'false' }}" aria-controls="collapse{{ $key + 1 }}">
                                                    <div class="d-flex align-items-center position-relative">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            @foreach (OrderStatus::cases() as $statusOrder)
                                                                @if($historyWithTransfers['orderHistory']->status == $statusOrder->value)
                                                                    <div class="avatar-title bg-primary rounded-circle">
                                                                        <i class="{{ $statusOrder->icon() }}"></i>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            @foreach (OrderStatus::cases() as $statusOrder)
                                                                @if($historyWithTransfers['orderHistory']->status == $statusOrder->value)
                                                                    <h6 class="fs-15 mb-0 fw-semibold">
                                                                        <b style="color: #4154f1;">{{ $statusOrder->label() }}</b> - <span class="fw-normal">{{ $historyWithTransfers['formattedOrderHistory'] }}</span>
                                                                    </h6>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            @if ($historyWithTransfers['showTransferHistory'])
                                                <div id="collapse{{ $key + 1 }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $key + 1 }}" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                                        @foreach($historyWithTransfers['transferHistories'] as $transfer_history)
                                                            @foreach (TransferStatus::cases() as $statusTransfer)
                                                                @if($transfer_history->status == $statusTransfer->value)
                                                                    <h6 class="">{{ $statusTransfer->label() }}</h6>
                                                                    <p class="text-muted">{{ mb_convert_case(Carbon::parse($transfer_history->created_at)->translatedFormat('H:i:s l, d/m/Y'), MB_CASE_TITLE, "UTF-8") }}</p>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
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
                            <div class="text-center">
                                <h5 class="card-title flex-grow-1 mb-0">Thông tin khách hàng</h5>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <ul class="list-unstyled mb-0 vstack gap-3">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $order->user->avatar }}" alt="" class="avatar-sm rounded">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fs-14 mb-1">{{ $order->user->name }}</h6>
                                            <p class="text-muted mb-0">Khách hàng</p>
                                        </div>
                                    </div>
                                </li>
                                <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{  $order->email }}</li>
                                <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{  $order->phone }}</li>
                                <li><i class="ri-map-pin-line align-middle me-2 text-muted fs-16"></i>{{ $order->address }}</li>
                            </ul>
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
