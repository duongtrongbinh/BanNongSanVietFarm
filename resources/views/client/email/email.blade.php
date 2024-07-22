
Dưới đây là cách điều chỉnh nội dung email để bao gồm thời gian đăng ký tài khoản:

blade
Sao chép mã
<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận tài khoản</title>
</head>
<body>
<h2>Xin chào, {{ $authenticatedUser->name }}</h2>
<p>Cảm ơn bạn đã đăng ký tài khoản tại Nông sản Việt vào hồi {{ $authenticatedUser->created_at->format('H:i:s \n\g\à\y d/m/Y') }}</p>
<p>Nông sản việt ,Xin vui lòng cảm ơn</p>
</body>
</html>
