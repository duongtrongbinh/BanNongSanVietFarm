@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatable/index.min.css') }}" />
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
                                    <label class="form-label">Image</label>
                                    <div class="input-group">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> Image
                                        </a>
                                        <input id="thumbnail" class="form-control" type="hidden" name="image">
                                    </div>
                                    <div class="input-group">
                                        @if ($post->image)
                                            <img src="{{ asset($post->image) }}" width="80px">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Description -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="inputText" class="col-sm-2 col-form-label">Description</label>
                                    <input type="text" class="form-control" name="description" value="{{$post->description}}">
                                    {!! ShowError($errors,'description') !!}
                                </div>
                            </div>
                            <!-- Content -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="content" class="col-sm-2 col-form-label">Content</label>
                                    <textarea class="form-control my-editor-tinymce4" name="content" placeholder="Nhập content ...">{{$post->content}}</textarea>
                                    {!! ShowError($errors,'content') !!}
                                </div>
                            </div>
                            <!-- Buttons -->
                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2 ">
                                    <button type="submit" class="btn btn-primary pull-right">Submit Form</button>
                                    <span style="margin-right: 10px;"></span> <!-- Khoảng trống -->
                                    <a href="{{ route('post.index') }}" class="btn btn-info pull-right">Quay Lại</a>
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
            $(document).ready(function() {
                // Select2 Multiple
                $('.select2-multiple').select2({
                    placeholder: "Select",
                    allowClear: true
                });

            });

        </script>
    @endsection
@endsection
