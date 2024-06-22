@extends('admin.layout.master')
@section('title', 'List Product')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('content')
    <div class="pagetitle">
      <h1>List Product</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Product</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="col-sm-auto">
                        <div>
                            <a href="{{ route('products.create') }}" class="btn btn-success" id="addproduct-btn"><i class="ri-add-line align-bottom me-1"></i> Add Product</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
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
                              <td>{{ $key }}</td>
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
                                <div class="d-flex justify-content-center align-items-center">
                                  <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                  </a>
                                  <a data-url="{{ route('products.destroy', $product) }}"  class="btn btn-danger btn-sm deleteSlide">
                                    <i class="bi bi-trash"></i>
                                  </a>
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!--Delete js-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      $('#example').DataTable({
        responsive: true,
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

      function actionDelete(e) {
        e.preventDefault();
        let urlRequest = $(this).data("url");
        let that = $(this);
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: urlRequest,
                    data: {
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function (data) {
                        if (data == true) {
                            that.closest('tr').remove();
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success",
                            });
                        }
                    },
                    error: function (data) {
                        if (data == false) {
                            Swal.fire({
                                title: "Cancelled",
                                text: "Your imaginary file is safe :)",
                                icon: "error",
                            });
                        }
                    },
                });
            }
        });
      }
      $(function () {
        $(document).on("click", ".deleteSlide", actionDelete);
      });
    </script> 
@endsection