<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in/up Form</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('client/assets/css/auth.css') }}">
</head>
<body>
<div class="container" id="container">
    <!-- Sign In Container -->
    <div class="form-container sign-in-container">
        <form id="loginForm" action="{{ route('clientlogin') }}" method="post">
            @csrf
            <h1>Đăng nhập</h1>
            <div class="social-container">
                <a href="{{ route('auth.facebook') }}" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="{{ route('auth.google') }}" class="social"><i class="fab fa-google-plus-g"></i></a>
            </div>
            <span>Sử dụng tài khoản của bạn</span>
            <input type="email" placeholder="Email" name="email">
            <div style="width: 100%; text-align: left">
                {!! ShowError($errors, 'email') !!}
            </div>

            <input type="password" placeholder="Password" name="password">
            <div style="width: 100%; text-align: left">
                {!! ShowError($errors, 'password') !!}
            </div>
            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
            <button type="submit">Đăng Nhập</button>
            <a href="{{ route('home') }}">Trang chủ</a>
        </form>
    </div>
    <!-- Overlay Container for Transition -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>Chào bạn!</h1>
                <p>Nhập thông tin cá nhân của bạn và bắt đầu hành trình với chúng tôi</p>
                <a href="{{ route('register') }}">
                    <button class="ghost" id="signUp">Đăng Ký</button>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Tải jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Tải SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Tệp JavaScript của bạn -->
<script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>
<script>
    $(document).ready(function () {
        // Hiển thị thông báo thành công nếu có
        @if (session('success'))
        Swal.fire({
            title: 'Thành công',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
        @endif
        // Hiển thị thông báo lỗi nếu có
        @if (session('error'))
        Swal.fire({
            title: 'Lỗi',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        @endif
    });
</script>

</body>
</html>
