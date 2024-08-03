$(document).ready(function () {
    function fetchUserData(filter = 'day') {
        $.ajax({
            url: '/api/users', // Đảm bảo URL chính xác
            type: 'GET',
            data: { filter: filter },
            success: function (response) {
                console.log('User API Response:', response);

                let totalUsers = 0, increaseDecrease = 0, percentageChange = 0, changeText = '';

                if (filter === 'day') {
                    totalUsers = response.users_today || 0;
                    increaseDecrease = response.increase_decrease_yesterday || 0;
                } else if (filter === 'month') {
                    totalUsers = response.users_this_month || 0;
                    increaseDecrease = response.increase_decrease_last_month || 0;
                } else {
                    totalUsers = response.users_this_year || 0;
                    increaseDecrease = response.increase_decrease_last_year || 0;
                }

                percentageChange = totalUsers > 0 ? ((increaseDecrease / totalUsers) * 100) : 0;

                changeText = increaseDecrease >= 0 ? 'tăng' : 'giảm';
                const changeClass = increaseDecrease >= 0 ? 'text-success' : 'text-danger';

                $('#customers-filter-title').text(`| ${filter === 'day' ? 'Hôm nay' : filter === 'month' ? 'Tháng này' : 'Năm nay'}`);
                $('#customers-count').text(totalUsers.toLocaleString('vi-VN'));
                $('#customers-increase').text(`${Math.abs(percentageChange).toLocaleString('vi-VN', { minimumFractionDigits: 0, maximumFractionDigits: 1 })}%`).removeClass('text-success text-danger').addClass(changeClass);
                $('#customers-increase').next('.text-muted').text(changeText);
            },
            error: function (error) {
                console.log('User Error:', error);
            }
        });
    }

    // Load initial data with 'day' filter
    fetchUserData('day');

    // Handle filter selection
    $('.customers-filter .dropdown-menu a').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        console.log('Selected filter:', filter);
        fetchUserData(filter);
    });
});
