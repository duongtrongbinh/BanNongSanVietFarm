$(document).ready(function () {
    function fetchOrderData() {
        $.ajax({
            url: '/api/orders', // Đảm bảo URL chính xác
            type: 'GET',
            success: function (response) {
                console.log('Order API Response:', response);

                let ordersToday = response.orders_today || 0;
                let percentageChangeToday = response.percentage_change_today || 0;
                let changeText = percentageChangeToday >= 0 ? 'tăng' : 'giảm';
                let changeClass = percentageChangeToday >= 0 ? 'text-success' : 'text-danger';

                $('#sales-filter-title').text('| Hôm nay');
                $('#sales-order-count').text(ordersToday.toLocaleString('vi-VN'));
                $('#sales-order-increase').text(`${Math.abs(percentageChangeToday).toLocaleString('vi-VN', { minimumFractionDigits: 0, maximumFractionDigits: 1 })}%`)
                    .removeClass('text-success text-danger')
                    .addClass(changeClass);
                $('#sales-order-increase').next('.text-muted').text(changeText);

                // Loại bỏ xử lý trạng thái đơn hàng
                $('.order-status-info').html('');
            },
            error: function (error) {
                console.log('Order Error:', error);
            }
        });
    }

    // Load initial data for today
    fetchOrderData();
});
