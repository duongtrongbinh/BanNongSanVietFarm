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
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Đổi Mật Khẩu</h5>
                    </div>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('admin.profile.change_password') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="current_password">Mật Khẩu Hiện Tại</label>
                                <input type="password" name="current_password" id="current_password"
                                       class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="new_password">Mật Khẩu Mới</label>
                                <input type="password" name="new_password" id="new_password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="new_password_confirmation">Xác Nhận Mật Khẩu Mới</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                       class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Đổi Mật Khẩu</button>
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
