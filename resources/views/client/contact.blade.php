@extends('client.layouts.master')
@section('title', 'Liên hệ')
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Liên Hệ</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white"><a href="{{route('contact.index')}}">Liên hệ</a></li>
        </ol>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Thông tin liên hệ -->
                <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                    <h5>Liên lạc</h5>
                    <div class="col-md-8">
                        <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet
                            diam et
                            eos</p>
                        <div class="d-flex align-items-center mb-4">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width: 50px; height: 50px; background-color: #81c408;">
                                <i class="fa fa-map-marker-alt text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="text-primary" style="color: #81c408;">Văn phòng</h5>
                                <p class="mb-0">123 Street, Hà Nội, Việt Nam</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width: 50px; height: 50px; background-color: #81c408;">
                                <i class="fa fa-phone-alt text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="text-primary" style="color: #81c408;">Di động</h5>
                                <p class="mb-0">+012 345 67890</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width: 50px; height: 50px; background-color: #81c408;">
                                <i class="fa fa-envelope-open text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="text-primary" style="color: #81c408;">Email</h5>
                                <p class="mb-0">info@example.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mẫu liên hệ -->
                <div class="col-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" placeholder="Tên của bạn">
                                            <label for="name">Tên của bạn</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email"
                                                   placeholder="Email của bạn">
                                            <label for="email">Email của bạn</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject" placeholder="Chủ đề">
                                            <label for="subject">Chủ đề</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                    <textarea class="form-control" placeholder="Để lại tin nhắn ở đây" id="message"
                                              style="height: 100px"></textarea>
                                            <label for="message">Tin nhắn</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn w-100 py-3" style="background-color: #81c408; color: white;"
                                                type="submit">Gửi tin nhắn
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- Bản đồ -->
                <div class="col-lg-12" data-wow-delay="0.3s">
                    <iframe class="position-relative rounded w-100 h-100"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.836347331911!2d105.82503611440639!3d21.006382393857882!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9bd9861ca1%3A0xe7887f7b72ca17a9!2sHanoi!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
                            frameborder="0" style="min-height: 300px; border:0;" allowfullscreen="" aria-hidden="false"
                            tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection
