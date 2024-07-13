function actionDelete(e) {
    e.preventDefault();
    let urlRequest = $(this).data("url");
    let that = $(this);
    Swal.fire({
        title: "Bạn có chắc không?",
        text: "Bạn sẽ không thể hoàn tác điều này!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Vâng, xóa nó đi!",
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
                            title: "Đã xóa!",
                            text: "Tập tin của bạn đã bị xóa!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function (data) {
                    if (data == false) {
                        Swal.fire({
                            title: "Đã hủy",
                            text: "Xóa không thành công!",
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
    $(document).on("click", ".deleteGroup", actionDelete);
    $(document).on("click", ".deleteSlide", actionDelete);
    $(document).on("click", ".deleteSupplier", actionDelete);
    $(document).on("click", ".deletepost", actionDelete);
    $(document).on("click", ".deleteuser", actionDelete);
});
