@extends('admin.layout.master')
@section('title', 'Chỉnh sửa nhóm sản phẩm')
@section('css')
  <!--datatable css-->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
  <!--datatable responsive css-->
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/index.min.css')}}">
@endsection
@php
  $updated = session('updated');
@endphp
@section('content')
    <div class="pagetitle">
      <h1>Chỉnh sửa nhóm sản phẩm</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">Nhóm sản phẩm</a></li>
          <li class="breadcrumb-item"><a href="{{ route('groups.edit', $group->id) }}" class="active">Chỉnh sửa</a></li>
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
                <form action="{{ route('groups.update', $group->id) }}" method="POST" data-toggle="validator" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="row form-group mt-2">
                    <div class="col-5 mt-2">
                      <label for="name">Tên nhóm sản phẩm</label>
                      <input type="text" class="form-control mt-2" name="name" value="{{ $group->name }}">
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
                        @foreach ($products as $product)
                          @php
                              $isSelected = false;
                          @endphp
                          @foreach ($group->products as $product_group)
                              @if ($product_group->id == $product->id)
                                  <option selected value="{{ $product_group->id }}">{{ $product->name }}</option>
                                  @php
                                      $isSelected = true;
                                  @endphp
                              @endif
                          @endforeach
                          @if (!$isSelected)
                              <option value="{{ $product->id }}">{{ $product->name }}</option>
                          @endif
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
                        <tbody>
                          @foreach ($group->products as $key => $product)
                            <tr>
                              <td>{{ $key + 1 }}</td>
                              <td><img src="{{ $product->image }}" width="100px"></td>
                              <td>{{ $product->name }}</td>
                              <td>{{ $product->brand->name }}</td>
                              <td>{{ $product->category->name }}</td>
                              <td>{!! $product->tags->pluck('name')->implode('<br>') !!}</td>
                              <td>{{ number_format($product->price_sale) }} VNĐ</td>
                              <td>
                                <div class="text-danger d-inline-block remove-product">
                                  <i class="ri-delete-bin-5-fill fs-16"></i>
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!--ShowMessage js-->
  <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>

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

      let status = @json($updated);
      let title = 'Cập nhật';
      let message = status;
      let icon = 'success';

      if (status) {
        showMessage(title, message, icon);
      }
    });
  </script>
@endsection
