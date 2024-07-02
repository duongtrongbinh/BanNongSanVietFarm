@extends('admin.layout.master')
@section('title', 'Thêm mới sản phẩm')
@section('css')
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/index.min.css')}}">
@endsection
@section('content')
    <div class="pagetitle">
      <h1>Thêm mới sản phẩm</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
          <li class="breadcrumb-item"><a href="{{ route('products.create') }}" class="active">Thêm mới</a></li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <div class="card">
      <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST" data-toggle="validator" enctype="multipart/form-data">
          @csrf
          <div class="row form-group mt-2">
            <div class="col-3 mt-2">
              <label for="name">Tên sản phẩm</label>
              <input type="text" class="form-control mt-2" name="name" value="{{ old('name')}}">
              @error('name')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Thương hiệu</label>
              <select class="form-select mt-2" name="brand_id" aria-label="Default select example">
                <option value="" selected>Mở menu chọn này</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
              </select>
              @error('brand_id')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Danh mục</label>
              <select class="form-select mt-2" name="category_id" aria-label="Default select example">
                <option value="" selected>Mở menu chọn này</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              @error('category_id')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Số lượng</label>
              <input type="text" class="form-control mt-2" name="quantity" value="{{ old('quantity', 0)}}">
              @error('quantity')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-6 mt-2">
              <label for="name">Ảnh</label>
              <div class="input-group">
                <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white mt-2">
                    <i class="fa fa-picture-o"></i> Chọn
                  </a>
                </span>
                <input id="thumbnail" class="form-control mt-2" type="text" name="image[]" value="{{ old('image[]')}}">
              </div>
              @error('image')
                <div style="color: red">{{ $message }}</div>
              @enderror
              <div id="holder" style="margin-top:15px;"></div>
            </div>
            <div class="col-6 mt-2">
              <label for="name" class="mb-2">Nhãn</label>
              <select class="select2-multiple form-control" name="tags[]" multiple="multiple" id="select2Multiple">
                @foreach ($tags as $tag)
                  <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach         
              </select>
              @error('tags')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-4 mt-2">
              <label for="name">Giá gốc (VNĐ)</label>
              <input type="text" class="form-control mt-2" name="price_regular" value="{{ old('price_regular', 0)}}">
              @error('price_regular')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-4 mt-2">
              <label for="name">Giá giảm (VNĐ)</label>
              <input type="text" class="form-control mt-2" name="price_sale" value="{{ old('price_sale', 0)}}">
              @error('price_sale')
                <div style="color: red">{{ $message }}</div>
              @enderror
              @error('price_sale.lt')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-4 mt-2">
              <label for="name">Loại trừ</label>
              <input type="text" class="form-control mt-2" name="excerpt" value="{{ old('excerpt')}}">
              @error('except')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Chiều dài (Cm)</label>
              <input type="text" class="form-control mt-2" name="length" value="{{ old('length', 0)}}">
              @error('length')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Chiều rộng (Cm)</label>
              <input type="text" class="form-control mt-2" name="width" value="{{ old('width', 0)}}">
              @error('width')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Chiều cao (Cm)</label>
              <input type="text" class="form-control mt-2" name="height" value="{{ old('height', 0)}}">
              @error('height')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Trọng lượng (Gram)</label>
              <input type="text" class="form-control mt-2" name="weight" value="{{ old('weight', 0)}}">
              @error('weight')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-12 mt-2">
              <label for="name">Mô tả</label>
              <textarea class="form-control mt-2" name="description">{{ old('description')}}</textarea>
              @error('description')
                <div style="color: red">{{ $message }}</div>
              @enderror
            <div class="col-12 mt-2">
              <label for="name">Nội dung</label>
              <textarea class="form-control mt-2 my-editor-tinymce4" name="content">{{ old('content')}}</textarea>
              @error('content')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-2 mt-2">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" value="is_active" value="{{ old('is_active')}}" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">Active</label>
              </div>
            </div>
            <div class="col-2 mt-2">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" value="is_home" value="{{ old('is_home')}}" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">Home</label>
              </div>
            </div>
            <div class="text-center mt-5">
              <button type="submit" class="btn btn-primary">Thêm mới</button>
              <button type="reset" class="btn btn-secondary">Hoàn tác</button>
            </div>
          </div>
        </form>
      </div>
    </div>
@endsection
@section('js')
  <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script> 
  <script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script>
  <script src="path-to-your-tinymce/tinymce.min.js"></script>
  <script>
    $(document).ready(function() {
      // Select2 Multiple
      $('.select2-multiple').select2({
        them: 'bootstrap-5',
        placeholder: "Select",
        allowClear: true
      });

    });
  </script>
@endsection