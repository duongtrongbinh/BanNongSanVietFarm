<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa; /* Màu nền */
        }
        .container {
            margin-top: 5rem;
        }
        .card-header {
            background-color: #FF4B2B; /* Màu header card */
            color: #fff; /* Màu chữ header card */
        }
        .btn-primary {
            background-color: #FF4B2B; /* Màu nút */
            border: none;
        }
        .btn-primary:hover {
            background-color: #FF4B2B; /* Màu hover nút */
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card">
                <div class="card-header">Đặt lại mật khẩu</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.reset', ['user' => $user->id, 'token' => $token]) }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label for="password">Mật khẩu mới</label>
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Xác nhận mật khẩu mới</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <button type="submit" class="btn btn-primary">Đặt lại mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
