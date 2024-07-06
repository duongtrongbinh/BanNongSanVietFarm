@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatable/index.min.css') }}"/>
@endsection
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Mới Banner</h5>

                        <!-- General Form Elements -->
                        <form action="{{route('banners.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <!-- Cột cho Title -->
                                <div class="col-md-6">
                                    <label for="inputText" class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                    {!! ShowError($errors,'title') !!}
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Image</label>
                                    <div class="d-flex align-items-center">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder"
                                           class="btn btn-primary text-white me-2">
                                            <i class="fa fa-picture-o"></i> Image
                                        </a>
                                        <input id="thumbnail" class="form-control d-none" type="hidden" name="image"
                                               value="{{ old('image') }}">
                                        <div id="holder" style="margin-top:0; max-height:100px; max-width: 80px;">
                                            @if (old('image'))
                                                <img src="{{ asset(old('image')) }}" style="width: 60px">
                                            @endif
                                        </div>
                                    </div>
                                    @if($errors->has('image'))
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputHome" class="col-sm-2 col-form-label">Home</label>
                                <div class="col-sm-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="homeSwitch" name="is_home"
                                               value="1" {{ old('is_home', 1) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="homeSwitch">
                                            {{ old('is_home', 1) == 1 ? 'Yes' : 'No' }}
                                        </label>
                                    </div>
                                </div>
                                <label for="inputActive" class="col-sm-2 col-form-label">Active</label>
                                <div class="col-sm-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activeSwitch"
                                               name="is_active" value="1" {{ old('is_active', 1) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activeSwitch">
                                            {{ old('is_active', 1) == 1 ? 'Yes' : 'No' }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2 text-end">
                                    <a href="{{ route('banners.index') }}" class="btn btn-info me-2">Quay Lại</a>
                                    <!-- me-2 để margin-right 2 -->
                                    <button type="submit" class="btn btn-primary">Submit Form</button>
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
    <script src="{{asset('admin.js.app')}}"></script>
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
@endsection
