@extends('admin.layout.master')
@section('title', 'Phân quyền')
@section('content')
<div class="main-content">
    <form action="{{ route('permission.store',$role) }}" method="post">
        @csrf
        @method('POST');
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Phân quyền</h5>
                <div class="d-flex justify-content-end mt-2 mb-2">
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Vai trò: {{ \App\Enums\Roles::from($role->id)->label() }}</h4>
                                <div class="flex-shrink-0">
{{--                                    <div class="form-check">--}}
{{--                                        <label for="switches-color-showcode" class="form-label text-muted">Tất cả</label>--}}
{{--                                        <input class="form-check-input code-switcher" type="checkbox" id="checked-all">--}}
{{--                                    </div>--}}
                                </div>
                            </div><!-- end card header -->
                            <div class="card-body">
                                <p class="text-muted">Danh sách quyền:</p>
                               @error('permission')
                                    <div class="alert alert-danger" role="alert">
                                          {{ $message }}
                                    </div>
                                @enderror
                                <div class="live-preview">
                                    <div class="row">
                                        @foreach($permissions as $key => $item)
                                            <div class="col-md-4">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input permission-checkbox" type="checkbox" id="gridCheck2" name="permission[]" value="{{ $item->id }}" {{ $item->checked ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridCheck2">{{ \App\Enums\Permissions::from($item->id)->label() }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!--end row-->
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <div class="code-view mt-5">
                            <button type="submit" class="btn btn-success">Xác Nhận</button>
                            <a href="{{ route('permission.index') }}" class="ml-5"><button type="button" class="btn btn-primary">Quay lại</button></a>
                        </div>
                        <!--end card-->
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('js')
    <script>
        document.getElementById('checked-all').addEventListener('click', function() {
            const isChecked = this.checked;
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });
    </script>
@endsection
