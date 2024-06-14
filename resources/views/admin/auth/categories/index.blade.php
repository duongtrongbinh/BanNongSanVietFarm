@extends('admin.layout.master')
@section('title', 'Category List')
@section('content')
    <div class="pagetitle">
      <h1>Category List</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Category</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                  <a href="{{ route('categories.create') }}">
                  <i class="bi bi-plus-circle"></i>
                  Create Category
                </a>
              </h5>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Slug</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($categories as $key => $category)
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $category->name }}</td>
                      <td>{{ $category->description }}</td>
                      <td>{{ $category->slug }}</td>
                      <td>
                        <div class="d-flex justify-content-center align-items-center">
                          <div class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary btn-sm">
                              <i class="bi bi-pencil-square"></i>
                            </a>
                            <a data-url="{{ route('categories.destroy', $category) }}"  class="btn btn-danger btn-sm deleteSlide">
                              <i class="bi bi-trash"></i>
                            </a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
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