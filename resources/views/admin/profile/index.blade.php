@extends('admin.layout.master')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                             class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <h4>{{ auth()->user()->name }}</h4>
                        <p class="text-muted">{{ auth()->user()->email }}</p>
                        <a href="{{route('admin.profile')}}" class="btn btn-primary btn-sm mt-3 text-white">
                            <i class="bi bi-info-circle-fill me-2"></i>Thông tin chính
                        </a>
                        <a href="{{route('admin.showChangePasswordForm')}}"
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
                        <form action="{{ route('admin.profile.update', auth()->user()->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="name">Tên</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ auth()->user()->email }}">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Avatar</label>
                                <div class="input-group">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder"
                                       class="btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> Chọn Avatar
                                    </a>
                                    <input id="thumbnail" class="form-control" type="hidden" name="avatar"
                                           value="{{ old('avatar', auth()->user()->avatar) }}">
                                </div>
                                <div id="holder" style="margin-top:15px;max-height:100px;">
                                    <img src="{{ auth()->user()->avatar }}" alt="Current Avatar" class="img-thumbnail"
                                         style="max-height: 100px;">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập Nhật Hồ Sơ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script>
@endsection
