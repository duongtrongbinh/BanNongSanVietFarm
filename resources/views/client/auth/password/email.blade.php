<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận email</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('client/assets/css/auth.css') }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f8f9fa;
        }
        .container {
            max-width: 400px;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #333;
            text-align: center;
        }
        span {
            display: block;
            margin-bottom: 1.5rem;
            color: #666;
            text-align: center;
        }
        input[type="email"] {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            background: #FF4B2B;
            color: #fff;
            font-size: 0.6rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #FF4B2B;
        }
        .alert {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Xác nhận email Container -->
    <form id="emailForm" action="{{ route('password.request') }}" method="post">
        @csrf
        <h1>Xác nhận email</h1>
        <span>Vui lòng nhập email của bạn đã đăng ký hệ thống của chúng tôi</span>
        <input type="email" placeholder="Email" name="email" class="form-control">
        <button type="submit">Gửi email xác nhận</button>
    </form>
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        @if (session('success'))
        Swal.fire({
            title: 'Thành công',
            text: '{{ session('success') }}',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
        });
        @endif

        @if (session('error'))
        Swal.fire({
            title: 'Lỗi',
            text: '{{ session('error') }}',
            icon: 'error',
            showConfirmButton: false,
            timer: 1500
        });
        @endif
        @if ($errors->any())
        Swal.fire({
            title: 'Lỗi',
            text: '{{ $errors->first() }}',
            icon: 'error',
            showConfirmButton: false,
            timer: 1500
        });
        @endif
    });
</script>
</body>
</html>
