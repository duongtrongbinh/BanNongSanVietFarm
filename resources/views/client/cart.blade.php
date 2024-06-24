@extends('client.layouts.master')
@section('title', 'Giỏ hàng')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Cart</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active text-white">Cart</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Cart Page Start -->
    <div class="container-fluid py-5 div-cart">
        @if(session('cart'))
            <div class="container py-5 div-table">
                <div class="table-responsive">
                    <table id="cart" class="table">
                        <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                        </thead>
                        <tbody class="div-tbody">
                            @php $total = 0 @endphp
                            @foreach (session('cart') as $id => $details)
                                @php $total += $details['price'] * $details['quantity'] @endphp
                                <tr>
                                    <td data-th="Product" scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $details['image'] }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">{{ $details['name'] }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">{{ number_format($details['price']) }}đ</p>
                                    </td>
                                    <td>
                                        <div class="input-group quantity mt-4" style="width: 100px;">
                                            <input type="number" class="form-control form-control-sm text-center border-0 cart-quantity" name="quantity" min="1" value="{{ $details['quantity'] }}" data-id="{{ $id }}" data-price="{{ $details['price'] }}" data-url="{{ route('cart.update') }}">
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4 total">{{ number_format($details['price'] * $details['quantity']) }}đ</p>
                                    </td>
                                    <td class="actions">
                                        <button class="btn btn-md rounded-circle bg-light border mt-4 remove-cart" data-id="{{ $id }}" data-url="{{ route('cart.remove') }}">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Subtotal:</h5>
                                    <p class="mb-0" id="subtotal">{{ number_format($total) }}đ</p>
                                </div>
                            </div>
                            <a href="{{ route('checkout') }}" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center div-home">
                <h3>Không có sản phẩm nào trong giỏ hàng</h3>
                <a href="{{ url('/') }}" class="btn btn-secondary"> <i class="fa fa-arrow-left"></i> VỀ TRANG CHỦ</a>
            </div>
        @endif
    </div>
    <!-- Cart Page End -->
@endsection

@section('scripts')
    
@endsection