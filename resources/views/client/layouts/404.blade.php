@extends('client.layouts.master')
@section('title', '404')
@section('content')
    <!-- Tiêu đề trang bắt đầu -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Lỗi 404</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#">Trang</a></li>
            <li class="breadcrumb-item active text-white">404</li>
        </ol>
    </div>
    <!-- Tiêu đề trang kết thúc -->


    <!-- 404 Bắt đầu -->
    <div class="container-fluid py-5">
        <div class="container py-5 text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <i class="bi bi-exclamation-triangle display-1 text-secondary"></i>
                    <h1 class="display-1">404</h1>
                    <h1 class="mb-4">Không tìm thấy trang</h1>
                    <p class="mb-4">Chúng tôi rất tiếc, trang bạn đang tìm kiếm không tồn tại trên trang web của chúng tôi! Có thể bạn nên quay lại trang chủ hoặc thử sử dụng công cụ tìm kiếm?</p>
                    <a class="btn border-secondary rounded-pill py-3 px-5" href="{{ route('home') }}">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 404 Kết thúc -->
@endsection
