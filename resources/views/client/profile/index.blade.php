@extends('client.layouts.master')
@section('title', 'Thông tin tài khoản')
@section('styles')
    <style>
        .form-group.mb-3 .row {
            align-items: center;
        }

        .form-group.mb-3 .col-md-6 {
            display: flex;
            align-items: center;
        }

        .form-group.mb-3 .col-md-6 > label {
            margin-right: 10px;
        }
    </style>
@endsection
@section('content')
    @php
        $updated= session('update');
    @endphp
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Thông tin khoản</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Tài khoản</li>
        </ol>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                             class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <h4>{{ auth()->user()->name }}</h4>
                        <p class="text-muted">{{ auth()->user()->email }}</p>
                        <a href="{{route('user.profile')}}" class="btn btn-primary btn-sm mt-3 text-white">
                            <i class="bi bi-info-circle-fill me-2"></i>Thông tin chính
                        </a>
                        <a href="{{route('user.showChangePasswordForm')}}"
                           class="btn btn-primary btn-sm mt-3 text-white">
                            <i class="bi bi-shield-lock-fill me-2"></i>Đổi mật khẩu
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Thông Tin Hồ Sơ</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.profile.update', auth()->user()->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">Tên</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ auth()->user()->name }}">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                   class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i>Avatar
                                                </a>
                                            </div>
                                            <input id="thumbnail" class="form-control" type="hidden" name="avatar"
                                                   value="{{ old('avatar', auth()->user()->avatar) }}">
                                        </div>
                                        <div id="holder" class="ml-3">
                                            <img src="{{ auth()->user()->avatar }}" alt="Current Avatar"
                                                 class="img-thumbnail" style="max-height: 50px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                               value="{{ auth()->user()->email }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                               value="{{ auth()->user()->phone }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-xl-4">

                                        <div class="form-item">
                                            <label class="form-label my-3">City<sup>*</sup></label>
                                            <select class="form-control" id="province" name="province"
                                                    style="background-color: aliceblue">
                                                <option value="0" selected>Chọn tỉnh/Thành phố</option>
                                                @foreach($provinces['data'] as $items)
                                                    <option
                                                            value="{{ $items['ProvinceID'] }} - {{ $items['ProvinceName'] }}">{{ $items['ProvinceName'] }}</option>
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
                                            <select class="form-control" id="district" name="district">
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
                                            <select class="form-control" id="ward" name="ward"
                                                    data-url="{{ route('shipping.check') }}">
                                                <option value="0" selected>Chọn Phường/Xã</option>
                                            </select>
                                            @error('ward')
                                            <small id="title" class="form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address">Địa chỉ</label>
                                    <textarea name="address" id="address"
                                              class="form-control">{{ auth()->user()->address }}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary text-white">Cập Nhật Hồ Sơ</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="path/to/addProduct.js"></script>
    <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if(session('error'))
            alert('{{ session('error') }}');
            @endif
        });
        $(document).ready(function () {
            var token = '29ee235a-2fa2-11ef-8e53-0a00184fe694';
            var to_district_id = 0;
            $("#province").on("change", function () {
                var url = 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district';
                var province = $(this).val();
                var parts = province.split(' - ');
                var id = +parts[0].trim();
                if (id != 0) {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'token': `${token}`,
                        },
                        data: {
                            province_id: id
                        },
                        success: function (response) {
                            renderDistrictOptions(response.data);
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Có lỗi xảy ra khi lấy dữ liệu quận huyện!');
                        }
                    });
                } else {
                    resetWard();
                    $('#district').html(' <option value="0">Chọn Quận/Huyện</option>');
                }

            })

            $("#district").on("change", function () {
                let urlWard = 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id';
                var district = $(this).val();
                var parts = district.split(' - ');
                var id = +parts[0].trim();
                to_district_id = id;
                if (id != 0) {
                    $.ajax({
                        url: urlWard,
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'token': `${token}`,
                        },
                        data: JSON.stringify({
                            district_id: id
                        }),
                        success: function (response) {
                            if (response.data != null) {
                                renderWardOptions(response.data);
                            } else {
                                resetWard()
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Có lỗi xảy ra khi lấy dữ liệu quận huyện!');
                        }
                    });
                    $.ajax({
                        url: urlWard,
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'token': `${token}`,
                        },
                        data: JSON.stringify({
                            district_id: id
                        }),
                        success: function (response) {
                            if (response.data != null) {
                                renderWardOptions(response.data);
                            } else {
                                resetWard()
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Có lỗi xảy ra khi lấy dữ liệu quận huyện!');
                        }
                    });
                } else {
                    resetWard();
                }
            })

            $("#ward").on("change", function () {
                let url = $(this).data('url')
                let Ward = $(this).val();
                var parts = Ward.split(' - ');
                var WardCode = parts[0].trim();
                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({
                        ward_code: WardCode,
                        district_id: to_district_id,
                    }),
                    success: function (response) {
                        var total_after = $("#total_cart").data('total');
                        var total_befor = total_after + response.data.total;

                        $("#service_fee").html(number_format(response.data.total));
                        $("#total_cart").html(number_format(total_befor, 2, '.', ','));
                    },
                });

            })

            function renderDistrictOptions(data) {
                let optionsHtml = '';
                if (data != null) {
                    data.forEach(function (item) {
                        optionsHtml += `<option value="${item.DistrictID} - ${item.DistrictName}">${item.DistrictName}</option>`;
                    });
                    $('#district').html(optionsHtml);
                } else {
                    $('#district').html(' <option value="0">Chọn Quận/Huyện</option>');
                }
            }

            function renderWardOptions(data) {
                let optionsHtml = '';
                data.forEach(function (item) {
                    optionsHtml += `<option value="${item.WardCode} - ${item.WardName}">${item.WardName}</option>`;
                });
                $('#ward').html(optionsHtml);
            }

            function resetWard() {
                $('#ward').html('<option value="0">Chọn Phường/Xã</option>');
            }


            function number_format(number, decimals, dec_point, thousands_sep) {
                // Kiểm tra và gán giá trị mặc định cho các tham số nếu chưa được cung cấp
                number = parseFloat(number);
                if (!decimals) decimals = 0;
                if (!dec_point) dec_point = '.';
                if (!thousands_sep) thousands_sep = ',';

                // Tách phần nguyên và phần thập phân
                var rounded_number = Math.round(Math.abs(number) * Math.pow(10, decimals)) / Math.pow(10, decimals);
                var number_string = rounded_number.toFixed(decimals);
                var parts = number_string.split('.');
                var int_part = parts[0];
                var dec_part = (parts[1] ? dec_point + parts[1] : '');

                // Thêm dấu phân cách hàng nghìn
                var pattern = /(\d+)(\d{3})/;
                while (pattern.test(int_part)) {
                    int_part = int_part.replace(pattern, '$1' + thousands_sep + '$2');
                }

                // Định dạng cuối cùng
                return (number < 0 ? '-' : '') + int_part + dec_part;
            }

        })
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Hiển thị thông báo thành công nếu có
            let status = @json($updated);
            let title = 'Bạn đã';
            let message = status;
            let icon = 'success';
            if (status) {
                showMessage(title, message, icon);
            }
        });

    </script>
@endsection


