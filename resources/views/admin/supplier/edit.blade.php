
@extends('admin.layout.master')
@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('supplier.index')}}">List Supplier</a></li>
        <li class="breadcrumb-item active">Update supplier</li>
      </ol>
    </nav>
  </div>
<div class="container-fuild" style="height: 100vh; padding: 15px 20px; background: #fff;border: none;border-radius: 10px">
  <div class="row mb-5">
    <form method="POST" action="{{ route('supplier.update', $supplier->id)}}">  
      @csrf
      @method("PUT")
        <div class="modal-body">
            <div class="row">     
                <div class="form-group col-4">
                    <label class="form-lable mb-2">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Nhập name ..." value="{{ $supplier->name }}">
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group col-4">
                    <label class="form-lable mb-2">Company</label>
                    <input type="text" name="company" class="form-control" placeholder="Nhập company ..." value="{{ $supplier->company }}">
                    @if($errors->has('company'))
                        <span class="text-danger">{{ $errors->first('company') }}</span>
                    @endif
                </div>
                <div class="form-group col-4">
                    <label class="form-lable mb-2">Tax Code</label>
                    <input type="text" name="tax_code" class="form-control" placeholder="Nhập mã thuế công ty ..." value="{{ $supplier->tax_code }}">
                    @if($errors->has('tax_code'))
                        <span class="text-danger">{{ $errors->first('tax_code') }}</span>
                    @endif
                </div>
            </div>
            <div class="row mt-3">     
                <div class="form-group col-4">
                    <label class="form-lable mb-2">Tên người phụ trách</label>
                    <input type="text" name="contact_name" class="form-control" placeholder="Nhập tên người phụ trách ..." value="{{ $supplier->contact_name }}">
                    @if($errors->has('contact_name'))
                        <span class="text-danger">{{ $errors->first('contact_name') }}</span>
                    @endif
                </div>
                <div class="form-group col-4">
                    <label class="form-lable mb-2">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Nhập email ..." value="{{ $supplier->email }}">
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group col-4">
                    <label class="form-lable mb-2">Phone</label>
                    <input type="text" name="phone_number" class="form-control" placeholder="Nhập số điện thoại người liên hệ ..." value="{{ $supplier->phone_number }}">
                    @if($errors->has('phone_number'))
                        <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                    @endif
                </div>
            </div>
            <div class="row mt-3">
                <div class="form-group col-6">
                    <label class="form-lable mb-2">Địa chỉ</label>
                    <input type="text" name="address" class="form-control" placeholder="Nhập address ..." value="{{ $supplier->address }}">
                    @if($errors->has('address'))
                        <span class="text-danger">{{ $errors->first('address') }}</span>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label class="form-lable mb-2">Note</label>
                    <input type="text" name="note" class="form-control" placeholder="Nhập note ..." value="{{ $supplier->note }}">
                    @if($errors->has('note'))
                        <span class="text-danger">{{ $errors->first('note') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-5 text-center">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="reset" class="btn btn-outline-warning">Reset</button>
        </div>
  </form>
  </div>
</div>
@endsection



