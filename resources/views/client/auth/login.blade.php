<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in/up Form</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('client/assets/css/auth.css') }}">
</head>
<body>
<div class="container" id="container">
    <!-- Sign In Container -->
    @php
        $created = session('created');
    @endphp
    <div class="form-container sign-in-container">
        <form id="loginForm" action="{{ route('login') }}" method="post">
            @csrf
            <h1>Đăng nhập</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="{{ route('auth.google') }}" class="social"><i class="fab fa-google-plus-g"></i></a>
            </div>
            <span>Sử dụng tài khoản của bạn</span>
            <input type="email" placeholder="Email" name="email">
            <input type="password" placeholder="Password" name="password">
            <a href="{{route('password.request')}}">Quên mật khẩu?</a>
            <button type="submit">Đăng Nhập</button>
            <div class="alert" id="loginError" style="display: none; color: red"></div>
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
    $(document).ready(function() {
        // Hiển thị thông báo thành công nếu có
        let status = @json($created);
        let title = 'Bạn đã';
        let message = status;
        let icon = 'success';
        if (status) {
            showMessage(title, message, icon);
        }

        // Hiển thị thông báo lỗi nếu có
        @if (session('error'))
        Swal.fire({
            title: 'Lỗi',
            text: '{{ session('error') }}',
            icon: 'error',
            showConfirmButton: false,
            timer: 1500
        });
        @endif
    });

    $(document).ready(function() {
        $('#loginForm').submit(function(event) {
            // Prevent form submission
            event.preventDefault();
            var formData = $(this).serialize(); // Serialize form data
            // AJAX request to submit form data
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Redirect to the home page upon successful login
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    var response = xhr.responseJSON;
                    var errorMessage = response.message ? response.message : 'Tên tài khoản hoặc mật khẩu không đúng. Vui lòng thử lại.';
                    $('#loginError').text(errorMessage).show();
                }
            });
        });
    });
</script>
</body>
</html>
