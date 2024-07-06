@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatable/index.min.css') }}" />
@endsection
@section('content')
<div class="pagetitle">
    <div class="d-flex" style="justify-content: space-between">
      <h1>Dashboard</h1>
    </div>

    <nav >
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
        <li class="breadcrumb-item">Purchase Receipt</li>
        <li class="breadcrumb-item active">List Purchase Receipt</li>
      </ol>
    </nav>
  </div>

<div class="card" style="height: 100vh">
                  <div class="card-header border-0 d-flex" >
                    <div class="me-3">
                        <a class="btn btn-outline-success pr-3" href="{{ route('purchase_receipt.create') }}">Add</a>  
                    </div>
                  <div class="row align-items-center gy-3">
                      <div class="col-sm-auto">
                          <div class="d-flex gap-1 flex-wrap">
                              <!-- Basic Modal -->
                              <button type="submit" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#basicModal">
                                <i class="ri-file-download-line align-bottom me-1"></i> Nhập
                              </button>
                              <div class="modal fade" id="basicModal" tabindex="-1">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form action="{{ route('purchases.import') }}" method="post" enctype="multipart/form-data">
                                      @csrf
                                      <div class="modal-header">
                                        <h4>Nhập file nhập hàng</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <input type="file" name="purchase_file" >
                                      </div>
                                      <div class="modal-footer justify-content-center">
                                        <button type="submit" class="btn btn-primary">Nhập</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
    <div class="card-body mt-5">
      <table class="table table-striped datatableProduct" >
        <thead>
          <tr>
            <th>#</th>
            <th>Mã nhập hàng</th>
            <th>Nhà cung cấp</th>
            <th>Tổng sản phẩm</th>
            <th>Tổng tiền</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($purchaseReceipts as $key => $receipt)
                <tr >
                    <td>{{ $key + 1}}</td>
                    <td>{{ $receipt->reference_code }}</td>
                    <td>{{ $receipt->supplier->name }}</td>
                    <td>{{ $receipt->product_count }}</td>
                    <td>{{ number_format($receipt->total)}} VND</td>
                        <td>
                        <a href='#' class='btn btn-success btn-sm' style='margin-right: 5px'>Show</a>
                        </td>
                </tr>
            @endforeach
        </tbody>
        <tbody>
        </tbody>
      </table>
      <!-- End Table with stripped rows -->
      {{ $purchaseReceipts->links()}}
    </div>
  </div>
@endsection
@section('js')
<script src="{{ asset('admin/assets/vendor/datatable/index.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>
@endsection
