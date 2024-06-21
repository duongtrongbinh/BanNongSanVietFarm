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
                        <h5 class="card-title">Sửa thông tin khách hàng</h5>

                        <!-- General Form Elements -->
                        <form action="{{route('user.update',$user)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <!-- Cột cho Name -->
                                <div class="col-md-6">
                                    <label for="inputText" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                                    {!! ShowError($errors,'name') !!}
                                </div>
                                <div class="col-md-6">
                                    <label for="inputText" class="col-sm-2 col-form-label">User Code</label>
                                    <input type="text" class="form-control" name="user_code" value="{{ old('user_code', $user->user_code) }}">
                                    {!! ShowError($errors,'user_code') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="inputText" class="col-sm-2 col-form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                                    {!! ShowError($errors,'email') !!}
                                </div>
                                <div class="col-md-6">
                                    <label for="inputText" class="col-sm-2 col-form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
                                    {!! ShowError($errors,'phone') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-2">
                                    <label for="inputStatus" class="col-form-label">Status</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="statusSwitch" name="status" value="1" {{ old('status', $user->status) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="statusSwitch">
                                            {{ old('status', $user->status) == 1 ? 'Bật' : 'Tắt' }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="inputActive" class="col-form-label">Active</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activeSwitch" name="active" value="1" {{ old('active', $user->active) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activeSwitch">
                                            {{ old('active', $user->active) == 1 ? 'Hoạt Động' : 'Ngừng Hoạt Động' }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Avatar -->
                                <div class="col-sm-2">
                                    <label for="inputAvatar" class="col-form-label">Avatar</label>
                                </div>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary btn-sm text-white">
                                            <i class="fa fa-picture-o"></i> Avatar
                                        </a>
                                        <input id="thumbnail" class="form-control" type="hidden" name="avatar" value="{{ old('avatar', $user->avatar) }}">
                                    </div>
                                    <div id="holder" style="margin-top: 15px; max-height: 100px;"></div>

                                    <!-- Kiểm tra và hiển thị lỗi cho image -->
                                    @if($errors->has('avatar'))
                                        <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label text-end">Address</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="address" value="{{ old('address', $user->address) }}">
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

    @section('js')
        <script src="{{asset('admin.js.app')}}"></script>
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
            function updateStatus() {
                document.getElementById('updateStatusForm').submit();
            }
        </script>
    @endsection
@endsection

