@extends('client.layouts.master')
@section('title', 'Bài viết')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Bài viết</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Bài viiết</li>
        </ol>
    </div>
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="tab-content">
                    <div id="tab-0" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @foreach ($post as $row)
                                        <div class="col-md-6 col-lg-4">
                                            <a href="{{route('postclient.show', $row)}}">
                                                <div class="rounded position-relative fruite-item border border-secondary">
                                                    <div class="fruite-img">
                                                        <img src="{{asset($row->image)}}" class="img-fluid w-100 rounded-top" alt="">
                                                    </div>
                                                    <div class="p-4 border-top-0 rounded-bottom">
                                                        <h4 class="text-truncate">{{ $row->title }}</h4>
                                                        <p class="text-truncate">{{ $row->description }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



