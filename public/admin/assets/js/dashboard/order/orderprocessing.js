$(document).ready(function () {
    function fetchProcessingOrderData(filter = 'day') {
        const requestData = { filter: filter };

        $.ajax({
            url: '/api/orders/processing', // Sử dụng URL từ route đã đặt tên
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

                $('#revenue-filter-title-1').text(`| ${filter === 'day' ? 'Hôm nay' : filter === 'month' ? 'Tháng này' : 'Năm nay'}`);
                $('#revenue-amount-1').text(ordersCurrent.toLocaleString('vi-VN'));
                $('#revenue-increase-1').text(`${Math.abs(percentageChange).toLocaleString('vi-VN', { minimumFractionDigits: 0, maximumFractionDigits: 1 })}%`).removeClass('text-success text-danger').addClass(changeClass);
                $('#revenue-increase-1').next('.text-muted').text(changeText);
            },
            error: function (error) {
                console.log('Order Error:', error);
            }
        });
    }

    // Load initial data with 'day' filter
    fetchProcessingOrderData('day');

    // Handle filter selection
    $('.revenue-filter .dropdown-menu a[data-filter]').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        console.log('Selected filter:', filter);
        fetchProcessingOrderData(filter);
    });
});
