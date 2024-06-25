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
                                    <input type="text" class="form-control" name="name" >
                                    @error('name')
                                    <small id="name" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Address <sup>*</sup></label>
                            <input type="text" class="form-control" placeholder="House Number Street Name" name="address">
                            @error('address')
                            <small id="title" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                          <div class="col-xl-4">

                              <div class="form-item">
                                  <label class="form-label my-3">City<sup>*</sup></label>
                                 <select class="form-control" id="province" name="province" data-url="{{ route('provinces.find') }}" style="background-color: aliceblue">
                                     <option value="0" selected>Chọn tỉnh/Thành phố</option>
                                     @foreach($provinces as $items)
                                     <option value="{{ $items->id }} - {{ $items->name }}">{{ $items->name }}</option>
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
                                    <select class="form-control" id="district" name="district" data-url="{{ route('district.find') }}" >
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
                                    <select class="form-control" id="ward" name="ward" >
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
                            <input type="tel" class="form-control" name="phone" >
                            @error('phone')
                            <small id="phone" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Email Address<sup>*</sup></label>
                            <input type="email" class="form-control" name="email" >
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
                                  @foreach(session()->get('cart') as $items)
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center mt-2">
                                                <img src="{{ asset('client/assets/img/vegetable-item-2.jpg') }}" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                            </div>
                                        </th>
                                        <td class="py-5" id="name">{{ $items['name'] }}</td>
                                        <td class="py-5" id="price_regular">{{ $items['price_regular']}}</td>
                                        <td class="py-5" id="price_sale">{{ $items['price_sale'] }}</td>
                                        <td class="py-5" id="quantity">{{ $items['quantity']}}</td>
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
                $(document).ready(function() {
                    $("#province").on("change",function (){
                        var url = $(this).data('url');
                        var id = $(this).val();
                        $.ajax({
                            url: url,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                province_id: id
                            },
                            dataType: 'json',
                            success: function (response) {
                                renderDistrictOptions(response.data);
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                                alert('Có lỗi xảy ra khi lấy dữ liệu quận huyện!');
                            }
                        });
                    })

                    $("#district").on("change",function (){
                        var url = $(this).data('url');
                        var id = $(this).val();
                        $.ajax({
                            url: url,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                district_id: id
                            },
                            dataType: 'json',
                            success: function (response) {
                                renderWardOptions(response.data);
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                                alert('Có lỗi xảy ra khi lấy dữ liệu quận huyện!');
                            }
                        });
                    })

                    function renderDistrictOptions(data) {
                        let optionsHtml = '';
                        if (data != null) {
                            var district = data.district
                            district.forEach(function (item) {
                                optionsHtml += `<option value="${item.id} - ${item.name}">${item.name}</option>`;
                            });
                            $('#district').html(optionsHtml);
                        }else{
                            $('#district').html(' <option value="0">Chọn Quận/Huyện</option>');
                        }
                    }

                    function renderWardOptions(data) {
                        let optionsHtml = '';
                        var district = data.ward
                        district.forEach(function (item) {
                            optionsHtml += `<option value="${item.id} - ${ item.name }">${item.name}</option>`;
                        });
                        $('#ward').html(optionsHtml);
                    }

                })
            </script>
        @endsection
    </div>
@endsection


