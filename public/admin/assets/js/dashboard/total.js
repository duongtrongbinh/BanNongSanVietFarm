$(document).ready(function () {
    function fetchRevenueData(filter = 'day') {
        $.ajax({
            url: '/api/orders/total',
            type: 'GET',
            data: { filter: filter },
            success: function (response) {
                console.log('Revenue API Response:', response);

                // Xác định dữ liệu cho ngày hôm nay
                const todayAmount = response.total_today !== undefined ? parseFloat(response.total_today) : 0;
                const todayPercentageChange = response.percentage_change_today !== undefined ? parseFloat(response.percentage_change_today) : 0;

                // Xác định dữ liệu cho tháng này
                const monthAmount = response.total_this_month !== undefined ? parseFloat(response.total_this_month) : 0;
                const monthPercentageChange = response.percentage_change_month !== undefined ? parseFloat(response.percentage_change_month) : 0;

                // Xác định dữ liệu cho năm nay
                const yearAmount = response.total_this_year !== undefined ? parseFloat(response.total_this_year) : 0;
                const yearPercentageChange = response.percentage_change_year !== undefined ? parseFloat(response.percentage_change_year) : 0;

                // Xác định dữ liệu dựa trên bộ lọc
                let totalAmount = 0, percentageChange = 0;

                if (filter === 'day') {
                    totalAmount = todayAmount;
                    percentageChange = todayPercentageChange;
                } else if (filter === 'month') {
                    totalAmount = monthAmount;
                    percentageChange = monthPercentageChange;
                } else {
                    totalAmount = yearAmount;
                    percentageChange = yearPercentageChange;
                }

                $('#revenue-filter-title').text(`| ${filter === 'day' ? 'Ngày hôm nay' : filter === 'month' ? 'Tháng này' : 'Năm nay'}`);

                // Cập nhật nội dung cho thẻ h6 với lớp revenue-amount
                $('.revenue-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

                $('#revenue-increase').text(`${Math.abs(percentageChange).toLocaleString('vi-VN', { minimumFractionDigits: 0, maximumFractionDigits: 1 })}%`)
                    .removeClass('text-success text-danger')
                    .addClass(percentageChange >= 0 ? 'text-success' : 'text-danger');

                $('#revenue-increase').next('.text-muted').text(percentageChange >= 0 ? 'tăng' : 'giảm');
            },
            error: function (error) {
                console.log('Error fetching revenue data:', error);
            }
        });
    }

    fetchRevenueData();

    $('.revenue-filter .dropdown-menu a').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        console.log('Selected filter:', filter);
        fetchRevenueData(filter);
    });
});
