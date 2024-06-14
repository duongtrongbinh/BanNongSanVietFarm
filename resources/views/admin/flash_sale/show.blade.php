
@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/index.min.css')}}">

@endsection
@section('content')
    <form action="" method="post" id="form">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detail Flash Sale</h5>
                <div class="d-flex justify-content-end mt-2 mb-2">
                </div>
                <div class="row mt-5">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="start_date">Start date</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" aria-describedby="start_date" value="{{$flash_sale->start_date}}" disabled>
                            @error('start_date')
                            <small id="start_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="end_date">End date</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" aria-describedby="end_date" value="{{ $flash_sale->end_date }}" disabled>
                            @error('end_date')
                            <small id="end_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="start_date">Updated</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" aria-describedby="start_date" value="{{$flash_sale->updated_at}}" disabled>
                            @error('start_date')
                            <small id="start_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="end_date">Created</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" aria-describedby="end_date" value="{{ $flash_sale->created_at }}" disabled>
                            @error('end_date')
                            <small id="end_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- End Table with stripped rows -->
                <div class="row mt-4">
                    <div class="col-xl-4">
                        <label for="description" class="mb-2"></label>
                        <div class="form-check form-switch">
                            @if($flash_sale->status == 0)
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" name="is_active" disabled>
                            @else
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" name="is_active" checked disabled>
                            @endif
                            <label class="form-check-label" for="flexSwitchCheckDefault"> is active</label>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="card">
            <div class="card-body" id="card-2">
                @foreach($product_sale as $items)
                    <div class="row mt-5" id="row-{{ $items->product_id}}">
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label for="start_date">Name products</label>
                                <input type="text" class="form-control" value="{{ $items->product->name}}/{{ $items->product->price_regular}}" disabled>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label for="end_date">Discount</label>
                                <input type="number" class="form-control" id="discount-{{$items->product_id}}" name="product[{{ $items->product_id}}][discount]" value="{{ $items->discount}}" required min="100" disabled>
                                <small id="discount-${id}" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label for="end_date">Quantity</label>
                                <input type="number" class="form-control" id="quantity-{{$items->product_id}}" name="product[{{ $items->product_id}}][quantity]" value="{{ $items->quantity}}" required min="1" disabled>
                                <small id="quantity-${id}" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-xl-1 mt-3">
                            <div class=" form-check form-switch  mt-3">
                                @if($items->is_active == 0)
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" name="product[{{ $items->product_id}}][is_active]" disabled>
                                @else
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" name="product[{{ $items->product_id}}][is_active]" checked disabled>
                                @endif

                            </div>
                        </div>
{{--                        <div class="col-xl-2 mt-3">--}}
{{--                            <button type="button" class="rollback_product mt-2 btn btn-outline-danger" data-id="{{ $items->product_id}}" data-name="{{ $items->product->name}}/{{ $items->product->price_regular}}">--}}
{{--                                <i class="ri-sort-asc" style="font-size: 16px"></i>--}}
{{--                            </button>--}}
{{--                        </div>--}}
                    </div>
                @endforeach
            </div>
            <div class="form-group mb-3">
                <div class="form-check">
                    <a href="/flash-sales"><button type="button" class="btn btn-warning">Back</button></a>
                </div>
            </div>
        </div>
    </form>
@endsection
