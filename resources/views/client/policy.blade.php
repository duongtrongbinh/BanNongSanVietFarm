@extends('client.layouts.master')
@section('title', 'Chính sách')
@section('content')
    <style>
        .section-title {
            color: #81c408;
            background-color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
        }
        .policy-title {
            color: #81c408;
            font-size: 1.5rem;
            margin-top: 20px;
        }
        .policy-content {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .policy-card {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            height: 250px;
        }
        .policy-card h5 {
            color: #81c408;
            font-size: 1.25rem;
        }
        .policy-card p {
            font-size: 1rem;
            color: #666;
        }
        .policy-icon {
            background-color: #81c408;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #fff;
            margin-bottom: 20px;
        }
        .policy-icon i {
            font-size: 1.25rem;
        }
        .container-xxl {
            padding: 60px 0;
        }
        .wow {
            animation-duration: 1s;
            animation-name: fadeInUp;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Chính sách</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white"><a href="{{route('policy.index')}}">Chính sách</a></li>
        </ol>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Chính sách chất lượng -->
                <div class="col-md-6 wow fadeInUp"  data-wow-delay="0.1s">
                    <div class="policy-card">
                        <div class="policy-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h5 class="policy-title">Chất lượng sản phẩm</h5>
                        <p class="policy-content">Chúng tôi cam kết cung cấp rau củ quả và nông sản chất lượng cao nhất. Tất cả sản phẩm của chúng tôi đều được kiểm tra chất lượng kỹ lưỡng trước khi đến tay khách hàng.</p>
                    </div>
                </div>
                <!-- Chính sách giao hàng -->
                <div class="col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="policy-card">
                        <div class="policy-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h5 class="policy-title">Chính sách giao hàng</h5>
                        <p class="policy-content">Chúng tôi cung cấp dịch vụ giao hàng nhanh chóng và thuận tiện. Đơn hàng sẽ được xử lý và giao trong vòng 2-3 ngày làm việc. Chúng tôi đảm bảo sản phẩm đến tay bạn trong tình trạng tươi mới nhất.</p>
                    </div>
                </div>
                <!-- Chính sách đổi trả -->
                <div class="col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="policy-card">
                        <div class="policy-icon">
                            <i class="fas fa-retweet"></i>
                        </div>
                        <h5 class="policy-title">Chính sách đổi trả</h5>
                        <p class="policy-content">Nếu bạn gặp bất kỳ vấn đề gì với sản phẩm, bạn có thể yêu cầu đổi trả trong vòng 7 ngày kể từ ngày nhận hàng. Sản phẩm phải còn nguyên vẹn và chưa qua sử dụng.</p>
                    </div>
                </div>
                <!-- Chính sách bảo mật thông tin -->
                <div class="col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="policy-card">
                        <div class="policy-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h5 class="policy-title">Chính sách bảo mật thông tin</h5>
                        <p class="policy-content">Chúng tôi cam kết bảo vệ thông tin cá nhân của bạn. Mọi thông tin sẽ được lưu trữ an toàn và chỉ sử dụng cho mục đích phục vụ khách hàng.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
