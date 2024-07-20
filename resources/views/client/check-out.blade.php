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
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Billing details</h1>
            <form action="{{ route('checkout.store') }}" method="post" >
                @csrf
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">Full Name<sup>*</sup></label>
                                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name ?? '' }}">
                                    @error('name')
                                    <small id="name" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Address <sup>*</sup></label>
                            <input type="text" class="form-control" placeholder="House Number Street Name" name="specific_address">
                            @error('address')
                            <small id="title" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                          <div class="col-xl-4">

                              <div class="form-item">
                                  <label class="form-label my-3">City<sup>*</sup></label>
                                 <select class="form-control" id="province" name="province" style="background-color: aliceblue" data-url="{{ route('districts.address') }}">
                                     <option value="0" selected>Chọn tỉnh/Thành phố</option>
                                     @foreach($provinces as $items)
                                     <option value="{{ $items->ProvinceID }} - {{ $items->ProvinceName }}">{{ $items->ProvinceName }}</option>
                                     @endforeach
                                 </select>
                                  @error('city')
                                  <small id="title" class="form-text text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                          </div>
                            <div class="col-xl-4">
                                <div class="form-item">
                                    <label class="form-label my-3">District<sup>*</sup></label>
                                    <select class="form-control" id="district" name="district" data-url="{{ route('wards.address') }}">
                                        <option value="0" selected>Chọn Quận/Huyện</option>
                                    </select>
                                    @error('district')
                                    <small id="title" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-item">
                                    <label class="form-label my-3">Ward<sup>*</sup></label>
                                    <select class="form-control" id="ward" name="ward"  data-url="{{ route('shipping.check') }}" >
                                        <option value="0" selected>Chọn Phường/Xã</option>
                                    </select>
                                    @error('ward')
                                    <small id="title" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-item">
                            <label class="form-label my-3">Mobile<sup>*</sup></label>
                            <input type="tel" class="form-control" name="phone"  value="{{ Auth::user()->phone ?? '' }}">
                            @error('phone')
                            <small id="phone" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Email Address<sup>*</sup></label>
                            <input type="email" class="form-control" name="email" value="{{ Auth::user()->email ?? '' }}">
                            @error('email')
                            <small id="email" class="form-text text-danger">{{ $message }}</small>
                            @enderror
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
                                        <th scope="col">Products</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Sale</th>
                                        <th scope="col">Quantity</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @php $total = 0 @endphp
                                @if(session()->has('cart'))
                                  @foreach(session()->get('cart') as $items)
                                      @php $total += $items['price'] * $items['quantity'] @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center mt-2">
                                                <img src="{{ asset('client/assets/img/vegetable-item-2.jpg') }}" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                            </div>
                                        </th>
                                        <td class="py-5" id="name">{{ $items['name'] }}</td>
                                        <td class="py-5" id="price_regular">{{ number_format($items['price_regular'])}}</td>
                                        <td class="py-5" id="price_sale">{{ number_format($items['price_sale']) }}</td>
                                        <td class="py-5" id="quantity">{{ $items['quantity']}}</td>
                                    </tr>
                                  @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="bg-light rounded">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="mb-0 me-4">Tạm tính:</h5>
                                            <p class="mb-0">{{ number_format($total) }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <h5 class="mb-0 me-4">Shipping</h5>
                                            <div class="">
                                                <p class="mb-0" id="service_fee">0.00</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                        <h5 class="mb-0 ps-4 me-4">Total</h5>
                                        <p class="mb-0 pe-4" id="total_cart" data-total="{{ $total }}">{{ number_format($total) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="radio" class="form-check-input bg-primary border-0" id="Delivery-1" name="payment_method" value="2">
                                    <label class="form-check-label" for="Delivery-1">Thanh toán khi nhận hàng</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="radio" class="form-check-input bg-primary border-0" id="2" name="payment_method" value="VNPAYQR">
                                    <label class="form-check-label" for="Paypal-1">Thanh toán VNPAY</label>
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

                    document.addEventListener("DOMContentLoaded", function() {
                    @if(session('error'))
                    alert('{{ session('error') }}');
                    @endif
                    });
            </script>
            <script src="{{ asset('admin/assets/js/check-out/address_shipping.js') }}"></script>
        @endsection
    </div>
@endsection


