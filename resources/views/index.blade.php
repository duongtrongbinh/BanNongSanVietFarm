@extends('admin.layout.master')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('content')
    <div class="pagetitle">
        <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Product</li>
        </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    {{-- <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Create Product</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="basiInput" class="form-label">Name</label>
                                    <input type="password" class="form-control" id="basiInput" name="name">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="labelInput" class="form-label">Input with Label</label>
                                    <input type="password" class="form-control" id="labelInput">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="placeholderInput" class="form-label">Input with Placeholder</label>
                                    <input type="password" class="form-control" id="placeholderInput" placeholder="Placeholder">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="valueInput" class="form-label">Input with Value</label>
                                    <input type="text" class="form-control" id="valueInput" value="Input value">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="readonlyPlaintext" class="form-label">Readonly Plain Text Input</label>
                                    <input type="text" class="form-control-plaintext" id="readonlyPlaintext" value="Readonly input" readonly>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="readonlyInput" class="form-label">Readonly Input</label>
                                    <input type="text" class="form-control" id="readonlyInput" value="Readonly input" readonly>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="disabledInput" class="form-label">Disabled Input</label>
                                    <input type="text" class="form-control" id="disabledInput" value="Disabled input" disabled>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="iconInput" class="form-label">Input with Icon</label>
                                    <div class="form-icon">
                                        <input type="email" class="form-control form-control-icon" id="iconInput" placeholder="example@gmail.com">
                                        <i class="ri-mail-unread-line"></i>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="iconrightInput" class="form-label">Input with Icon Right</label>
                                    <div class="form-icon right">
                                        <input type="email" class="form-control form-control-icon" id="iconrightInput" placeholder="example@gmail.com">
                                        <i class="ri-mail-unread-line"></i>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="exampleInputdate" class="form-label">Input Date</label>
                                    <input type="date" class="form-control" id="exampleInputdate">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="exampleInputtime" class="form-label">Input Time</label>
                                    <input type="time" class="form-control" id="exampleInputtime">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="exampleInputpassword" class="form-label">Input Password</label>
                                    <input type="password" class="form-control" id="exampleInputpassword" value="44512465">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="exampleFormControlTextarea5" class="form-label">Example Textarea</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="formtextInput" class="form-label">Form Text</label>
                                    <input type="password" class="form-control" id="formtextInput">
                                    <div id="passwordHelpBlock" class="form-text">
                                        Must be 8-20 characters long.
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="colorPicker" class="form-label">Color Picker</label>
                                    <input type="color" class="form-control form-control-color w-100" id="colorPicker" value="#364574">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="borderInput" class="form-label">Input Border Style</label>
                                    <input type="text" class="form-control border-dashed" id="borderInput" placeholder="Enter your name">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <label for="exampleDataList" class="form-label">Datalist example</label>
                                <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Search your country...">
                                <datalist id="datalistOptions">
                                    <option value="Switzerland">
                                    <option value="New York">
                                    <option value="France">
                                    <option value="Spain">
                                    <option value="Chicago">
                                    <option value="Bulgaria">
                                    <option value="Hong Kong">
                                </datalist>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="exampleInputrounded" class="form-label">Rounded Input</label>
                                    <input type="text" class="form-control rounded-pill" id="exampleInputrounded" placeholder="Enter your name">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="firstnamefloatingInput" placeholder="Enter your firstname">
                                    <label for="firstnamefloatingInput">Floating Input</label>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div> --}}

    <!-- Index -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Basic Datatables</h5>
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
                                    <th scope="col" style="width: 10px;">
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th data-ordering="false">ID</th>
                                    <th>Img Thumbnail</th>
                                    <th>Name</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Price Regular</th>
                                    <th>Price Sale</th>
                                    <th>Quantity</th>
                                    <th>Is Active</th>
                                    <th>Is Home</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>VLZ-452</td>
                                    <td>VLZ1400087402</td>
                                    <td><a href="#!">Post launch reminder/ post list</a></td>
                                    <td>Joseph Parker</td>
                                    <td>Alexis Clarke</td>
                                    <td>Joseph Parker</td>
                                    <td>03 Oct, 2021</td>
                                    <td><span class="badge bg-info-subtle text-info">Re-open</span></td>
                                    <td><span class="badge bg-danger">High</span></td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <a href="" class="btn btn-secondary btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="" method="post" class="mb-0">
                                            @csrf
                                            @method('DELETE')
                                              <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Bạn có muốn xóa không?')">
                                                <i class="bi bi-trash"></i>
                                              </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" name="checkAll" value="option1">
                                        </div>
                                    </th>
                                    <td>02</td>
                                    <td>VLZ-453</td>
                                    <td>VLZ1400087425</td>
                                    <td><a href="#!">Additional Calendar</a></td>
                                    <td>Diana Kohler</td>
                                    <td>Admin</td>
                                    <td>Mary Rucker</td>
                                    <td>05 Oct, 2021</td>
                                    <td><span class="badge bg-secondary-subtle text-secondary">On-Hold</span></td>
                                    <td><span class="badge bg-info">Medium</span></td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                <li>
                                                    <a class="dropdown-item remove-item-btn">
                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div>
    
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

    <script src="{{ asset('admin/assets/js/pages/datatables.init.js')}}"></script> 
@endsection