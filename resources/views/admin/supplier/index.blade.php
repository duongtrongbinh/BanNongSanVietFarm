@extends('admin.layout.master')
@section('css')
{{-- <link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatable/index.min.css') }}" /> --}}
 <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
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
      <div class="row">
        <table id="supplier" class="table table-bordered dt-responsive nowrap table-striped align-middle w-100" >
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
                <ul class="list-inline hstack gap-2 mb-0">
                  <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Chỉnh sửa">
                      <a href="{{ route('supplier.edit', $value->id) }}" class="text-primary d-inline-block">
                        <i class="ri-pencil-fill fs-16"></i>
                      </a>
                  </li>
                  <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Xóa">
                      <a data-url="{{ route('supplier.destroy',$value->id) }}" class="text-danger d-inline-block deleteProduct">
                        <i class="ri-delete-bin-5-fill fs-16"></i>
                      </a>
                  </li>
                </ul>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- End Table with stripped rows -->
    </div>
  </div>
@endsection
@section('js')
  <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.misn.j"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
{{-- <script src="{{ asset('admin/assets/vendor/datatable/index.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>

      <script type="text/javascript">
      $(document).ready(function() {
        $('#supplier').DataTable({
          responsive: true,
          autoWidth: false,
        });
    </script> 
@endsection
