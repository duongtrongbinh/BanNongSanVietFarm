$(document).ready(function () {
    function fetchData() {
        $.when(
            $.ajax({
                url: '/api/orders',
                type: 'GET',
                data: { filter: 'day' }
            }),
            $.ajax({
                url: '/api/orders/total',
                type: 'GET',
                data: { filter: 'day' }
            }),
            $.ajax({
                url: '/api/users',
                type: 'GET',
                data: { filter: 'day' }
            })
        ).done(function (ordersResponse, revenueResponse, usersResponse) {
            const ordersData = ordersResponse[0];
            const revenueData = revenueResponse[0];
            const usersData = usersResponse[0];

            updateChart(ordersData, revenueData, usersData);
        });
    }

    function updateChart(ordersData, revenueData, usersData) {
        const salesData = [
            parseInt(ordersData.orders_today).toLocaleString('vi-VN')
        ];
        const revenueDataPoints = [
            parseFloat(revenueData.total_today).toLocaleString('vi-VN', { style: 'currency', currency: 'VND', minimumFractionDigits: 0, maximumFractionDigits: 0 })
        ];
        const customersData = [
            parseInt(usersData.users_today).toLocaleString('vi-VN')
        ];

        const xCategories = ["00:00", "04:00", "08:00", "12:00", "16:00", "20:00"];

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
                    format: 'HH:mm'
                },
            }
        }).render();
    }

    fetchData();
});
