function showMessage(title, message, icon) {
    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        showConfirmButton: false,
        timer: 1500
    });
}

