@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatable/index.min.css') }}" />
@endsection
@section('content')
<div class="pagetitle">
    <div class="d-flex" style="justify-content: space-between">
      <h1>Dashboard</h1>
        <div>
            <a class="btn btn-outline-success pr-3" href="{{ route('supplier.create') }}">Add</a>  
        </div>
    </div>

    <nav >
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
        <li class="breadcrumb-item active">List Supplier</li>
      </ol>
    </nav>
  </div>

<div class="card" style="height: 100vh">
    <div class="card-body mt-5">
      <table class="table table-striped datatableProduct" >
        <thead>
          <tr>
            <th scope="col">#</th>
            <th>Name</th>
            <th>Company</th>
            <th>Tax Code</th>
            <th>Contact_name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $key =>$value)
          <tr>
            <td>{{$key +1}}</td>
            <td>{{ $value->name}}</td>
            <td>{{ $value->company}}</td>
            <td>{{ $value->tax_code}}</td>
            <td>{{ $value->contact_name}}</td>
            <td>{{ $value->email}}</td>
            <td>{{ $value->phone_number}}</td>
            <td>
              <a href='{{ route("supplier.edit",$value->id)}}' class='btn btn-success btn-sm' style='margin-right: 5px'>Edit</a>
              <a data-url='{{ route("supplier.destroy",$value->id)}}' class='btn btn-danger btn-sm deleteSupplier'>Delete</a>
            </td>
          </tr>
          @endforeach
        </tbody>
        <tbody>
        </tbody>
      </table>
      <!-- End Table with stripped rows -->
      {{ $data->links()}}
    </div>
  </div>
@endsection
@section('js')
<script src="{{ asset('admin/assets/vendor/datatable/index.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>
@endsection
