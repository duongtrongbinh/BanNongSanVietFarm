
@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/index.min.css')}}">
@endsection
@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
        <li class="breadcrumb-item active">Add Blog</li>
      </ol>
    </nav>
  </div>
<div class="container-fuild">
  <div class="row">
          <div class="form-group col mt-2">
            <label for="" class="form-lable mb-2">Content</label>
            <textarea class="form-control my-editor-tinymce4" name="content" placeholder="Nhập content ..."></textarea>
          </div>
        <div class="form-group mb-3">
              <label for="select2Multiple">Multiple Tags</label>
            <select class="select2-multiple form-control" name="tags[]" multiple="multiple"
                id="select2Multiple">
                <option value="tag1">tag1</option>
                <option value="tag2">tag2</option>
                <option value="tag3">tag3</option>               
            </select>
        </div>
  </div>
</div>
@section('js')
<script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script> 
<script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script>
<script src="/path-to-your-tinymce/tinymce.min.js"></script>
 <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

        });

    </script>
@endsection
@endsection



