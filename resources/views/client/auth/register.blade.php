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
            <input type="text" placeholder="Tên của bạn" name="name" value="{{ old('name') }}" >
            <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" >
            <input type="password" placeholder="Mật khẩu" name="password" >
            <div class="submit-button">
                <button type="submit">Đăng ký</button>
            </div>
            <div id="alert" style="display: none; color: red; margin: 10px;"></div>
        </form>
    </div>
    <!-- Overlay Container for Transition -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>Chào bạn!</h1>
                <p>Nhập thông tin cá nhân của bạn và bắt đầu hành trình với chúng tôi</p>
                <a href="{{ route('clientlogin') }}">
                    <button class="ghost" id="signUp">Đăng nhập</button>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('register-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn chặn form gửi yêu cầu mặc định

        const form = event.target;
        const formData = new FormData(form);
        const alertBox = document.getElementById('alert');

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alertBox.style.display = 'block';
                    alertBox.innerHTML = data.message;
                    if (data.user) {
                        alertBox.style.color = 'green';
                        // Redirect to login or update UI accordingly
                        setTimeout(() => {
                            window.location.href = '{{ route('clientlogin') }}';
                        }, 2000);
                    } else {
                        alertBox.style.color = 'red';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alertBox.style.display = 'block';
                alertBox.style.color = 'red';
                alertBox.innerHTML = 'Có lỗi xảy ra. Vui lòng thử lại.';
            });
    });
</script>
</body>
</html>
