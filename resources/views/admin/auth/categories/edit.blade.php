@extends('admin.layout.master')
@section('title', 'Category Edit')
@section('content')
    <div class="pagetitle">
      <h1>Category Update</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Category</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Category Update</h5>
                <!-- Form -->
                <form action="{{ route('categories.update', $category) }}" method="post" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
                        </div>
                    </div>
                    @error('name')
                        <div style="color: red">{{ $message }}</div>
                    @enderror
                    <div class="row mb-3">
                      <label for="name" class="col-sm-2 col-form-label">Description</label>
                      <div class="col-sm-10">
                        <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $category->description }}</textarea>
                      </div>
                  </div>
                    @error('description')
                        <div style="color: red">{{ $message }}</div>
                    @enderror
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
