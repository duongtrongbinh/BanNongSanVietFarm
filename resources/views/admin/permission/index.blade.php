@extends('admin.layout.master')
@section('title', 'Permission')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@php
    $created = session('created');
@endphp
@section('content')
    <div class="pagetitle">
        <h1>Phân Quyền</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('post.index') }}"> Phân Quyền </a></li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="tab-content pt-2">
                            <!-- All Orders -->
                            <div class="tab-pane fade show active all-orders" id="all-orders">
                                <table id="example"
                                       class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th data-ordering="false">ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Tên bảo mật</th>
                                        <th>Chỉnh Sửa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($roles as $row)
                                        <tr>
                                            <th scope="row">{{ $row->id }}</th>
                                            <td scope="row">{{ \App\Enums\Roles::from($row->id)->label() }}</td>
                                            <td scope="row" class="w-50">{{ $row->guard_name }}</td>
                                            <td scope="row">
                                               <div class="text-center">
                                                   <a href=" {{ route('permission.create',$row->id) }}"
                                                      class="btn btn-success btn-sm text-center" title="Phân quyền">
                                                       <i class="bi bi-person fs-16"></i>
                                                   </a>
                                               </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
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
    <!--Delete js-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('admin/assets/js/deleteAll/delete.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>
    <script>
        $(document).ready(function(){
            let status = @json($created);
            let title = 'Thêm mới';
            let message = status;
            let icon = 'success';
            if (status) {
                showMessage(title, message, icon);
            }
        });
        $(document).ready(function () {
            $('#table1').DataTable();
            $('#table2').DataTable();
            $('#table3').DataTable();
            $('#table4').DataTable();
        });
        new DataTable("#example");
    </script>
@endsection
