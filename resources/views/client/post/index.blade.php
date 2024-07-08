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
                                    <img src="{{asset($row->image)}}" alt="" class="img-fluid">
                                </div>
                                <h2 class="entry-title">
                                    <a href="{{route('postclient.show',$row)}}">{{$row->title}}</a>
                                </h2>
                                <div class="entry-meta">
                                    <ul>
                                        <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a
                                                href="blog-single.html">{{$row->comment_count}} Đánh giá</a></li>
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
                            <ul class="justify-content-center">
                                <li><a href="#">1</a></li>
                                <li class="active"><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                            </ul>
                        </div>
                    </div><!-- End blog entries list -->
                    <div class="col-lg-4">
                        <div class="sidebar">
                            <h3 class="sidebar-title">Recent Posts</h3>
                            <div class="sidebar-item recent-posts">
                                <div class="post-item clearfix">
                                    <img src="assets/img/blog/blog-recent-1.jpg" alt="">
                                    <h4><a href="blog-single.html">Nihil blanditiis at in nihil autem</a></h4>
                                    <time datetime="2020-01-01">Jan 1, 2020</time>
                                </div>
                                <div class="post-item clearfix">
                                    <img src="assets/img/blog/blog-recent-2.jpg" alt="">
                                    <h4><a href="blog-single.html">Quidem autem et impedit</a></h4>
                                    <time datetime="2020-01-01">Jan 1, 2020</time>
                                </div>

                                <div class="post-item clearfix">
                                    <img src="assets/img/blog/blog-recent-3.jpg" alt="">
                                    <h4><a href="blog-single.html">Id quia et et ut maxime similique occaecati ut</a>
                                    </h4>
                                    <time datetime="2020-01-01">Jan 1, 2020</time>
                                </div>
                                <div class="post-item clearfix">
                                    <img src="assets/img/blog/blog-recent-4.jpg" alt="">
                                    <h4><a href="blog-single.html">Laborum corporis quo dara net para</a></h4>
                                    <time datetime="2020-01-01">Jan 1, 2020</time>
                                </div>
                                <div class="post-item clearfix">
                                    <img src="assets/img/blog/blog-recent-5.jpg" alt="">
                                    <h4><a href="blog-single.html">Et dolores corrupti quae illo quod dolor</a></h4>
                                    <time datetime="2020-01-01">Jan 1, 2020</time>
                                </div>
                            </div><!-- End sidebar recent posts-->

                            <h3 class="sidebar-title">Tags</h3>
                            <div class="sidebar-item tags">
                                <ul>
                                    <li><a href="#">App</a></li>
                                    <li><a href="#">IT</a></li>
                                    <li><a href="#">Business</a></li>
                                    <li><a href="#">Mac</a></li>
                                    <li><a href="#">Design</a></li>
                                    <li><a href="#">Office</a></li>
                                    <li><a href="#">Creative</a></li>
                                    <li><a href="#">Studio</a></li>
                                    <li><a href="#">Smart</a></li>
                                    <li><a href="#">Tips</a></li>
                                    <li><a href="#">Marketing</a></li>
                                </ul>
                            </div><!-- End sidebar tags-->

                        </div><!-- End sidebar -->

                    </div><!-- End blog sidebar -->

                </div>

            </div>
        </section><!-- End Blog Section -->
    </main>
    <link href="{{ asset('client/assets/css/post.css') }}" rel="stylesheet">
@endsection



