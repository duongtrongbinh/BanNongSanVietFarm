<!DOCTYPE html>
<html>
<head>
    <title>Kích hoạt tài khoản - Nông sản Việt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        p {
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Chào mừng bạn đến với Nông sản Việt!</h1>
    <p>Vui lòng nhấn vào liên kết dưới đây để kích hoạt tài khoản của bạn:</p>
    <a href="{{ route('user.activated', ['user' => $user->id, 'token' => $user->token]) }}">Kích hoạt tài khoản</a>
    <p>Nếu bạn không yêu cầu đăng ký tài khoản, vui lòng bỏ qua email này.</p>
</div>
</body>
</html>
