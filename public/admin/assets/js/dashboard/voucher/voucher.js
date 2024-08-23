$(document).ready(function () {
    function fetchVoucherData(filter = 'day') {
        $.ajax({
            url: '/api/vouchers', // Đảm bảo URL chính xác
            type: 'GET',
            data: { filter: filter },
            success: function (response) {
                console.log('Vouchers API Response:', response);

                let totalVouchers = 0, increaseDecrease = 0, percentageChange = 0, changeText = '';

                if (filter === 'day') {
                    totalVouchers = response.total_today || 0;
                    increaseDecrease = response.increase_decrease_yesterday || 0;
                } else if (filter === 'month') {
                    totalVouchers = response.total_this_month || 0;
                    increaseDecrease = response.increase_decrease_last_month || 0;
                } else {
                    totalVouchers = response.total_this_year || 0;
                    increaseDecrease = response.increase_decrease_last_year || 0;
                }

                percentageChange = totalVouchers > 0 ? ((increaseDecrease / totalVouchers) * 100) : 0;

                changeText = increaseDecrease >= 0 ? 'tăng' : 'giảm';
                const changeClass = increaseDecrease >= 0 ? 'text-success' : 'text-danger';

                $('#promotion-filter-title').text(`| ${filter === 'day' ? 'Hôm nay' : filter === 'month' ? 'Tháng này' : 'Năm nay'}`);
                $('#promotion-count').text(totalVouchers.toLocaleString('vi-VN'));
                $('#promotion-increase').text(`${Math.abs(percentageChange).toLocaleString('vi-VN', { minimumFractionDigits: 0, maximumFractionDigits: 1 })}%`).removeClass('text-success text-danger').addClass(changeClass);
                $('#promotion-increase').next('.text-muted').text(changeText);
            },
            error: function (error) {
                console.log('Voucher Error:', error);
            }
        });
    }

    function fetchVoucherChartData() {
        $.ajax({
            url: '/api/vouchers', // Đảm bảo URL chính xác
            type: 'GET',
            success: function (response) {
                console.log('Voucher Chart Data:', response.voucher_usage_by_month);

                // Xử lý dữ liệu cho biểu đồ
                const months = Object.keys(response.voucher_usage_by_month);
                const usageData = Object.values(response.voucher_usage_by_month);

                // Cập nhật biểu đồ
                const chart = echarts.init(document.querySelector("#barChart"));
                chart.setOption({
                    xAxis: {
                        type: 'category',
                        data: months.reverse() // Hiển thị theo thứ tự từ cũ đến mới
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [{
                        data: usageData.reverse(), // Hiển thị theo thứ tự từ cũ đến mới
                        type: 'bar'
                    }]
                });
            },
            error: function (error) {
                console.log('Voucher Chart Error:', error);
            }
        });
    }

    // Load initial data with 'day' filter
    fetchVoucherData('day');
    fetchVoucherChartData();

    // Handle filter selection
    $('.promotion-filter .dropdown-menu a').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        console.log('Selected filter:', filter);
        fetchVoucherData(filter);
    });
});


