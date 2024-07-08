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
                        <h5 class="card-title">Thêm Mới Thành Viên</h5>

                        <!-- General Form Elements -->
                        <form action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <!-- Cột cho Title -->
                                <div class="col-md-6">
                                    <label for="inputText" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    {!! ShowError($errors,'name') !!}
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Avatar</label>
                                    <div class="input-group">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder"
                                           class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> Avatar
                                        </a>
                                        <input id="thumbnail" class="form-control" type="hidden" name="avatar"
                                               value="{{ old('avatar') }}">
                                    </div>
                                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                                    <!-- Kiểm tra và hiển thị lỗi cho image -->
                                    @if($errors->has('avatar'))
                                        <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="inputText" class="col-sm-2 col-form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{old('email')}}">
                                    {!! ShowError($errors,'email') !!}
                                </div>
                                <div class="col-md-6">
                                    <label for="inputText" class="col-sm-2 col-form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                                    {!! ShowError($errors,'phone') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                <label for="inputText" class="col-sm-2 col-form-label">Password</label>
                                    <input type="password" class="form-control" name="password">
                                    {!! ShowError($errors,'password') !!}
                                </div>
                                <div class="col-md-6">
                                <label for="inputText" class="col-sm-2 col-form-label">User Code</label>
                                    <input type="text" class="form-control" name="user_code"
                                           value="{{old('user_code')}}">
                                    {!! ShowError($errors,'user_code') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputStatus" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activeSwitch" name="status" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>                                        <label class="form-check-label" for="statusSwitch">
                                            {{ old('status', 1) == 1 ? 'Bật' : 'Tắt' }}
                                        </label>
                                    </div>
                                </div>
                                <label for="inputActive" class="col-sm-2 col-form-label">Active</label>
                                <div class="col-sm-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activeSwitch" name="active" value="1" {{ old('active', 1) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activeSwitch">
                                            {{ old('active', 1) == 1 ? 'Hoạt Động' : 'Ngừng Hoạt Động' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label text-end">Address</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="address" value="{{ old('address') }}">
                                    {!! ShowError($errors,'address') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2 text-end">
                                    <a href="{{ route('user.index') }}" class="btn btn-info me-2">Quay Lại</a> <!-- me-2 để margin-right 2 -->
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
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>



@endsection
