$(document).ready(function () {
    function fetchRevenueData() {
        $.ajax({
            url: '/api/orders/total', // Đảm bảo URL chính xác
            type: 'GET',
            success: function (response) {
                console.log('Revenue API Response:', response);

                // Xác định dữ liệu cho ngày hôm nay
                const todayAmount = response.total_today !== undefined ? parseFloat(response.total_today) : 0;
                const todayPercentageChange = response.percentage_change_today !== undefined ? parseFloat(response.percentage_change_today) : 0;

                // Cập nhật nội dung cho thẻ h6 với lớp revenue-amount
                $('.revenue-amount').text(todayAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

                $('#revenue-increase').text(`${Math.abs(todayPercentageChange).toLocaleString('vi-VN', { minimumFractionDigits: 0, maximumFractionDigits: 1 })}%`)
                    .removeClass('text-success text-danger')
                    .addClass(todayPercentageChange >= 0 ? 'text-success' : 'text-danger');

                $('#revenue-increase').next('.text-muted').text(todayPercentageChange >= 0 ? 'tăng' : 'giảm');

                // Cập nhật tiêu đề
                $('#revenue-filter-title').text('| Ngày hôm nay');
            },
            error: function (error) {
                console.log('Error fetching revenue data:', error);
            }
        });
    }

    // Load initial data for today
    fetchRevenueData();
});
