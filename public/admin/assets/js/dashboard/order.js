$(document).ready(function () {
    function fetchOrderData(filter = 'day', status = null) {
        const requestData = { filter: filter };
        if (status !== null) {
            requestData.status = status;
        }

        $.ajax({
            url: '/api/orders', // Đảm bảo URL chính xác
            type: 'GET',
            data: requestData,
            success: function (response) {
                console.log('Order API Response:', response);

                let ordersCurrent = 0, percentageChange = 0, changeText = '';

                if (filter === 'day') {
                    ordersCurrent = response.orders_today || 0;
                    percentageChange = response.percentage_change_today || 0;
                } else if (filter === 'month') {
                    ordersCurrent = response.orders_this_month || 0;
                    percentageChange = response.percentage_change_month || 0;
                } else {
                    ordersCurrent = response.orders_this_year || 0;
                    percentageChange = response.percentage_change_last_year || 0;
                }

                changeText = percentageChange >= 0 ? 'tăng' : 'giảm';
                const changeClass = percentageChange >= 0 ? 'text-success' : 'text-danger';

                $('#sales-filter-title').text(`| ${filter === 'day' ? 'Hôm nay' : filter === 'month' ? 'Tháng này' : 'Năm nay'}`);
                $('#sales-order-count').text(ordersCurrent.toLocaleString('vi-VN'));
                $('#sales-order-increase').text(`${Math.abs(percentageChange).toLocaleString('vi-VN', { minimumFractionDigits: 0, maximumFractionDigits: 1 })}%`).removeClass('text-success text-danger').addClass(changeClass);
                $('#sales-order-increase').next('.text-muted').text(changeText);

                // Cập nhật số lượng đơn hàng theo trạng thái
                const statuses = ['pending', 'processing', 'shipping', 'delivered', 'received', 'completed', 'canceled'];
                statuses.forEach((status, index) => {
                    const statusData = response.status_statistics.find(s => s.status === index) || {};
                    $(`#orders-status-${status}`).text((statusData.count || 0).toLocaleString('vi-VN'));
                });

                // Hiển thị thông tin trạng thái đơn hàng trong tiêu đề
                if (status !== null) {
                    let statusInfo = ` Trạng thái: ${getStatusText(status)}: ${ordersCurrent}`;
                    $('.order-status-info').html(statusInfo);
                } else {
                    $('.order-status-info').html('');
                }
            },
            error: function (error) {
                console.log('Order Error:', error);
            }
        });
    }

    function getStatusText(status) {
        const statusMap = {
            0: 'Đang chờ xử lý',
            1: 'Đang xử lý',
            2: 'Vận chuyển',
            3: 'Giao hàng',
            4: 'Đã nhận hàng',
            5: 'Hoàn thành',
            6: 'Đã hủy',
        };
        return statusMap[status];
    }

    // Load initial data with 'day' filter
    fetchOrderData('day');

    // Handle filter selection
    $('.sales-filter .dropdown-menu a[data-filter]').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        console.log('Selected filter:', filter);
        fetchOrderData(filter);
    });

    // Handle status selection
    $('.sales-filter .dropdown-menu a[data-status]').on('click', function (e) {
        e.preventDefault();
        const status = $(this).data('status');
        console.log('Selected status:', status);
        fetchOrderData(null, status);
    });
});
