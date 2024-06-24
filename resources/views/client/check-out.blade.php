@extends('client.layouts.master')
@section('title', 'Check Out')
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Checkout</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Checkout</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Billing details</h1>
            <form action="/check-out" method="post" >
                @csrf
                @method('POST')
                @if (isset($user))
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                @else
                    <input type="hidden" name="user_id" value="">
                @endif
                <input type="hidden" name="before_total_amount" value="12000">
                <input type="hidden" name="shipping" value="12000">
                <input type="hidden" name="after_total_amount" value="12000">
                <input type="hidden" name="order_code" value="random1223">
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">Full Name<sup>*</sup></label>
                                    @if (isset($user))
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                        @error('name')
                                            <small id="name" class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    @else
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Address <sup>*</sup></label>
                            <input type="text" class="form-control" placeholder="House Number Street Name" name="address" value="{{ old('address') }}">
                            @error('address')
                                <small id="title" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">City<sup>*</sup></label>
                            <input type="text" class="form-control" name="city" value="{{ old('city') }}">
                            @error('city')
                                <small id="title" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">District<sup>*</sup></label>
                            <input type="text" class="form-control" name="district" value="{{ old('district') }}">
                            @error('district')
                                <small id="title" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Ward<sup>*</sup></label>
                            <input type="text" class="form-control" name="ward" value="{{ old('ward') }}">
                            @error('ward')
                                <small id="title" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Mobile<sup>*</sup></label>
                            @if (isset($user))
                                <input type="tel" class="form-control" name="phone" value="{{ $user->phone }}">
                                @error('phone')
                                    <small id="phone" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            @else
                                <input type="number" class="form-control" name="phone" value="{{ old('phone') }}">
                            @endif
                            
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Email Address<sup>*</sup></label>
                            @if (isset($user))
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                                @error('email')
                                    <small id="email" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            @else
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            @endif
                        </div>
                        <div class="form-check my-3">
                            <input type="checkbox" class="form-check-input" id="Account-1" name="Accounts" value="Accounts">
                            <label class="form-check-label" for="Account-1">Create an account?</label>
                        </div>
                        <hr>
                        <div class="form-item">
                            <textarea class="form-control" spellcheck="false" cols="30" rows="11" placeholder="Oreder Notes (Optional)" name="note"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-5">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0 @endphp
                                    @foreach((array) session('cart') as $id => $item)
                                        @php $total += $item['price'] * $item['quantity'] @endphp
                                    @endforeach
                                    @foreach (session('cart') as $id => $item)
                                        <tr>
                                            <th scope="row">
                                                <div class="d-flex align-items-center mt-2">
                                                    <img src="{{ $item['image'] }}" class="img-fluid rounded-circle object-fit-cover" style="width: 90px; height: 90px;" alt="">
                                                </div>
                                            </th>
                                            <td class="py-5" id="name">{{ $item['name'] }}</td>
                                            <td class="py-5" id="price">{{ number_format($item['price']) }}</td>
                                            <td class="py-5" id="quantity">{{ $item['quantity'] }}</td>
                                            <td class="py-5" id="quantity">{{ number_format($item['quantity'] * $item['price']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <select class="form-select" aria-label="Default select example" name="voucher_id">
                            @foreach($vouchers as $items)
                                <option value="{{ $items->id }}" selected>{{ $items->title }}</option>
                            @endforeach
                        </select>

                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Transfer-1" name="Transfer" value="Transfer">
                                    <label class="form-check-label" for="Transfer-1">Direct Bank Transfer</label>
                                </div>
                                <p class="text-start text-dark">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</p>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Payments-1" name="Payments" value="Payments">
                                    <label class="form-check-label" for="Payments-1">Check Payments</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Delivery-1" name="Delivery" value="Delivery">
                                    <label class="form-check-label" for="Delivery-1">Cash On Delivery</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Paypal-1" name="Paypal" value="Paypal">
                                    <label class="form-check-label" for="Paypal-1">Paypal</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                            <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @section('scripts')
            <script>
                $(document).ready(function() {
                    console.log('hello word');
                })
            </script>
        @endsection
    </div>
    <!-- Checkout Page End -->
@endsection


