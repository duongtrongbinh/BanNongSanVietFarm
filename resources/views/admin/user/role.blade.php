@extends('admin.layout.master')
@section('title', 'Phân quyền')
@section('content')
    <div class="main-content">
        <form action="{{ route('roles.store',$user) }}" method="post">
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
                                    <h4 class="card-title mb-0 flex-grow-1">Tài Khoản: {{ $user->email }}</h4>
                                    <div class="flex-shrink-0">
                                        @foreach($roles as $key => $item)
                                            @if($item->id == 1)
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input permission-checkbox" type="checkbox" id="gridCheck1" name="roles[]" value="{{ $item->id }}" {{ $item->checked ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gridCheck1">{{ \App\Enums\Roles::from($item->id)->label() }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <p class="text-muted">Danh vai trò:</p>
                                    @error('roles')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <div class="live-preview">
                                        <div class="row">
                                            @foreach($roles as $key => $item)
                                                @if($item->id != 1)
                                                <div class="col-md-4">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input permission-checkbox" type="checkbox" id="gridCheck1" name="roles[]" value="{{ $item->id }}" {{ $item->checked ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="gridCheck1">{{ \App\Enums\Roles::from($item->id)->label() }}</label>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <!--end row-->
                                    </div>

                                </div>
                                <!--end card-body-->
                            </div>
                            <div class="code-view mt-5">
                                <button type="submit" class="btn btn-success">Xác Nhận</button>
                                <a href="{{ route('user.index') }}"><button type="button" class="btn btn-primary">Quay lại</button></a>
                            </div>
                            <!--end card-->
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

