
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in/up Form</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<link rel="stylesheet" href="{{ asset('client/assets/css/auth.css') }}">

<body>
<div class="container" id="container">
    <!-- Sign In Container -->
    <div class="form-container sign-in-container">
        <form action="{{ route('register') }}" method="post">
            @csrf
            <h1>Đăng ký</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>Sử dụng email của bạn để đăng ký</span>
            <input type="text" placeholder="Name" name="name" value="{{ old('name') }}">
            {!! ShowError($errors, 'name') !!}
            <input type="email" placeholder="Email" name="email" value="{{ old('email') }}">
            {!! ShowError($errors, 'email') !!}
            <input type="password" placeholder="Password" name="password">
            {!! ShowError($errors, 'password') !!}
            <button type="submit">Đăng ký</button>
        </form>
    </div>
    <!-- Overlay Container for Transition -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
                <a href="{{route('login')}}">
                    <button class="ghost" id="signUp">Đăng nhập</button>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Panel Transition -->
</body>
</html>
