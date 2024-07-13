@extends('admin.layout.master')
@section('title', 'Chỉnh sửa danh mục')
@php
  $updated = session('updated');
@endphp
@section('content')
    <div class="pagetitle">
      <h1>Chỉnh sửa danh mục</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Danh mục</a></li>
          <li class="breadcrumb-item"><a href="{{ route('categories.edit', $category->id) }}" class="active">Chỉnh sửa</a></li>
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
                <form action="{{ route('categories.update', $category) }}" method="post" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3 mt-4">
                        <label for="name" class="col-sm-2 col-form-label">Tên danh mục</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
                        </div>
                    </div>
                    @error('name')
                        <div style="color: red">{{ $message }}</div>
                    @enderror
                    <div class="row mb-3">
                      <label for="name" class="col-sm-2 col-form-label">Ghi chú</label>
                      <div class="col-sm-10">
                        <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $category->description }}</textarea>
                      </div>
                  </div>
                    @error('description')
                        <div style="color: red">{{ $message }}</div>
                    @enderror
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
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
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!--ShowMessage js-->
  <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>

  <script>
    $(document).ready(function() {
      let status = @json($updated);
      let title = 'Cập nhật';
      let message = status;
      let icon = 'success';

      if (status) {
        showMessage(title, message, icon);
      }
    });
  </script>
@endsection