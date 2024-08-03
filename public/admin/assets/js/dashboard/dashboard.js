$(document).ready(function () {
    function fetchData(filter = 'day') {
        $.when(
            $.ajax({
                url: '/api/orders',
                type: 'GET',
                data: { filter: filter }
            }),
            $.ajax({
                url: '/api/orders/total',
                type: 'GET',
                data: { filter: filter }
            }),
            $.ajax({
                url: '/api/users',
                type: 'GET',
                data: { filter: filter }
            })
        ).done(function (ordersResponse, revenueResponse, usersResponse) {
            const ordersData = ordersResponse[0];
            const revenueData = revenueResponse[0];
            const usersData = usersResponse[0];

            updateChart(ordersData, revenueData, usersData, filter);
        });
    }
    function updateChart(ordersData, revenueData, usersData, filter) {
        const salesData = [
            ordersData.orders_today.toLocaleString('vi-VN'),
            ordersData.orders_this_month.toLocaleString('vi-VN'),
            ordersData.orders_this_year.toLocaleString('vi-VN')
        ];
        const revenueDataPoints = [
            revenueData.total_today.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }),
            revenueData.total_this_month.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }),
            revenueData.total_this_year.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })
        ];
        const customersData = [
            usersData.users_today.toLocaleString('vi-VN'),
            usersData.users_this_month.toLocaleString('vi-VN'),
            usersData.users_this_year.toLocaleString('vi-VN')
        ];

        const xCategories = getXaxisCategories(filter);

        new ApexCharts(document.querySelector("#reportsChart"), {
            series: [{
                name: 'Đơn hàng',
                data: salesData,
            }, {
                name: 'Doanh thu',
                data: revenueDataPoints
            }, {
                name: 'Khách hàng',
                data: customersData
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            markers: {
                size: 4
            },
            colors: ['#4154f1', '#2eca6a', '#ff771d'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: xCategories
            },
            tooltip: {
                x: {
                    format: filter === 'day' ? 'HH:mm' : (filter === 'month' ? 'dd/MM' : 'MM/yyyy')
                },
            }
        }).render();
    }

    function getXaxisCategories(filter) {
        if (filter === 'day') {
            return ["00:00", "04:00", "08:00", "12:00", "16:00", "20:00"];
        } else if (filter === 'month') {
            return Array.from({ length: 31 }, (_, i) => `Day ${i + 1}`);
        } else {
            return ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        }
    }

    fetchData();

    $('.filter .dropdown-menu a').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        fetchData(filter);
    });
});
