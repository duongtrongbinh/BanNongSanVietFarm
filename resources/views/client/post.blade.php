@extends('client.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatable/index.min.css') }}" />
@endsection
@section('title', 'Post')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Post</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Shop Detail</li>
        </ol>
    </div>

    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-8 col-xl-9">
                    <form id="post-form" action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h4 class="mb-5 fw-bold">Post bài viết</h4>
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label for="title" class="form-label">Tiêu đề</label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Nhập tiêu đề bài viết" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="image" class="form-label">Hình ảnh</label>
                                <div class="input-group">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> Image
                                    </a>
                                    <input id="thumbnail" class="form-control" type="hidden" name="image" value="{{ old('image') }}">
                                </div>
                                <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="4" placeholder="Nhập mô tả bài viết" spellcheck="false"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label for="content" class="form-label">Nội dung</label>
                                    <textarea name="content" class="form-control" id="content" cols="30" rows="8" placeholder="Nhập nội dung bài viết" spellcheck="false" required></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between py-3 mb-5">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-3">Post Bài Viết</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script>
    <script src="/path-to-your-tinymce/tinymce.min.js"></script>
    <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>
@endsection
@section('js')
    <!-- Include any custom JavaScript here, if needed -->
@endsection
