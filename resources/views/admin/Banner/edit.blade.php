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
                        <h5 class="card-title">Sửa thông banner</h5>

                        <!-- General Form Elements -->
                        <form action="{{route('banners.update',$banner->id)}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <!-- Cột cho Name -->
                                <div class="col-md-6">
                                    <label for="inputText" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="title"
                                           value="{{ old('name', $banner->title) }}">
                                    {!! ShowError($errors,'name') !!}
                                </div>
                                <div class="col-md-6">
                                    <label for="inputAvatar" class="col-form-label">Image</label>
                                    <div class="d-flex align-items-center">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary btn-sm text-white me-2">
                                            <i class="fa fa-picture-o"></i> Image
                                        </a>
                                        <input id="thumbnail" class="form-control d-none" type="hidden" name="image" value="{{ old('image', $banner->image) }}">
                                        @if ($banner->image)
                                            <img src="{{ asset($banner->image) }}" width="80px" class="ms-2">
                                        @else
                                            <span class="text-muted ms-2">Không có ảnh</span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="inputStatus" class="col-form-label">Home</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="statusSwitch" name="is_home"
                                               value="1" {{ old('status', $banner->is_home) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusSwitch">
                                            {{ old('status', $banner->status) == 1 ? 'Yes' : 'No' }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="inputActive" class="col-form-label">Active</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activeSwitch"
                                               name="is_active"
                                               value="1" {{ old('is_active', $banner->is_active) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activeSwitch">
                                            {{ old('is_active', $banner->is_active) == 1 ? 'Yes' : 'No' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2 text-end">
                                    <a href="{{ route('user.index') }}" class="btn btn-info me-2">Quay Lại</a>
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

            function updateStatus() {
                document.getElementById('updateStatusForm').submit();
            }
        </script>
    @endsection
@endsection

