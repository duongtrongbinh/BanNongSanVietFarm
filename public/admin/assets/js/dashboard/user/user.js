$(document).ready(function () {
    function fetchUserData() {
        $.ajax({
            url: '/api/users', // Đảm bảo URL chính xác
            type: 'GET',
            success: function (response) {
                console.log('User API Response:', response);

                let totalUsersToday = response.users_today || 0;
                let increaseDecreaseYesterday = response.increase_decrease_yesterday || 0;
                let percentageChangeYesterday = response.percentage_change_yesterday || 0;
                let changeText = increaseDecreaseYesterday >= 0 ? 'tăng' : 'giảm';
                const changeClass = increaseDecreaseYesterday >= 0 ? 'text-success' : 'text-danger';

                $('#customers-filter-title').text('| Hôm nay');
                $('#customers-count').text(totalUsersToday.toLocaleString('vi-VN'));
                $('#customers-increase').text(`${Math.abs(percentageChangeYesterday).toLocaleString('vi-VN', { minimumFractionDigits: 0, maximumFractionDigits: 1 })}%`)
                    .removeClass('text-success text-danger')
                    .addClass(changeClass);
                $('#customers-increase').next('.text-muted').text(changeText);
            },
            error: function (error) {
                console.log('User Error:', error);
            }
        });
    }

    // Load initial data for today
    fetchUserData();
});
