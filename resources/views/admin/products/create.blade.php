@extends('admin.layout.master')
@section('title', 'Thêm mới sản phẩm')
@section('css')
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/index.min.css')}}">
  
  <!--datatable css-->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
  <!--datatable responsive css-->
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
  
  <style>
      .selectDiv .select2-container {
        display: block !important;
      }
  </style>
@endsection
@section('content')
    <div class="pagetitle">
      <h1>Thêm mới sản phẩm</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
          <li class="breadcrumb-item"><a href="{{ route('products.create') }}" class="active">Thêm mới</a></li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-bordered">
          <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#product">
                  <i class="bi bi-info-circle me-1 align-bottom"></i>
                  Thông tin sản phẩm
              </button>
          </li>
          <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#related">
                  <i class="bi bi-node-plus me-1 align-bottom"></i> 
                  Sản phẩm liên quan
              </button>
          </li>
        </ul>
        <form action="{{ route('products.store') }}" method="POST" data-toggle="validator" enctype="multipart/form-data">
          @csrf
          <div class="tab-content mt-2">
            <div class="tab-pane fade show active product" id="product">
              <div class="row form-group">
                <div class="col-3 mt-2">
                  <label for="name">Tên sản phẩm</label>
                  <input type="text" class="form-control mt-2" name="name" id="name" value="{{ old('name')}}">
                  @error('name')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3 mt-2">
                  <label for="brand_id">Thương hiệu</label>
                  <select class="form-select mt-2" name="brand_id" id="brand_id" aria-label="Default select example">
                    <option value="" selected>Mở menu chọn này</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                  </select>
                  @error('brand_id')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3 mt-2">
                  <label for="category_id">Danh mục</label>
                  <select class="form-select mt-2" name="category_id" id="category_id" aria-label="Default select example">
                    <option value="" selected>Mở menu chọn này</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                  </select>
                  @error('category_id')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3 mt-2">
                  <label for="quantity">Số lượng</label>
                  <input type="number" class="form-control mt-2" name="quantity" id="quantity" value="{{ old('quantity', 0)}}">
                  @error('quantity')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-6 mt-2">
                  <label for="thumbnail">Ảnh</label>
                  <div class="input-group">
                    <span class="input-group-btn">
                      <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white mt-2">
                        <i class="fa fa-picture-o"></i> Chọn
                      </a>
                    </span>
                    <input id="thumbnail" class="form-control mt-2" type="text" name="image[]" value="{{ old('image[]')}}">
                  </div>
                  @if ($errors->has('image.0'))
                    <div style="color: red">{{ $errors->first('image.0') }}</div>
                  @endif
                  <div id="holder" style="margin-top:15px;"></div>
                </div>
                <div class="col-6 mt-2">
                  <label for="select2Multiple" class="mb-2">Nhãn</label>
                  <select class="form-control" name="tags[]" multiple="multiple" id="select2Multiple">
                    @foreach ($tags as $tag)
                      <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>{{ $tag->name }}</option>
                    @endforeach         
                  </select>
                  @error('tags')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                  @foreach ($errors->get('tags.*') as $index => $message)
                    <div style="color: red">{{ $message[0] }}</div>
                  @endforeach
                </div>
                <div class="col-4 mt-2">
                  <label for="price_regular">Giá gốc (VNĐ)</label>
                  <input type="text" class="form-control mt-2" name="price_regular" id="price_regular" value="{{ old('price_regular', 0)}}">
                  @error('price_regular')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-4 mt-2">
                  <label for="price_sale">Giá giảm (VNĐ)</label>
                  <input type="text" class="form-control mt-2" name="price_sale" id="price_sale" value="{{ old('price_sale', 0)}}">
                  @error('price_sale')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                  @error('price_sale.lt')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-4 mt-2">
                  <label for="excerpt">Loại trừ</label>
                  <input type="text" class="form-control mt-2" name="excerpt" id="excerpt" value="{{ old('excerpt')}}">
                  @error('except')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3 mt-2">
                  <label for="length">Chiều dài (Cm)</label>
                  <input type="text" class="form-control mt-2" name="length" id="length" value="{{ old('length', 0)}}">
                  @error('length')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3 mt-2">
                  <label for="width">Chiều rộng (Cm)</label>
                  <input type="text" class="form-control mt-2" name="width" id="width" value="{{ old('width', 0)}}">
                  @error('width')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3 mt-2">
                  <label for="height">Chiều cao (Cm)</label>
                  <input type="text" class="form-control mt-2" name="height" id="height" value="{{ old('height', 0)}}">
                  @error('height')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3 mt-2">
                  <label for="weight">Trọng lượng (Gram)</label>
                  <input type="text" class="form-control mt-2" name="weight" id="weight" value="{{ old('weight', 0)}}">
                  @error('weight')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-12 mt-2">
                  <label for="description">Mô tả</label>
                  <textarea class="form-control mt-2" name="description" id="description">{{ old('description')}}</textarea>
                  @error('description')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-12 mt-2">
                  <label for="content">Nội dung</label>
                  <textarea class="form-control mt-2 my-editor-tinymce4" name="content" id="content">{{ old('content')}}</textarea>
                  @error('content')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-2 mt-2">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" value="{{ old('is_active')}}" name="active" id="flexSwitchCheckChecked" checked>
                    <label class="form-check-label" for="flexSwitchCheckChecked">Active</label>
                  </div>
                </div>
                <div class="col-2 mt-2">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" value="{{ old('is_home')}}" name="home" id="flexSwitchCheckChecked" checked>
                    <label class="form-check-label" for="flexSwitchCheckChecked">Home</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade related" id="related">
              <div class="row form-group">
                <div class="col-8 selectDiv">
                  <label for="select2Products" class="mb-2">Sản phẩm</label>
                  <select class="form-control" name="products[]" multiple="multiple" id="select2Products">
                    @foreach ($products as $product)
                      <option value="{{ $product->id }}" {{ in_array($product->id, old('products', [])) ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach   
                  </select>
                  @error('products')
                    <div style="color: red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-12 mt-2">
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
                          <th>Action</th>
                        </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
            <div class="text-center mt-5">
              <button type="submit" class="btn btn-primary">Thêm mới</button>
              <button type="reset" class="btn btn-secondary">Hoàn tác</button>
            </div>
          </div>
        </form>
      </div>
    </div>
@endsection
@section('js')
  <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script> 
  <script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script>

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
      $('#select2Multiple').select2({
        them: 'bootstrap-5',
        placeholder: "Chọn nhãn",
        allowClear: true
      });

      var select2Products = $('#select2Products');
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

      $('#select2-select2Products-container').on('click', '.select2-selection__choice', function() {
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