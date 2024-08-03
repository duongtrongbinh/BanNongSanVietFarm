@extends('client.layouts.master')
@section('title', 'Check Out')
@section('css')
      sup {
          color: red;
      }
      .coupon .kanan {
      border-left: 1px dashed #ddd;
      width: 40% !important;
      position:relative;
      }

      .coupon .kanan .info::after, .coupon .kanan .info::before {
      content: '';
      position: absolute;
      width: 20px;
      height: 20px;
      background: #dedede;
      border-radius: 100%;
      }
      .coupon .kanan .info::before {
      top: -10px;
      left: -10px;
      }

      .coupon .kanan .info::after {
      bottom: -10px;
      left: -10px;
      }
      .coupon .time {
      font-size: 1.6rem;
      }
@endsection

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Thanh toán</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-white">Checkout</li>
        </ol>
    </div>
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Thanh toán</h1>
            <form action="{{ route('checkout.store') }}" method="post" >
                @csrf
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">Họ và Tên:<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name ?? '' }}">
                                    @error('name')
                                    <small id="name" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Số điện thoại<sup class="text-danger">*</sup></label>
                            <input type="tel" class="form-control" name="phone"  value="{{ Auth::user()->phone ?? '' }}">
                            @error('phone')
                            <small id="phone" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Email<sup class="text-danger">*</sup></label>
                            <input type="email" class="form-control" name="email" value="{{ Auth::user()->email ?? '' }}">
                            @error('email')
                            <small id="email" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Chi tiết địa chỉ: <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" placeholder="House Number Street Name" name="specific_address">
                            @error('specific_address')
                            <small id="title" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">
                          <div class="col-xl-4">
                              <div class="form-item">
                                  <label class="form-label my-3">Tỉnh/Thành Phố<sup class="text-danger">*</sup></label>
                                 <select class="form-control" id="province" name="province" style="background-color: aliceblue" data-url="{{ route('districts.address.client') }}">
                                     <option value="0" selected>Chọn tỉnh/Thành phố</option>
                                     @foreach($provinces as $items)
                                     <option value="{{ $items->ProvinceID }} - {{ $items->ProvinceName }}">{{ $items->ProvinceName }}</option>
                                     @endforeach
                                 </select>
                                  @error('province')
                                  <small id="title" class="form-text text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                          </div>
                            <div class="col-xl-4">
                                <div class="form-item">
                                    <label class="form-label my-3">Quận/Huyện<sup class="text-danger">*</sup></label>
                                    <select class="form-control" id="district" name="district" data-url="{{ route('wards.address.client') }}">
                                        <option value="0" selected>Chọn Quận/Huyện</option>
                                    </select>
                                    @error('district')
                                    <small id="title" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-item">
                                    <label class="form-label my-3">Phường/Xã<sup class="text-danger">*</sup></label>
                                    <select class="form-control" id="ward" name="ward"  data-url="{{ route('shipping.check') }}" >
                                        <option value="0" selected>Chọn Phường/Xã</option>
                                    </select>
                                    @error('ward')
                                    <small id="title" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                         <div>
                                <textarea class="form-control" spellcheck="false" cols="30" rows="11" placeholder="Oreder Notes (Optional)" name="note"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-5">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Ảnh</th>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Giảm giá</th>
                                        <th scope="col">Số lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(session()->has('cart'))
                                  @foreach(session()->get('cart') as $items)
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center mt-2">
                                                <img src="{{ asset($items['image']) }}" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
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
                        <div class="dropdown topbar-head-dropdown ms-1 header-item">
                                <h5
                                    class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle position-relative my-auto cart-button"
                                    data-url=""
                                    style="outline: none; box-shadow: none; color: #81c408;" id="page-header-voucher-dropdown"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                                    aria-expanded="false">
                                    Áp dụng mã giảm giá
                                </h5>
                                <div class="dropdown-menu dropdown-menu-right p-0" style="min-width: 25.25rem; max-height: 400px; overflow-y: auto;" aria-labelledby="page-header-cart-dropdown">
                                    <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-16 fw-semibold">Mã giảm giá</h6>
                                            </div>
                                            <div class="col-auto">

                                            </div>
                                        </div>
                                    </div>
                                    <div data-simplebar style="max-height: 100%;" class="div-cart" >
                                        @foreach($vouchers as $item)
                                            <div class="card mt-3">
                                                <div class="coupon bg-white rounded mb-3 d-flex justify-content-between">
                                                    <div class="kiri p-3 mt-1">
                                                        <div class="icon-container ">
                                                            <div class="icon-container_box">
                                                                <img src="data:image/png;base64,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" width="50" alt="totoprayogo.com" class="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tengah d-flex w-100 justify-content-start">
                                                        <div>
                                                            <span class="badge badge-success">Valid</span>
                                                            <h6 class="">{{ $item->title }}</h6>
                                                            <p class="">{{ $item->description }}</p>
                                                            <p > Giá trị : {{  number_format($item->amount)}} %</p>
                                                            <span class="">HSD: {{ $item->end_date ? \Illuminate\Support\Carbon::parse($item->end_date)->format('d/m/Y') : 'vô thời hạn' }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="kanan mt-3">
                                                        <div class="info m-3 d-flex align-items-center">
                                                            <div class="w-100">
                                                                <input class="form-check-input voucher_apply" type="radio" name="voucher" id="voucher" value="{{ $item->id }}" data-url="{{ route('voucher.apply') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="bg-light rounded">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h6 class="mb-0 me-4">Tạm tính:</h6>
                                            <p class="mb-0">{{ number_format($total) }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0 me-4">Phí vận chuyển :</h6>
                                            <div class="">
                                                <p class="mb-0" id="service_fee">0.00</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <h6 class="mb-0 me-4">Mã giảm giá :</h6>
                                            <div class="">
                                                <p class="mb-0" id="service_fee">0.00</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                        <h6 class="mb-0 ps-4 me-4">Tổng:</h6>
                                        <p class="mb-0 pe-4" id="total_cart" data-total="{{ $total }}">{{ number_format($total) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="radio" class="form-check-input bg-primary border-0" id="Delivery-1" name="payment_method" value="2" {{ !isset(Auth::user()->id) ? 'checked' : '' }} >
                                    <label class="form-check-label" for="Delivery-1">Thanh toán khi nhận hàng</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">

                                    <input type="radio" class="form-check-input bg-primary border-0" id="2" name="payment_method" value="VNPAYQR" {{ isset(Auth::user()->id) ? 'checked' : ''}} >
                                    <label class="form-check-label" for="Paypal-1">Thanh toán VNPAY</label>
                                </div>
                            </div>
                        </div>
                        @error('payment_method')
                        <small id="email" class="form-text text-danger">{{ $message }}</small>
                        @enderror
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


