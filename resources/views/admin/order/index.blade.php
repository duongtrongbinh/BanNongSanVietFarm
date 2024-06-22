@extends('admin.layout.master')
@section('title', 'Orders List')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Orders</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </nav>

    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Personal information</th>
                                <th scope="col">Before total</th>
                                <th scope="col">Shipping</th>
                                <th scope="col">After total</th>
                                <th scope="col">Is active</th>
                                <th scope="col">Order details</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($orders))
                                @foreach($orders as $items)
                                    <tr>
                                        <th data-ordering="false">ID</th>
                                        <th>Mã hóa đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Sản phẩm</th>
                                        <th>Ngày đặt hàng</th>
                                        <th>Tổng tiền</th>
                                        <th>Phương thức thanh toán</th>
                                        <th>Trạng thái</th>
                                        <th>Chỉnh sửa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($delivereds as $key => $delivered)
                                        <tr>
                                            <td>
                                                {{ $key }}
                                            </td>
                                            <td>
                                                <a href="" class="fw-medium link-primary">{{ $delivered->order_code }}</a>
                                            </td>
                                            <td>
                                                {{ $delivered->user->name }}
                                            </td>
                                            <td>
                                                @foreach ($delivered->order_details as $order_detail)
                                                    <div>{{ $order_detail->name }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $delivered->created_at }}
                                            </td>
                                            <td>{{ number_format($delivered->after_total_amount) }}đ</td>
                                            <td>VNPAY</td>
                                            <td>
                                                @if ($delivered->status == 0)
                                                    <span class="badge bg-warning-subtle text-warning text-uppercase">Pending</span>
                                                @elseif ($delivered->status == 1)
                                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase">Inprogress</span>
                                                @elseif ($delivered->status == 2)
                                                    <span class="badge bg-info-subtle text-info text-uppercase">Pickups</span>
                                                @elseif ($delivered->status == 3)
                                                    <span class="badge bg-success-subtle text-success text-uppercase">Delivered</span>
                                                @elseif ($delivered->status == 4)
                                                    <span class="badge bg-primary-subtle text-primary text-uppercase">Returns</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="{{ route('order.show', $delivered->id) }}" class="text-primary d-inline-block">
                                                            <i class="ri-eye-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                            <i class="ri-pencil-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
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

                                        <td> {{ number_format($items->before_total_amount, 0, ',', '.') }}</td>
                                        <td> {{ number_format($items->shipping, 0, ',', '.') }}</td>
                                        <td> {{ number_format($items->after_total_amount, 0, ',', '.') }}</td>
                                        <td>@if($items->status == 0)
                                                <span class="badge bg-warning">Wait for pay</span>
                                            @else
                                                <span class="badge bg-primary">Delivery</span>
                                            @endif
                                        </td>
                                        <td><a href="/order/{{$items->id}}/detail" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>

                                        <td>
                                            <div class="d-flex" style="gap: 10px">
                                                <a href="/{{ $items->id }}/edit"><button class="btn btn-primary">Detail</button></a>
                                            </div>
                                        </td>

                        <!-- Cancelled -->
                        <div class="tab-pane fade cancelled pt-3" id="cancelled">
                            <table id="table4" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th data-ordering="false">ID</th>
                                        <th>Mã hóa đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Sản phẩm</th>
                                        <th>Ngày đặt hàng</th>
                                        <th>Tổng tiền</th>
                                        <th>Phương thức thanh toán</th>
                                        <th>Trạng thái</th>
                                        <th>Chỉnh sửa</th>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">

                        </div>
                    </div>
                    <!-- End Bordered Tabs -->
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
        $(document).ready(function() {
            $('#table1').DataTable();
            $('#table2').DataTable();
            $('#table3').DataTable();
            $('#table4').DataTable();
            // Khởi tạo cho các bảng khác nếu có
        });

      new DataTable("#example");
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
