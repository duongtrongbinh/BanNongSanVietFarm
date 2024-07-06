@extends('admin.layout.master')
@section('title', 'Danh sách sản phẩm')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <style>
      table.dataTable {
          width: 100% !important;
      }

      .dataTables_wrapper {
          overflow-x: auto; /* Đảm bảo rằng bao quanh bảng có thể cuộn ngang */
      }

      th, td {
          white-space: nowrap; /* Đảm bảo rằng nội dung không bị gói dòng */
      }
    </style>
@endsection
@section('content')
    <div class="pagetitle">
      <h1>Danh sách sản phẩm</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="active">Sản phẩm</a></li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                  <div class="row align-items-center gy-3">
                      <div class="col-sm-auto">
                          <div class="d-flex gap-1 flex-wrap">
                              <a href="{{ route('products.create') }}" class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1"></i> Thêm mới</a>
                              <!-- Basic Modal -->
                              <button type="submit" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#basicModal">
                                <i class="ri-file-download-line align-bottom me-1"></i> Nhập
                              </button>
                              <div class="modal fade" id="basicModal" tabindex="-1">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form action="{{ route('products.import') }}" method="post" enctype="multipart/form-data">
                                      @csrf
                                      <div class="modal-header">
                                        <h4>Nhập file sản phẩm</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        <input type="file" name="product_file" >
                                      </div>
                                      <div class="modal-footer justify-content-center">
                                        <button type="submit" class="btn btn-primary">Nhập</button>
                                      </div>
                                    </form>
                                  </div>
                                  @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                  @endif
                                </div>
                              </div>
                              <!-- End Basic Modal-->
                              <a id="export" class="btn btn-secondary"><i class="bi bi-file-earmark-arrow-up"></i> Xuất</a>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle w-100" >
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Ảnh</th>
                              <th>Tên</th>
                              <th>Thương hiệu</th>
                              <th>Danh mục</th>
                              <th>Tag</th>
                              <th>Số lượng</th>
                              <th>Giá gốc</th>
                              <th>Giá giảm</th>
                              <th>Slug</th>
                              <th>Active</th>
                              <th>Home</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($products as $key => $product)
                          <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <img src="{{ $product->image }}" width="100px">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->brand->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>
                              @foreach ($product->tags as $tag)
                                <div>{{ $tag->name }}</div>
                              @endforeach
                            </td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ number_format($product->price_regular, 0) }} VNĐ</td>
                            <td>{{ number_format($product->price_sale, 0) }} VNĐ</td>
                            <td>{{ $product->slug }}</td>
                            <td>
                              @if ($product->is_active == true)
                                <span class="badge bg-success">Yes</span>
                              @else
                                <span class="badge bg-danger">No</span>
                              @endif
                            </td>
                            <td>
                              @if ($product->is_home == true)
                                <span class="badge bg-success">Yes</span>
                              @else
                                <span class="badge bg-danger">No</span>
                              @endif
                            </td>
                            <td>
                              <ul class="list-inline hstack gap-2 mb-0">
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Chi tiết">
                                    <a href="{{ route('products.show', $product->id) }}" class="text-primary d-inline-block">
                                        <i class="ri-eye-fill fs-16"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Chỉnh sửa">
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-primary d-inline-block">
                                      <i class="ri-pencil-fill fs-16"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Xóa">
                                    <a data-url="{{ route('products.delete', $product->id) }}" class="text-danger d-inline-block deleteProduct">
                                      <i class="ri-delete-bin-5-fill fs-16"></i>
                                    </a>
                                </li>
                              </ul>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div><!--end col-->
      </div><!--end row-->
    </section>
@endsection
@section('js')
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.misn.j"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

    <!--Delete js-->
    <script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#example').DataTable({
          responsive: true,
          autoWidth: false,
          columnDefs: [
            { responsivePriority: 1, targets: 0 },  // ID
            { responsivePriority: 2, targets: 1 },  // Img Thumbnail
            { responsivePriority: 3, targets: 2 },  // Name
            { responsivePriority: 4, targets: 3 },  // Brand
            { responsivePriority: 5, targets: 4 },  // Category
            { responsivePriority: 6, targets: 5 },  // Tag
            { responsivePriority: 7, targets: 6 },  // Quantity
            { responsivePriority: 8, targets: 7 },  // Price Regular
            { responsivePriority: 9, targets: 8 },  // Price Sale
            { responsivePriority: 100, targets: 9 }, // Slug (ít ưu tiên nhất)
            { responsivePriority: 100, targets: 10 }, // Is Active (ít ưu tiên nhất)
            { responsivePriority: 100, targets: 11 }, // Is Home (ít ưu tiên nhất)
            { responsivePriority: 10, targets: 12 }  // Action
          ]
        });

        $('#export').click(function() {
          var table = document.getElementById("example");
          var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
          XLSX.writeFile(wb, "products.xlsx");
        });
      });
    </script>
@endsection
