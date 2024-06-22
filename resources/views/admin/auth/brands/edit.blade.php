@extends('admin.layout.master')
@section('title', 'Edit Brand')
@section('content')
    <div class="pagetitle">
      <h1>Edit Brand</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active"><a href="{{ route('brands.index') }}">Brand</a></li>
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
                <form action="{{ route('brands.update', $brand) }}" method="post" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3 mt-4">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $brand->name }}">
                            @error('name')
                              <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                      <label for="name" class="col-sm-2 col-form-label">Image</label>
                      <div class="col-sm-10">
                        <div class="input-group">
                          <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                              <i class="fa fa-picture-o"></i> Choose
                            </a>
                          </span>
                          <input id="thumbnail" class="form-control" type="text" name="image" value="{{ $brand->image }}">
                        </div>
                        @error('image')
                          <div style="color: red">{{ $message }}</div>
                        @enderror
                        <div class="col-md-3 mt-3">
                          <img src="{{ $brand->image }}" class="img-fluid">
                        </div>
                      </div>
                      <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
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
  <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script> 
  <script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script>
  <script src="/path-to-your-tinymce/tinymce.min.js"></script>
@endsection
