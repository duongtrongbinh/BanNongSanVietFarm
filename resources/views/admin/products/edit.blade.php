@extends('admin.layout.master')
@section('title', 'Chỉnh sửa sản phẩm')
@section('css')
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/index.min.css')}}">
@endsection
@php
  $updated = session('updated');
@endphp
@section('content')
    <div class="pagetitle">
      <h1>Chỉnh sửa sản phẩm</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
          <li class="breadcrumb-item"><a href="{{ route('products.edit', $product->id) }}" class="active">Chỉnh sửa</a></li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <div class="card">
      <div class="card-body">
        <form action="{{ route('products.update', $product) }}" method="POST" data-toggle="validator" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row form-group">
            <div class="col-3 mt-2">
              <label for="name">Tên sản phẩm</label>
              <input type="text" class="form-control" name="name" value="{{ $product->name}}">
              @error('name')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Thương hiệu</label>
              <select class="form-select" name="brand_id" aria-label="Default select example">
                <option value="" selected>Mở menu chọn này</option>
                @foreach ($brands as $brand)
                  @if ($product->brand_id == $brand->id)
                    <option selected value="{{ $product->brand_id }}">{{ $product->brand->name }}</option>
                  @endif
                  <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
              </select>
              @error('brand_id')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Danh mục</label>
              <select class="form-select" name="category_id" aria-label="Default select example">
                <option value="" selected>Mở menu chọn này</option>
                @foreach ($categories as $category)
                  @if ($product->category_id == $category->id)
                    <option selected value="{{ $product->category_id }}">{{ $product->category->name }}</option>
                  @endif
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              @error('category_id')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Số lượng</label>
              <input type="text" class="form-control" name="quantity" value="{{ $product->quantity}}">
              @error('quantity')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-6 mt-2">
              <label for="name">Ảnh</label>
              <div class="input-group">
                <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                    <i class="fa fa-picture-o"></i> Chọn
                  </a>
                </span>
                <input id="thumbnail" class="form-control" type="text" name="image[]" 
                      value="{{$product->image}}{{$product->product_images->isNotEmpty() ? ', ' . $product->product_images->pluck('image')->implode(', ') : ''}}">
              </div>
              @error('image')
                <div style="color: red">{{ $message }}</div>
              @enderror
              <div>
               <img src="{{ $product->image}}" class="mt-2" width="200px">
               @foreach ($product->product_images as $product_image)
                <img src="{{ $product_image->image }}" class="mt-2" width="100px">  
               @endforeach
              </div>
              <div id="holder" style="margin-top:15px;"></div>
            </div>
            <div class="col-6 mt-2">
              <label for="name">Nhãn</label>
              <select class="select2-multiple form-control" name="tags[]" multiple="multiple" id="select2Multiple">
                @foreach ($tags as $tag)
                  @php
                      $isSelected = false;
                  @endphp
                  @foreach ($product->tags as $product_tag)
                      @if ($product_tag->id == $tag->id)
                          <option selected value="{{ $product_tag->id }}">{{ $tag->name }}</option>
                          @php
                              $isSelected = true;
                          @endphp
                      @endif
                  @endforeach
                  @if (!$isSelected)
                      <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                  @endif
                @endforeach 
              </select>
              @error('tags')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-4 mt-2">
              <label for="name">Giá gốc</label>
              <input type="number" class="form-control" name="price_regular" value="{{ intval($product->price_regular) }}">
              @error('price_regular')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-4 mt-2">
              <label for="name">Giá giảm</label>
              <input type="number" class="form-control" name="price_sale" value="{{ intval($product->price_sale) }}">
              @error('price_sale')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-4 mt-2">
              <label for="name">Loại trừ</label>
              <input type="text" class="form-control" name="excerpt" value="{{ $product->excerpt }}">
              @error('except')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Chiều dài (Cm)</label>
              <input type="text" class="form-control" name="length" value="{{ $product->length }}">
              @error('length')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Chiều rộng (Cm)</label>
              <input type="text" class="form-control" name="width" value="{{ $product->width }}">
              @error('width')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Chiều cao (Cm)</label>
              <input type="text" class="form-control" name="height" value="{{ $product->height }}">
              @error('height')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Trọng lượng (Gram)</label>
              <input type="text" class="form-control" name="weight" value="{{ $product->weight }}">
              @error('weight')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-12 mt-2">
              <label for="name">Mô tả</label>
              <textarea class="form-control" name="description">{{ $product->description }}</textarea>
              @error('description')
                <div style="color: red">{{ $message }}</div>
              @enderror
            <div class="col-12 mt-2">
              <label for="name">Nội dung</label>
              <textarea class="form-control my-editor-tinymce4" name="content">{{ $product->content }}</textarea>
              @error('content')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-4 mt-2">
              <div class="form-check form-switch">
                @if ($product->is_active == true) 
                  <input class="form-check-input" type="checkbox" name="is_active" id="flexSwitchCheckChecked" checked>
                @else
                  <input class="form-check-input" type="checkbox" name="is_active" id="flexSwitchCheckChecked">
                @endif
                <label class="form-check-label" for="flexSwitchCheckChecked">Active</label>
              </div>
            </div>
            <div class="col-4 mt-2">
              <div class="form-check form-switch">
                @if ($product->is_active == true) 
                  <input class="form-check-input" type="checkbox" name="is_home" id="flexSwitchCheckChecked" checked>
                @else
                  <input class="form-check-input" type="checkbox" name="is_home" id="flexSwitchCheckChecked">
                @endif
                <label class="form-check-label" for="flexSwitchCheckChecked">Home</label>
              </div>
            </div>
            <div class="text-center mt-5">
              <button type="submit" class="btn btn-primary">Cập nhật</button>
              <button type="reset" class="btn btn-secondary">Hoàn tác</button>
              <a href="{{ route('related.index', $product->id) }}" class="btn btn-success">Thêm sản phẩm liên quan</a>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!--ShowMessage js-->
  <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>

  <script>
    $(document).ready(function() {
      // Select2 Multiple
      $('.select2-multiple').select2({
        them: 'bootstrap-5',
        placeholder: "Select",
        allowClear: true
      });

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