<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - Nông sản Việt</title>
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
    <h1>Xin chào {{$user->name}}</h1>
    <p>Bạn nhận được email này vì chúng tôi nhận được yêu cầu khôi phục mật khẩu cho tài khoản của bạn.</p>
    <p>Vui lòng nhấn vào liên kết dưới đây để thiết lập lại mật khẩu:</p>
    <p>Chú ý : Mã xác nhận trong link chỉ có hiện lực 72 giờ</p>
    <a href="{{ route('password.reset', ['user' => $user->id, 'token' => $token]) }}">
        <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
        <p>Xin cảm ơn!</p>
</div>
</body>
</html>
