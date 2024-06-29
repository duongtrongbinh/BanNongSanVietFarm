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
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (data) {
                    if (data.data == null) {
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
    $(document).on("click", ".deleteBrand", actionDelete);
    $(document).on("click", ".deleteCategory", actionDelete);
    $(document).on("click", ".deleteTag", actionDelete);
    $(document).on("click", ".deleteProduct", actionDelete);
    $(document).on("click", ".deleteSlide", actionDelete);
    $(document).on("click", ".deleteSupplier", actionDelete);
    $(document).on("click", ".deletepost", actionDelete);
    $(document).on("click", ".deleteuser", actionDelete);
});
