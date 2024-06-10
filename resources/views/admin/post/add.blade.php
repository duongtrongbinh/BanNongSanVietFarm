@extends('admin.layout.master')
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>
@endsection
@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
        <li class="breadcrumb-item active">Slide</li>
      </ol>
    </nav>
</div>


<div class="card">
    <div class="card-body">
      <h5 class="card-title">List slide</h5>
      <div class="d-flex justify-content-end mt-2 mb-2">
        </div>
      <!-- Table with stripped rows -->
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody> 

        <tr>
            <td>
                <a data-url="{{ route('post.destroy') }}"  class="btn btn-warning deleteSlide">Delete</a>
                {{-- data-id="{{ $id }}" --}}
            </td>
        </tr>
        </tbody>
      </table>
      <!-- End Table with stripped rows -->
    </div>
</div>
@endsection
