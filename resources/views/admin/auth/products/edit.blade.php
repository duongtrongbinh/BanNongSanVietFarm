@extends('admin.layout.master')
@section('title', 'Product Update')
@section('css')
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/index.min.css')}}">
@endsection
@section('content')
    <div class="pagetitle">
      <h1>Product Update</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Product</li>
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
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" value="{{ $product->name}}">
              @error('name')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-3 mt-2">
              <label for="name">Brand</label>
              <select class="form-select" name="brand_id" aria-label="Default select example">
                <option value="" selected>Open this select menu</option>
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
              <label for="name">Category</label>
              <select class="form-select" name="category_id" aria-label="Default select example">
                <option value="" selected>Open this select menu</option>
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
              <label for="name">Quantity</label>
              <input type="text" class="form-control" name="quantity" value="{{ $product->quantity}}">
              @error('quantity')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-6 mt-2">
              <label for="name">Product Image</label>
              <div class="input-group">
                <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                    <i class="fa fa-picture-o"></i> Choose
                  </a>
                </span>
                <input id="thumbnail" class="form-control" type="text" name="image[]" value="{{ $product->image }},  
                  @foreach ($product->product_images as $product_image) 
                    {{ $product_image->image }}
                  @endforeach
                ">
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
              <label for="name">Tag</label>
              <select class="select2-multiple form-control" name="tag[]" multiple="multiple" id="select2Multiple">
                @foreach ($tags as $tag)
                  @foreach ($product->tags as $product_tag)
                      @if ($product_tag->id == $tag->id)
                        <option selected value="{{ $product_tag->id }}">{{ $product_tag->name }}</option>
                      @endif
                  @endforeach
                  <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach         
              </select>
              @error('tag')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-4 mt-2">
              <label for="name">Price Regular</label>
              <input type="text" class="form-control" name="price_regular" value="{{ $product->price_regular }}">
              @error('price_regular')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-4 mt-2">
              <label for="name">Price Regular</label>
              <input type="text" class="form-control" name="price_sale" value="{{ $product->price_sale }}">
              @error('price_sale')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-4 mt-2">
              <label for="name">Excerpt</label>
              <input type="text" class="form-control" name="excerpt" value="{{ $product->excerpt }}">
              @error('except')
                <div style="color: red">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-12 mt-2">
              <label for="name">Description</label>
              <textarea class="form-control" name="description">{{ $product->description }}</textarea>
              @error('description')
                <div style="color: red">{{ $message }}</div>
              @enderror
            <div class="col-12 mt-2">
              <label for="name">Content</label>
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
              <button type="submit" class="btn btn-primary">Update</button>
              <button type="reset" class="btn btn-secondary">Reset</button>
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