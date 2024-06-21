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
                                        <a href="{{ route('user.edit', $row) }}" class="btn btn-primary btn-sm mr-1">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('user.destroy', $row) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
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
@endsection


