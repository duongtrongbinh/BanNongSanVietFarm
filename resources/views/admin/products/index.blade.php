@extends('admin.layout.master')
@section('title', 'Danh sách sản phẩm')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@php
  $created = session('created');
  $importErrors = session('importErrors');
@endphp
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
                      <div class="col">
                          <div class="d-flex justify-content-between">
                            <div class="">
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
                                      <a href="{{ asset('excel/Mẫu thêm sản phẩm.xlsx') }}" class="btn btn-link">Mẫu thêm sản phẩm.xlsx</a>
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
                            </div>
                            <div>
                              <form action="{{ route('products.export') }}" method="post">
                                @csrf
                                <div class="d-flex">
                                  <div style="margin-right: 5px;">
                                    <select class="form-select" name="paginate" id="paginate">
                                      <option value="10">10</option>
                                      <option value="25">25</option>
                                      <option value="50">50</option>
                                      <option value="100">100</option>
                                      <option value="all">Tất cả</option>
                                    </select>
                                  </div>
                                  <div>
                                    <button type="submit" id="export" class="btn btn-secondary">
                                      <i class="bi bi-file-earmark-arrow-up me-1"></i> Xuất
                                    </button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <table id="productTable" class="table table-bordered dt-responsive nowrap table-striped align-middle w-100" >
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Ảnh</th>
                              <th>Tên</th>
                              <th>Thương hiệu</th>
                              <th>Danh mục</th>
                              <th>Nhãn</th>
                              <th>Số lượng</th>
                              <th>Giá gốc</th>
                              <th>Giá giảm</th>
                              <th>Active</th>
                              <th>Home</th>
                              <th>Action</th>
                          </tr>
                      </thead>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>  

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--Delete js-->
    <script src="{{ asset('admin/assets/js/deleteAll/delete.js') }}"></script>


    <!--ShowMessage js-->
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#productTable').DataTable({
          responsive: true,
          processing: true,
          serverSide: true,
          ajax: {
            url: '{{ route("products.data") }}',
            type: 'GET',
          },
          autoWidth: false,
          columns: [
            { data: 'stt', name: 'stt' },
            { data: 'image', name: 'image', orderable: false, searchable: false},
            { data: 'name', name: 'name' },
            { data: 'brand', name: 'brand' },
            { data: 'category', name: 'category' },
            { data: 'tags', name: 'tags' },
            { data: 'quantity', name: 'quantity' },
            { data: 'price_regular', name: 'price_regular' },
            { data: 'price_sale', name: 'price_sale' },
            { data: 'is_home', name: 'is_home', orderable: false, searchable: false },
            { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
          ],
          columnDefs: [
            { responsivePriority: 1, targets: 0 },  // ID column
            { responsivePriority: 2, targets: 1 },  // Img Thumbnail
            { responsivePriority: 3, targets: 2 },  // Name
            { responsivePriority: 4, targets: 3 },  // Brand
            { responsivePriority: 5, targets: 4 },  // Category
            { responsivePriority: 6, targets: 5 },  // Tag
            { responsivePriority: 7, targets: 6 },  // Quantity
            { responsivePriority: 8, targets: 7 },  // Price Regular
            { responsivePriority: 9, targets: 8 },  // Price Sale
            { responsivePriority: 100, targets: 9 }, // Is Active (least priority)
            { responsivePriority: 100, targets: 10 }, // Is Home (least priority)
            { responsivePriority: 10, targets: 11 }  // Action
          ]
        });

        //Show Message
        let status = @json($created);
        let title = 'Thêm mới';
        let message = status;
        let icon = 'success';

        if (status) {
          showMessage(title, message, icon);
        }
      });
    </script> 

    @if ($errors->any())
      <script>
        Swal.fire({
          title: "Lỗi nhập file thêm sản phẩm",
          text: "Kiểm tra lại dữ liệu trong file!",
          icon: "error"
        });
      </script>
    @endif
@endsection

