@extends('admin.layout.master')
@section('title', 'Thêm mới danh mục')
@section('content')
    <div class="pagetitle">
      <h1>Thêm mới danh mục</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Danh mục</a></li>
          <li class="breadcrumb-item"><a href="{{ route('categories.create') }}" class="active">Thêm mới</a></li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <!-- Form -->
                <form action="{{ route('categories.store') }}" method="POST" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3 mt-4">
                        <label for="name" class="col-sm-2 col-form-label">Tên danh mục</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                          @error('name')
                            <div style="color: red">{{ $message }}</div>
                          @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                      <label for="name" class="col-sm-2 col-form-label">Ghi chú</label>
                      <div class="col-sm-10">
                        <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ old('description') }}</textarea>
                        @error('description')
                          <div style="color: red">{{ $message }}</div>
                        @enderror
                      </div>
                  </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                        <button type="reset" class="btn btn-secondary">Hoàn tác</button>
                    </div>
                </form>
                <!-- End Horizontal Form -->
              </div>
            </div>
          </div>
        </div>
      </section>
@endsection