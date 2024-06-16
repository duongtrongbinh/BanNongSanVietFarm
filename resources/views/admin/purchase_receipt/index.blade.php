@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatable/index.min.css') }}" />
@endsection
@section('content')
<div class="pagetitle">
    <div class="d-flex" style="justify-content: space-between">
      <h1>Dashboard</h1>
        <div>
            <a class="btn btn-outline-success pr-3" href="{{ route('purchase_receipt.create') }}">Add</a>  
        </div>
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
