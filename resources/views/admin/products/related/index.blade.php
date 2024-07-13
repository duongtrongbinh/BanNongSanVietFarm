@extends('admin.layout.master')
@section('title', 'Thêm sản phẩm liên quan')
@section('css')
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/index.min.css')}}">

  <!--datatable css-->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
  <!--datatable responsive css-->
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('content')
    <div class="pagetitle">
      <h1>Thêm sản phẩm liên quan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Sản phẩm</a></li>
          <li class="breadcrumb-item"><a href="{{ route('related.index', $product->id) }}" class="active">Thêm mới</a></li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <!-- Form -->
                <form action="{{ route('related.store') }}" method="POST" data-toggle="validator" enctype="multipart/form-data">
                  @csrf
                  <div class="row form-group mt-2">
                    <div class="col-5 mt-2">
                      <label for="name">Tên nhóm sản phẩm</label>
                      <input type="text" class="form-control mt-2" name="name" value="{{ old('name')}}">
                      @error('name')
                        <div style="color: red">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="col-7 mt-2">
                      <label for="product" class="mb-2">Sản phẩm</label>
                      <select class="select2-multiple form-control" name="products[]" multiple="multiple" id="select2Products">
                        @foreach ($products as $product)
                          <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach         
                      </select>
                      @error('products')
                        <div style="color: red">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="col mt-2">
                      <table id="productsTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Thương hiệu</th>
                                <th>Danh mục</th>
                                <th>Nhãn</th>
                                <th>Đơn Giá</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                    <button type="reset" class="btn btn-secondary">Hoàn tác</button>
                  </div>
                </form>
                <!-- End Horizontal Form -->
              </div>
            </div>
          </div>
        </div>
      </section>
@endsection

@section('js')
  <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script> 

  <!--datatable js-->
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

  <script>
    $(document).ready(function() {
      // Select2 Multiple
      var select2Products = $('.select2-multiple');
      select2Products.select2({
          placeholder: "Chọn sản phẩm",
          allowClear: true
      });

      var table = $('#productsTable').DataTable();

      $('#productsTable').on('click', '.remove-product', function() {
        var row = table.row($(this).parents('tr'));
        var productName = $(this).closest('tr').find('td:eq(2)').text(); // Lấy tên sản phẩm từ DataTable
        table.row(row).remove().draw(false);

        // Xóa sản phẩm tương ứng trong Select2
        select2Products.find('option').filter(function() {
          return $(this).text() === productName;
        }).prop('selected', false);
        select2Products.trigger('change'); // Đồng bộ hóa lại Select2
      });

      $('.select2-selection__rendered').on('click', '.select2-selection__choice', function() {
        var value = $(this).attr('title');
        var option = $('#select2Products option').filter(function() {
          return $(this).html() === value;
        });

        if (option.length > 0) {
          option.prop('selected', false);
          $('#select2Products').trigger('change');
        }
      });

      $('#select2Products').on('change', function() {
        var id = $(this).val();

        if (id) {
          $.ajax({
            url: '{{ route('getProduct') }}',
            type: 'GET',
            data: { 
              id: id 
            },
            success: function(response) {
              table.clear();
              if (Array.isArray(response)) {
                response.forEach(function(product, index) {
                  table.row.add([
                    index + 1,
                    `<img src="${product.image}" alt="${product.name}" width="100px">`,
                    product.name,
                    product.brand.name,
                    product.category.name,
                    product.tags.map(tag => tag.name).join('<br>'),
                    formatNumber(product.price_sale) + ` VNĐ`,
                    `<div class="text-danger d-inline-block remove-product">
                      <i class="ri-delete-bin-5-fill fs-16"></i>
                    </div>`,
                  ]).draw(false);
                });
              } else {
                table.clear().draw();
              }
            },
          });
        } else {
          table.clear().draw();
        }
      });

      function formatNumber(number) {
        // // Chuyển đổi số thành chuỗi và loại bỏ các chữ số thập phân không cần thiết
        let formattedNumber = Math.floor(number);

        // // Định dạng chuỗi số thành số có dấu phân cách hàng nghìn
        return Number(formattedNumber).toLocaleString('en-US');
      }
    });
  </script>
@endsection
