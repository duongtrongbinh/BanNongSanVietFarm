@extends('admin.layout.master')
@section('title', 'Edit Tag')
@section('content')
    <div class="pagetitle">
      <h1>Edit Tag</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active"><a href="{{ route('tags.index') }}">Tag</a></li>
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
                <form action="{{ route('tags.update', $tag) }}" method="post" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3 mt-4">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $tag->name }}">
                        </div>
                    </div>
                    @error('name')
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