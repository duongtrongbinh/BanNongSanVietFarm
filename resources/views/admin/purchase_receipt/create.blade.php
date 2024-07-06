
@extends('admin.layout.master')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/index.min.css')}}">
@endsection
@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
        <li class="breadcrumb-item active">Add supplier</li>
      </ol>
    </nav>
  </div>
<div class="container-fuild" style="height: 100vh; padding: 15px 20px; background: #f8f5f5">
  <div class="row mb-5">
    <form method="POST" action="{{ route('purchase_receipt.store')}}">  
      @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-8">
                    <div class="row">
                        <div class="col-12" style=" justify-items: center">
                            <div class="form-group mb-3">
                                <label for="select2Multiple" class="mb-1">Chọn sản phẩm</label>
                                <select class="select2-multiple form-select" name="product_id[]" multiple="multiple" id="select2Multiple" class="pro">
                                    @foreach ($product as $item)
                                        <option value="{{ $item->id}}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="card" style="height: 100vh">
                            <div class="card-header">
                                <div class="d-flex" style=" justify-items: center">
                                    <button type="button" class="btn btn-primary" style="margin: 5px 0" id="addProductButton">Add Product</button>
                                </div>
                            </div>
                            <div class="card-body mt-5">
                                <table class="table table-striped datatableProduct" >
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>ĐVT</th>
                                            <th>Giá Vốn</th>
                                            <th>Quantity</th>
                                            <th>Đơn Giá</th>
                                            <th>Ngày Hết Hạn</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody">
                                        <tr class='text-center'>
                                            <td colspan="9">
                                                No Data
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card" style="height: 100vh">
                        <div class="row" style="margin: 0 3px">
                            <div class="col-12 d-flex mt-3" style="gap:3px">
                                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name ?? 'Chưa đăng nhập' }}">
                                <input type="datetime" name="time" class="form-control" value="{{  now()->format('d/m/Y H:i:s') }}">
                            </div>
                            <div class="col-12 mt-4">
                                <div class="form-group">
                                    <label for="supli">Nhà cung cấp</label>
                                    <select name="supplier" id="supli" class="form-select mt-1">
                                        @if (!$suppliers)
                                            <option value="0">Chưa có nhà cung cấp</option>
                                        @else
                                            @foreach ($suppliers as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="">Mã nhận dạng đơn nhập hàng</label>
                                <input class='form-control mt-1' type='text' name="reference_code" >
                                <input type="hidden" name="productData" id="productDataInput">
                            </div>
                            <div class="col-12 mt-3">
                                <label for="">Tổng giá trị đơn nhập</label>
                                <input class='form-control mt-1' type='text' name="total" id="sumTotalPrice" >
                            </div>
                            <div class="col-12">
                                <div class="form-group mt-3">
                                    <label for="">Note</label>
                                    <textarea name="note" id="" cols="20" rows="10" class="form-control mt-1"></textarea>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button class='btn btn-primary' type="submit">Nhập hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </form>
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script> 
{{-- <script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script> --}}
{{-- <script src="/path-to-your-tinymce/tinymce.min.js"></script> --}}
 <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

        });

    </script>


<script>
function formatCurrencyVND(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}


 document.addEventListener('DOMContentLoaded', function () {
    var products = @json($product);

    var totalAmount = 0;
    var sumTotalPriceInput = document.getElementById('sumTotalPrice');
    var tableBody = document.getElementById('productTableBody');
    var productDataInput = document.getElementById('productDataInput');

    function updateTotalAmount() {
        totalAmount = 0;
        var rows = tableBody.rows;
        for (var i = 0; i < rows.length; i++) {
            var quantityInput = rows[i].cells[5].querySelector('input');
            var unitPriceInput = rows[i].cells[6].querySelector('input');
            var quantity = Number(quantityInput.value);
            var unitPrice = Number(products[i].price_regular);
            var totalPrice = unitPrice * quantity;
            unitPriceInput.value = formatCurrencyVND(totalPrice);
            totalAmount += totalPrice;
        }
        sumTotalPriceInput.value = formatCurrencyVND(totalAmount);
    }

    document.getElementById('addProductButton').addEventListener('click', function() {
        var select = document.getElementById('select2Multiple');
        var tableBody = document.getElementById('productTableBody');
        
        var selectedIds = Array.from(select.selectedOptions).map(option => option.value);
        var selectedProducts = products.filter(product => selectedIds.includes(product.id.toString()));
        
        tableBody.innerHTML = '';

        totalAmount = 0;

        selectedProducts.forEach(function(product, index) {
            var newRow = tableBody.insertRow();
            var quantity = 1;

            var cellIndex = newRow.insertCell(0);
            cellIndex.textContent = index + 1;

            var cellImage = newRow.insertCell(1);
            var img = document.createElement('img');
            img.src = product.image ? product.image : '';
            img.width = 100;
            img.height = 100;
            img.classList.add('img-fluid');
            cellImage.appendChild(img);

            var cellName = newRow.insertCell(2);
            cellName.textContent = product.name;

            var cellUnit = newRow.insertCell(3);
            cellUnit.textContent = 'chai';

            var cellCost = newRow.insertCell(4);
            cellCost.textContent = formatCurrencyVND(Number(product.price_regular));

            var cellQuantity = newRow.insertCell(5);
            var inputQuantity = document.createElement('input');
            inputQuantity.type = 'number';
            inputQuantity.value = quantity;
            inputQuantity.classList.add('form-control');
            inputQuantity.addEventListener('input', function() {
                updateTotalAmount();
                 productDataInput.value = getProductData();
            });
            cellQuantity.appendChild(inputQuantity);

            var cellUnitPrice = newRow.insertCell(6);
            var inputUnitPrice = document.createElement('input');
            inputUnitPrice.type = 'text';
            inputUnitPrice.value = formatCurrencyVND(Number(product.price_regular) * quantity);
            inputUnitPrice.classList.add('form-control');
            inputUnitPrice.addEventListener('input', function() {
                updateTotalAmount();
            });
            cellUnitPrice.appendChild(inputUnitPrice);

            var cellDate = newRow.insertCell(7);
            var inputDate = document.createElement('input');
            inputDate.type = 'date';
                    inputDate.addEventListener('change', function() {
            productDataInput.value = getProductData();
            });
            inputDate.classList.add('form-control');
            cellDate.appendChild(inputDate);


            var cellAction = newRow.insertCell(8);
            var deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.classList.add('btn', 'btn-danger', 'btn-sm');
            deleteButton.addEventListener('click', function() {
                newRow.remove();
                updateTotalAmount();
            });
            cellAction.appendChild(deleteButton);

            totalAmount += quantity * Number(product.price_regular);
        });
        sumTotalPriceInput.value = formatCurrencyVND(totalAmount);
        getProductData();
        productDataInput.value = getProductData();

    });

    function getProductData() {
        var productData = [];
        var rows = tableBody.rows;
        for (var i = 0; i < rows.length; i++) {
            var productId = products.find(p => p.name === rows[i].cells[2].textContent).id;
            var quantity = Number(rows[i].cells[5].querySelector('input').value);
            var unit = rows[i].cells[3].textContent;
            var date = rows[i].cells[7].querySelector('input').value;
            productData.push({ product_id: productId, quantity: quantity, type_unit: unit, end_date: date });
        }

        return JSON.stringify(productData);
    }
});
</script>
@endsection