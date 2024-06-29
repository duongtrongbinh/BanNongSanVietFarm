@extends('admin.layout.master')
@section('content')
    <script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Danh sách khách hàng</h5>
                        <a href="{{Route('user.create')}}">
                            <button type="submit" class="btn btn-sm btn-success float-right">
                                <i class="fas fa-trash"></i> Thêm Mới thành viên
                            </button>
                        </a>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Name</th>
                                <th scope="col">Avatar</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">status</th>
                                <th scope="col">Tháo tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user as $row)
                                <tr>
                                    <th scope="row">{{ $row->id }}</th>
                                    <td scope="row">{{ $row->name }}</td>
                                    <td>
                                        @if ($row->avatar)
                                            <img src="{{asset($row->avatar)}}" width="80px">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td scope="row">{{ $row->email }}</td>
                                    <td scope="row">{{ $row->phone }}</td>
                                    <td scope="row">{{ $row->address }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault-{{ $row->id }}" {{ $row->status == 1 ? 'checked' : '' }} onchange="toggleStatus({{ $row->id }}, this)">
                                            <label class="form-check-label" for="flexSwitchCheckDefault-{{ $row->id }}">
                                                {{ $row->status == 1 ? 'Bật' : 'Tắt' }}
                                            </label>
                                        </div>
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
                                                   class="btn btn-danger btn-sm deleteuser">
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
    </section>
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
        <script src="{{asset('admin/assets/js/deleteAll/delete.js')}}"></script>
        <!--Delete js-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @endsection
@endsection
