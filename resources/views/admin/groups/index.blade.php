@extends('admin.layout.master')
@section('title', 'Nhóm sản phẩm')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@php
  $created = session('created');
@endphp
@section('content')
    <div class="pagetitle">
      <h1>Danh sách nhóm sản phẩm</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ route('groups.index') }}" class="active">Nhóm sản phẩm</a></li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header border-0">
              <div class="row align-items-center gy-3">
                  <div class="col-sm-auto">
                      <div class="d-flex gap-1 flex-wrap">
                          <a href="{{ route('groups.create') }}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i> Thêm mới</a>
                      </div>
                  </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Table with stripped rows -->
              <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Tên nhóm</th>
                    <th>Số lượng sản phẩm</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($groups as $key => $group)
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $group->name }}</td>
                      <td>{{ count($group->products) }}</td>
                      <td>
                        <ul class="list-inline hstack gap-2 mb-0">
                          <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Chỉnh sửa">
                              <a href="{{ route('groups.edit', $group) }}" class="text-primary d-inline-block">
                                <i class="ri-pencil-fill fs-16"></i>
                              </a>
                          </li>
                          <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Xóa">
                              <a data-url="{{ route('groups.delete', $group) }}" class="text-danger d-inline-block deleteGroup">
                                <i class="ri-delete-bin-5-fill fs-16"></i>
                              </a>
                          </li>
                        </ul>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div>
        </div>
      </div>
    </section>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!--Delete js-->
  <script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>

  <!--ShowMessage js-->
  <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>

  <script>
    $(document).ready(function() {
      $('#example').DataTable();

      let status = @json($created);
      let title = 'Thêm mới';
      let message = status;
      let icon = 'success';

      if (status) {
        showMessage(title, message, icon);
      }
    });
  </script>
@endsection