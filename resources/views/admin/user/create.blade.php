@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatable/index.min.css') }}"/>
@endsection
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                 @csrf
                    <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Mới Thành Viên</h5>

                            <div class="row mb-3">
                                <!-- Name Field -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Tên khách hàng</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ old('name') }}">
                                    {!! ShowError($errors, 'name') !!}
                                </div>

                                <!-- Email Field -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ old('email') }}">
                                    {!! ShowError($errors, 'email') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Phone Field -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                           value="{{ old('phone') }}">
                                    {!! ShowError($errors, 'phone') !!}
                                </div>
                                <!-- Password Field -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    {!! ShowError($errors, 'password') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
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
                            </div>
                            <div class="row mb-3">
                                <!-- Address Field -->
                                <div class="col-md-12">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <textarea class="form-control" id="address"
                                              name="address">{{ old('address') }}</textarea>
                                    {!! ShowError($errors, 'address') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Avatar Field -->
                                <div class="col-md-4">
                                    <label class="form-label">Hình ảnh</label>
                                    <div class="input-group">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder"
                                           class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> Hình ảnh
                                        </a>
                                        <input id="thumbnail" class="form-control" type="hidden" name="avatar"
                                               value="{{ old('avatar') }}">
                                    </div>
                                    <div id="holder" style="margin-top:15px; max-height:100px;">
                                        <!-- Hiển thị ảnh -->
                                        @if (old('avatar'))
                                            <img src="{{ old('avatar') }}" style="max-height:100px;">
                                        @endif
                                    </div>
                                    @if ($errors->has('avatar'))
                                        <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                    @endif
                                </div>

                                <!-- Status Switch -->
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="statusSwitch" name="status"
                                               value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusSwitch">
                                            {{ old('status', 1) == 1 ? 'Bật' : 'Tắt' }}
                                        </label>
                                    </div>
                                </div>

                                <!-- Active Switch -->
                                <div class="col-md-4">
                                    <label for="active" class="form-label">Active</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activeSwitch" name="active"
                                               value="1" {{ old('active', 1) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activeSwitch">
                                            {{ old('active', 1) == 1 ? 'Hoạt Động' : 'Ngừng Hoạt Động' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                           <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Vai Trò:</h4>
                                <div class="flex-shrink-0">

                                </div>
                            </div><!-- end card header -->
                            <div class="card-body">
                                <p class="text-muted">Danh vai trò:</p>
                                @error('roles')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="live-preview">
                                    <div class="row">
                                        @foreach($roles as $key => $item)
                                            <div class="col-md-4">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input permission-checkbox" type="checkbox" id="gridCheck1" name="roles[]" value="{{ $item->id }}" {{ $item->checked ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gridCheck1">{{ \App\Enums\Roles::from($item->id)->label() }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!--end row-->
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                            <div class="row mb-3">
                                <!-- Submit and Cancel Buttons -->
                                <div class="col-md-12 text-end">
                                    <a href="{{ route('user.index') }}" class="btn btn-info me-2">Quay Lại</a>
                                    <button type="submit" class="btn btn-primary">Submit Form</button>
                                </div>
                            </div>

                    </div>
                </div>

                </form>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{asset('admin.js.app')}}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script>
    <script src="/path-to-your-tinymce/tinymce.min.js"></script>
    <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script>
    <script>
        document.getElementById('checked-all').addEventListener('click', function() {
            const isChecked = this.checked;
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });

        $(document).ready(function () {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });
        });
    </script>
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
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>

@endsection
