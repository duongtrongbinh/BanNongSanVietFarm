@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Voucher</h5>
            <div class="d-flex justify-content-end mt-2 mb-2">
            </div>
            @error('success')
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
            @enderror
            <form action="{{ route('vouchers.update', $voucher->id) }}" method="post" id="form">
                <input type="hidden" name="id" value="{{ $voucher->id}}">
                @csrf
                @method('PUT')
                <div class="row mt-5">
                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" aria-describedby="title" value="{{ $voucher->title }}">
                            @error('title')
                            <small id="title" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" aria-describedby="quantity" value="{{ $voucher->quantity }}">
                            @error('quantity')
                            <small id="quantity" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" aria-describedby="amount"  value="{{ rtrim(rtrim($voucher->amount,'0'),'.') }}">
                            @error('amount')
                            <small id="amount" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="start_date">Start date</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" aria-describedby="start_date" value="{{ $voucher->start_date }}">
                            @error('start_date')
                            <small id="start_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="end_date">End date</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" aria-describedby="end_date"  value="{{ $voucher->end_date }}">
                            @error('end_date')
                            <small id="end_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div  class="row mt-5">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $voucher->description }}</textarea>
                        @error('description')
                        <small id="description" class="form-text  text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <!-- End Table with stripped rows -->

                <div class="row mt-4">
                    <div class="col-xl-4">
                        <label for="description" class="mb-2"></label>
                        <div class="form-check form-switch">
                            @if($voucher->is_active == 1)
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" name="is_active" checked>
                            @else
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" name="is_active">
                            @endif

                            <label class="form-check-label" for="flexSwitchCheckDefault">is active</label>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <label for="description" class="mb-2">Select value type vouchers ?</label>
                        <div class="col-sm-10 d-flex" style="gap: 10px">
                            @if($voucher->type_unit == 1)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type_unit" id="type_unit" value="0">
                                    <label class="form-check-label" for="gridRadios1">
                                        Total Bill
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type_unit" id="type_unit" value="1" checked>
                                    <label class="form-check-label" for="gridRadios2">
                                        Percent
                                    </label>
                                </div>
                            @else
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type_unit" id="type_unit" value="0" checked>
                                    <label class="form-check-label" for="gridRadios1">
                                        Total Bill
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type_unit" id="type_unit" value="1">
                                    <label class="form-check-label" for="gridRadios2">
                                        Percent
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <label for="description" class="mb-2">Infinite time ?</label>
                        <div class="form-check">
                            @if($voucher->end_date == null)
                                <input class="form-check-input" type="checkbox" id="date" name="infinite" value="1" checked>
                            @else
                                <input class="form-check-input" type="checkbox" id="date" name="infinite" value="1">
                            @endif
                            <label class="form-check-label" for="gridCheck1">
                                yes
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <div class="form-check">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('vouchers.index') }}"><button type="button" class="btn btn-warning">Back</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
