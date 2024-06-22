@extends('client.layouts.master')

@section('title', 'Login')
<style>
    /* Điều chỉnh vị trí của form đăng nhập */
    .login-form {
        margin-top: 130px; /* Đảm bảo form đăng nhập không bị che bởi phần banner */
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Điều chỉnh vị trí của nút đăng nhập */
    .login-btn {
        margin-top: 20px; /* Điều chỉnh khoảng cách từ form đến nút */
    }

</style>
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card login-form">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary login-btn">{{ __('Login') }}</button>
                            </div>
                        </form>
                        <div class="d-grid mt-3">
                            <a href="{{ route('auth.google') }}" class="btn btn-danger">{{ __('Login with Google') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
