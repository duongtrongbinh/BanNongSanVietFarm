@extends('client.layouts.master')
@section('title', 'Bài viết')
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Bài viết</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Bài Viết</li>
        </ol>
    </div>
    <main id="main">
        <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-8 entries">
                        @foreach ($post as $row)
                            <article class="entry">
                                <div class="entry-img">
                                    <img src="{{ $row->image ? asset($row->image) : asset('client/assets/img/NoBanner.png') }}" alt="" class="img-fluid" style="max-height: 440px; width: 100%;">
                                </div>
                                <h2 class="entry-title">
                                    <a href="{{route('postclient.show',$row)}}">{{$row->title}}</a>
                                </h2>
                                <div class="entry-meta">
                                    <ul>
                                        <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="blog-single.html">{{$row->comment_count}} Đánh giá</a></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <div class="read-more">
                                        <a href="{{route('postclient.show',$row)}}">Chi tiết</a>
                                    </div>
                                </div>
                            </article><!-- End blog entry -->
                        @endforeach
                        <div class="blog-pagination">
                            {{$post->links()}}
                        </div>
                    </div><!-- End blog entries list -->
                    <div class="col-lg-4">
                        <div class="sidebar">
                            <h3 class="sidebar-title">Bài viết liên quan</h3>
                            <div class="sidebar-item recent-posts">
                                @foreach($post as $row)
                                    <div class="post-item clearfix">
                                        <img src="{{ $row->image ? asset($row->image) : asset('client/assets/img/NoBanner.png') }}">
                                        <h4><a href="{{route('postclient.show', $row)}}">{{$row->title}}</a></h4>
                                        <time datetime="{{$row->created_at}}">{{$row->created_at}}</time>
                                    </div>
                                @endforeach
                            </div>
                        </div><!-- End sidebar -->
                    </div><!-- End blog sidebar -->
                </div>
            </div>
        </section><!-- End Blog Section -->
    </main>
    <link href="{{ asset('client/assets/css/post.css') }}" rel="stylesheet">
@endsection
