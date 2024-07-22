@extends('admin.layout.master')
@section('title', 'List User')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('content')
    @php
        $created = session('created');
        $update = session('update');
    @endphp
    <div class="pagetitle">
        <h1>Danh sách khách hàng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">Khách hàng</a></li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-items-center gy-3">
                        </div>
                    </div>
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
                                        <th>Tên khách hàng</th>
                                        <th>Hình ảnh</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
                                        <th>Trạng thái</th>
                                        <th>Active</th>
                                        <th>Chỉnh sửa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user as $row)
                                        <tr>
                                            <th scope="row">{{ $row->id }}</th>
                                            <td scope="row">{{ $row->name }}</td>
                                            <td>
                                                @if ($row->avatar)
                                                    <img src="{{ asset($row->avatar) }}" width="60px">
                                                @else
                                                    <span class="text-muted">Không có ảnh</span>
                                                @endif
                                            </td>
                                            <td scope="row">{{ $row->email }}</td>
                                            <td scope="row">{{ $row->phone }}</td>
                                            <td scope="row">{{ $row->address }}</td>
                                            <td>
                                                @if ($row->status == true)
                                                    <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-danger">Ngừng hoạt động</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->active == true)
                                                    <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-danger">Ngừng hoạt động</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Sửa">
                                                        <a href="{{ route('user.edit', $row->id) }}">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a data-url="{{ route('user.destroy', $row->id) }}"
                                                           class="btn btn-danger btn-sm deletepost">
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
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table1').DataTable();
            $('#table2').DataTable();
            $('#table3').DataTable();
            $('#table4').DataTable();
        });
        new DataTable("#example");
    </script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
            let createdStatus = @json($created);
            let updatedStatus = @json($update);
            let status = createdStatus || updatedStatus;
            let title = createdStatus ? 'Thêm mới' : 'Cập nhật';
            let message = status;
            let icon = 'success';

            if (status) {
                showMessage(title, message, icon);
            }
        });
    </script>
@endsection
