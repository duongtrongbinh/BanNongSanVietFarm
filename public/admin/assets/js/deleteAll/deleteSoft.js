function actionDelete(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let urlRequest = $(this).data("url");
    console.log(urlRequest);
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
                success: function (data) {
                    if (data == true) {
                        that.parent().parent().parent().remove();
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

function restoreDelete(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let urlRequest = $(this).data("url");
    console.log(urlRequest);
    let that = $(this);
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, restore it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: urlRequest,
                success: function (data) {
                    if (data == true) {
                        that.parent().parent().parent().remove();
                        Swal.fire({
                            title: "Restore!",
                            text: "Your file has been Restore.",
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
    // delete
    $(document).on("click", ".deleteVouchers", actionDelete);
    $(document).on("click", ".deleteFlashSale", actionDelete);

    //restore
    $(document).on("click", ".restoreVouchers", restoreDelete);
});
