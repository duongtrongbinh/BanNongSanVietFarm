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
                        <h5 class="card-title">Sửa bài viết</h5>

                        <!-- General Form Elements -->
                        <form action="{{ route('post.update',$post) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <!-- Cột cho Title -->
                                <div class="col-md-6">
                                    <label for="inputText" class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{$post->title}}">
                                    {!! ShowError($errors,'title') !!}
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
                                             src="{{ $post->image ? asset($post->image) : asset('client/assets/img/avatar.jpg') }}"
                                    </div>
                                    {!! ShowError($errors, 'image') !!}
                                </div>
                            </div>
                            <!-- Description -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="inputText" class="col-sm-2 col-form-label">Description</label>
                                    <input type="text" class="form-control" name="description"
                                           value="{{$post->description}}">
                                    {!! ShowError($errors,'description') !!}
                                </div>
                            </div>
                            <!-- Content -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="content" class="col-sm-2 col-form-label">Content</label>
                                    <textarea class="form-control my-editor-tinymce4" name="content"
                                              placeholder="Nhập content ...">{{$post->content}}</textarea>
                                    {!! ShowError($errors,'content') !!}
                                </div>
                            </div>
                            <!-- Buttons -->
                            <div class="row mb-3">
                                <!-- Submit and Cancel Buttons -->
                                <div class="col-md-12 text-end">
                                    <a href="{{ route('user.index') }}" class="btn btn-info me-2">Quay Lại</a>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @section('js')
        <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script>
        <script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script>
        <script src="/path-to-your-tinymce/tinymce.min.js"></script>
        <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script>
        <script>
            $(document).ready(function () {
                // Select2 Multiple
                $('.select2-multiple').select2({
                    placeholder: "Select",
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
@endsection
