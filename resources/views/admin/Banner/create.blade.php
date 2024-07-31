@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatable/index.min.css') }}"/>
    <style>
        #image-img {
            width: 100px;
            height: 100px;
            object-fit: cover; /* Đảm bảo hình ảnh được cắt và hiển thị đúng tỷ lệ */
            cursor: pointer;
            border-radius: 8px;
            margin: 20px;
            border: 2px solid #ddd; /* Thêm viền để hình ảnh nổi bật hơn */
        }

        .image-container {
            position: relative;
            width: 100px; /* Đặt kích thước của khung chứa phù hợp với kích thước của ảnh */
            height: 100px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd; /* Thêm viền cho khung chứa */
            border-radius: 8px;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-container .btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Mới Banner</h5>
                        <!-- General Form Elements -->
                        <form action="{{ route('banners.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <!-- Cột cho Title -->
                                <div class="col-md-6">
                                    <label for="title" class="form-label">Tiêu đề</label>
                                    <input type="text" id="title" class="form-control" name="title"
                                           value="{{ old('title') }}">
                                    {!! ShowError($errors, 'title') !!}
                                </div>
                                <!-- Cột cho Image -->
                                <div class="col-md-6">
                                    <div class="image-container">
                                        <a id="lfm" class="icon camera" title="Chọn Hình" data-input="thumbnail"
                                           data-preview="image-img" data-base64="inputBase64">
                                            <i class="fa fa-camera"></i>
                                        </a>
                                        <input id="thumbnail" class="form-control" type="hidden" name="image">
                                        <input type="hidden" id="inputBase64" name="base64">
                                        <img id="image-img"
                                             src="{{ old('image') ? asset(old('image')) : asset('client/assets/img/NoImage.png') }}"/>
                                    </div>
                                    {!! ShowError($errors, 'image') !!}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Home Switch -->
                                <div class="col-md-1">
                                    <label for="homeSwitch" class="form-label">Home</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="homeSwitch" name="is_home"
                                               value="1" {{ old('is_home', 1) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="homeSwitch">
                                            {{ old('is_home', 1) == 1 ? 'Yes' : 'No' }}
                                        </label>
                                    </div>
                                </div>
                                <!-- Active Switch -->
                                <div class="col-md-1">
                                    <label for="activeSwitch" class="form-label">Active</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activeSwitch"
                                               name="is_active"
                                               value="1" {{ old('is_active', 1) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activeSwitch">
                                            {{ old('is_active', 1) == 1 ? 'Yes' : 'No' }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Submit and Cancel Buttons -->
                                <div class="col-md-12 text-end">
                                    <a href="{{ route('banners.index') }}" class="btn btn-info me-2">Quay Lại</a>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('admin/js/app.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/select2/index.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // File Manager button
            $('#lfm').filemanager('image');

            // Initialize Select2 if needed
            $('.select2-multiple').select2({
                placeholder: "Chọn",
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#lfm').filemanager('image');
            $('#image-img').on('click', function () {
                $('#lfm').trigger('click');
            });
            window.setFileField = function (fileUrl) {
                $('#thumbnail').val(fileUrl);
                $('#image-img').attr('src', fileUrl);
            };
        });
    </script>
@endsection
