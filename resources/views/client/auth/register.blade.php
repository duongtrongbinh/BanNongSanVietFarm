<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('client/assets/css/auth.css') }}">
    <style>
        .submit-button {
            margin-top: 15px; /* Adjust margin top for the submit button */
        }
    </style>
</head>
<body>
<div class="container" id="container">
    <!-- Sign In Container -->
    <div class="form-container sign-in-container">
        <form id="register-form" action="{{ route('register') }}" method="post">
            @csrf
            <h1>Đăng ký</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
            </div>
            <span>Sử dụng email của bạn để đăng ký</span>
            <input type="text" placeholder="Tên của bạn" name="name" value="{{ old('name') }}">
            <div style="width: 100%; text-align: left">
                {!! ShowError($errors, 'name') !!}
            </div>
            <input type="email" placeholder="Email" name="email" value="{{ old('email') }}">
            <div style="width: 100%; text-align: left">
                {!! ShowError($errors, 'email') !!}
            </div>
            <input type="password" placeholder="Mật khẩu" name="password">
            <div style="width: 100%; text-align: left">
                {!! ShowError($errors, 'password') !!}
            </div>
            <div class="submit-button">
                <button type="submit">Đăng ký</button>
            </div>
            <a href="{{ route('home') }}">Trang chủ</a>
        </form>

    </div>
    <!-- Overlay Container for Transition -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>Chào bạn!</h1>
                <p>Nhập thông tin cá nhân của bạn và bắt đầu hành trình với chúng tôi</p>
                <a href="{{ route('login') }}">
                    <button class="ghost" id="signUp">Đăng nhập</button>
                </a>
            </div>
        </div>
    </div>
</div>

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
