@extends('admin.layout.master')
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/assets/js/deleteAll/deleteSoft.js') }}"></script>
@endsection
@section('content')
    @php
        $created = session('created');
        $update = session('updated');
    @endphp:;:;;;;;;;;;;www
    <div class="pagetitle">
        <h1>Trang chủ </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Mã giảm giá</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('vouchers.create') }}">
                                <i class="bi bi-plus-circle"></i>
                                 Tạo mã giảm giá
                            </a>
                        </h5>
                        <div class="d-flex justify-content-between">
                            <p></p>
                            <div>
                                <a href="{{ route('vouchers.deleted') }}">
                                    <button type="button" class="btn btn-outline-danger"><i class="ri-delete-bin-2-line"></i>deleted</button>
                                </a>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Số lượng </th>
                                <th scope="col">Giá trị</th>
                                <th scope="col">Hạn mức áp dụng </th>
                                <th scope="col">Ngày bắt đầu </th>
                                <th scope="col">Ngày kết thúc </th>
                                <th scope="col">Đang hoạt động</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($vouchers))
                                @foreach($vouchers as $items)
                                    <tr>
                                        <td><div class="text-truncate" style="max-width: 50vh;">{{ $items->title }}</div></td>
                                        <td>{{ $items->quantity }}</td>
                                        <td>@if($items->type_unit == 0)
                                             {{ number_format($items->amount, 0, ',', '.') }} đ
                                            @else
                                             {{ rtrim(rtrim($items->amount, '0'), '.') }} %
                                        @endif
                                        </td>
                                        <td> {{ number_format($items->applicable_limit, 0, ',', '.') }} đ</td>
                                        <th>{{ $items->start_date }}</th>
                                        <td>{{ $items->end_date }}</td>
                                        <td>@if($items->is_active == 1)
                                                <span class="badge bg-success">true</span>
                                            @else
                                                <span class="badge bg-danger">false</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex" style="gap: 10px">
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Sửa">
                                                        <a href="{{ route('vouchers.edit',$items->id) }}">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Xóa">
                                                        <form action="{{ route('vouchers.destroy', $items->id) }}" method="post" class="deleteVouchers" data-url="{{ route('vouchers.destroy', $items->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </button>
                                                        </form>
                                                    </li>

                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        <div class="pagination justify-content-center">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('js')
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
