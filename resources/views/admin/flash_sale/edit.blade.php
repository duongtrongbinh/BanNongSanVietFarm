
@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/index.min.css')}}">
@endsection
@php
    $updated = session('updated');
@endphp
@section('content')
    <form action="{{ route('flash-sales.update', $flash_sale->id) }}" method="post" id="form">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create Flash Sale</h5>
                <div class="d-flex justify-content-end mt-2 mb-2">
                </div>
                @error('success')
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
                @enderror
                <div class="row mt-5">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="start_date">Start date</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" aria-describedby="start_date" placeholder="Enter start date voucher..." value="{{$flash_sale->start_date}}">
                            @error('start_date')
                            <small id="start_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="end_date">End date</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" aria-describedby="end_date" placeholder="Enter end date voucher..." value="{{ $flash_sale->end_date }}">
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
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" name="is_active">
                            @else
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" name="is_active" checked>
                            @endif

                            <label class="form-check-label" for="flexSwitchCheckDefault"> is active</label>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <label for="select2Multiple">Products</label>
                        <select class="select2-multiple form-control" id="products" multiple="multiple">
                            @foreach($products as $items)
                                <option class="op-{{ $items->id }}" value="{{ $items->id }} - {{$items->name}}/{{$items->price_regular}}.VNĐ">{{$items->name}}/{{$items->price_regular}}.VNĐ</option>
                            @endforeach
                        </select>
                        <button type="button" class="mt-2 btn btn-outline-success" id="create_products"><i class="ri-sort-desc" style="font-size: 22px"></i></button>
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
                            <input type="number" class="form-control" id="discount-{{$items->product_id}}" name="product[{{ $items->product_id}}][discount]" value="{{ $items->discount}}" required min="100">
                            <small id="discount-${id}" class="form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="end_date">Quantity</label>
                            <input type="number" class="form-control" id="quantity-{{$items->product_id}}" name="product[{{ $items->product_id}}][quantity]" value="{{ $items->quantity}}" required min="1">
                            <small id="quantity-${id}" class="form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-xl-1 mt-3">
                        <div class=" form-check form-switch  mt-3">
                            @if($items->is_active == 0)
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" name="product[{{ $items->product_id}}][is_active]">
                            @else
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" name="product[{{ $items->product_id}}][is_active]" checked>
                            @endif

                        </div>
                    </div>
                    <div class="col-xl-2 mt-3">
                        <button type="button" class="rollback_product mt-2 btn btn-outline-danger" data-id="{{ $items->product_id}}" data-name="{{ $items->product->name}}/{{ $items->product->price_regular}}">
                            <i class="ri-sort-asc" style="font-size: 16px"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="form-group mb-3">
                <div class="form-check">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('flash-sales.index') }}"><button type="button" class="btn btn-warning">Back</button></a>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

            let status = @json($updated);
            let title = 'Sửa';
            let message = status;
            let icon = 'success';
            if (status) {
                showMessage(title, message, icon);
            }

            var form =  $('#form');
            // Custom validator method to check if start_date is after or equal to the current date and time
            // Custom validator method to check if start_date is after or equal to the current date and time
            $.validator.addMethod("notPastDate", function(value, element) {
                var now = new Date();
                var inputDate = new Date(value);
                return inputDate >= now;
            }, 'Start date must be equal to or later than the current date and time.');

            // Custom validator method for comparing dates
            $.validator.addMethod("greaterThan", function(value, element, params) {
                if (!/Invalid|NaN/.test(new Date(value))) {
                    return new Date(value) > new Date($(params).val());
                }
                return isNaN(value) && isNaN($(params).val()) || (Number(value) > Number($(params).val()));
            }, 'End date must be after start date.');

            // Custom validator method for minimum discount
            $.validator.addMethod("minDiscount", function(value, element) {
                return parseInt(value) >= 100;
            }, 'Discount must be at least 100.');

            // Initialize form validation
            form.validate({
                rules: {
                    start_date: {
                        required: true,
                        date: true,
                        notPastDate: true
                    },
                    end_date: {
                        required: true,
                        date: true,
                        greaterThan: "#start_date" // Custom rule for date comparison
                    },
                    "product[]": {
                        required: true
                    }
                },
                messages: {
                    start_date: {
                        required: "Start date is required",
                        date: "Please enter a valid date",
                        notPastDate: "Start date must be equal to or later than the current date and time"
                    },
                    end_date: {
                        required: "End date is required",
                        date: "Please enter a valid date",
                        greaterThan: "End date must be after start date"
                    },
                    "product[]": {
                        required: "Please select at least one product"
                    }
                },
                errorElement: 'small',
                errorClass: 'form-text text-danger',
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "product[]") {
                        error.appendTo("#errorProducts");
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    if ($('#card-2').children().length === 0) {
                        alert('Please add at least one product.');
                        return false;
                    } else {
                        form.submit();
                    }
                }
            });

            // Handle create_products button click
            $('#create_products').on('click', function() {
                var selectedProducts = $('#products').val();
                if (selectedProducts && selectedProducts.length > 0) {
                    $.each(selectedProducts, function(index, value) {
                        var parts = value.split(' - ');
                        var id = parts[0];
                        var name = parts[1];
                        // Remove option from select
                        $(".op-"+id).remove();
                        // Create and append product UI
                        var ui = `
                        <div class="row mt-5" id="row-${id}">
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label for="start_date">Name products</label>
                                    <input type="text" class="form-control" value="${name}" id="name_product" disabled>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label for="end_date">Discount</label>
                                    <input type="number" class="form-control" id="discount-${id}" name="product[${id}][discount]" value="0" required min="100">
                                    <small id="discount-${id}" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label for="end_date">Quantity</label>
                                    <input type="number" class="form-control" id="quantity-${id}" name="product[${id}][quantity]" value="0" required min="1">
                                    <small id="quantity-${id}" class="form-text text-danger"></small>
                                </div>

                            </div>
                              <div class="col-xl-1 mt-3">
                                <div class=" form-check form-switch  mt-3">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="1" name="product[${id}][is_active]">
                                </div>
                               </div>
                            <div class="col-xl-2 mt-3">
                                <button type="button" class="rollback_product mt-2 btn btn-outline-danger" data-id="${id}" data-name="${name}">
                                    <i class="ri-sort-asc" style="font-size: 16px"></i>
                                </button>
                            </div>
                        </div>`;
                        $('#card-2').append(ui);
                        // Initialize validation for dynamically added fields
                        form.validate().element(`#discount-${id}`);
                        form.validate().element(`#quantity-${id}`);
                    });
                } else {
                    $('#errorProducts').text('Please select at least one product.');
                }
            });

            // Handle rollback product button click
            $(document).on('click', '.rollback_product', function() {
                var id = $(this).data('id');
                var name =  $(this).data('name');
                // Remove product row
                $("#row-" + id).remove();
                // Add option back to select
                var ui = `<option class="op-${id}" value="${id} - ${name}">${name}</option>`;
                $('#products').append(ui)
            });
        });
    </script>
@endsection
