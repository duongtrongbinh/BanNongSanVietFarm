
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in/up Form</title>
    <!-- Font Awesome -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('client/assets/css/auth.css') }}">
</head>
<body>  
<div class="container" id="container">
    <!-- Sign In Container -->
    <div class="form-container sign-in-container">
        <form action="{{ route('login') }}" method="post">
            @csrf
            <h1>Đăng nhập</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="{{ route('auth.google') }}" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>Sử dụng tài khoản của bạn</span>
            <input type="email" placeholder="Email" name="email">
                     {!! ShowError($errors, 'email') !!}
            <input type="password" placeholder="Password" name="password">
            {!! ShowError($errors, 'password') !!}
            <a href="#">Quên mật khẩu?</a>
            <button type="submit">Đăng Nhập</button>
        </form>
    </div>
    <!-- Overlay Container for Transition -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
               <a href="{{route('register')}}">
                   <button class="ghost" id="signUp">Đăng Ký</button>
               </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
