$(document).ready(function () {
    function fetchWarehouseData() {
        $.ajax({
            url: '/api/purchasereceipt',  // URL tương ứng với route API bạn đã định nghĩa
            type: 'GET',
            success: function (response) {
                console.log('Warehouse API Response:', response);

                // Cập nhật tổng số phiếu nhập hàng hôm nay
                $('#total-receipts-today').text(response.total_receipts_today);

                // Cập nhật phần trăm thay đổi phiếu nhập hàng
                $('#receipts-percentage-change').text(`${response.receipts_percentage_change}%`)
                    .removeClass('text-success text-danger')
                    .addClass(response.receipts_percentage_change >= 0 ? 'text-success' : 'text-danger');

                // Cập nhật tổng số lượng sản phẩm nhập kho hôm nay
                $('#total-quantity-today').text(response.total_quantity_today.toLocaleString('vi-VN'));

                // Cập nhật phần trăm thay đổi số lượng sản phẩm
                $('#quantity-percentage-change').text(`${response.quantity_percentage_change}%`)
                    .removeClass('text-success text-danger')
                    .addClass(response.quantity_percentage_change >= 0 ? 'text-success' : 'text-danger');

                // Cập nhật tổng giá trị sản phẩm nhập kho hôm nay
                $('#total-value-today').text(parseFloat(response.total_value_today).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

                // Cập nhật phần trăm thay đổi giá trị sản phẩm
                $('#value-percentage-change').text(`${response.value_percentage_change}%`)
                    .removeClass('text-success text-danger')
                    .addClass(response.value_percentage_change >= 0 ? 'text-success' : 'text-danger');
            },
            error: function (error) {
                console.log('Error fetching warehouse data:', error);
            }
        });
    }

    // Tải dữ liệu ngay khi trang được tải
    fetchWarehouseData();
});
