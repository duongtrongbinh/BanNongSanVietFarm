@extends('admin.layout.master')
@section('content')
    <style>
        .stat-box {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-box .card-icon {
            font-size: 30px;
            margin-bottom: 15px;
            color: #4154f1;
        }

        .stat-box h6 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .stat-box .percentage-change {
            font-size: 16px;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            font-size: 14px;
        }

        /* Bộ lọc */
        .filter-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            background-color: #ffffff;
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .filter-container select {
            width: auto;
            padding: 5px;
            margin-right: 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .filter-container button {
            padding: 5px 15px;
            background-color: #4154f1;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .filter-container button:hover {
            background-color: #293b99;
        }

        /* Biểu đồ */
        #customerChartContainer {
            margin-top: 30px;
        }

        #customerChart {
            height: 300px;
        }
    </style>

    <div class="container mt-5">
        <!-- Bộ lọc ngày -->
        <div class="filter-container mb-4">
            <label for="filter-period">Chọn khoảng thời gian:</label>
            <select id="filter-period" class="form-control form-control-sm">
                <option value="today">Hôm nay</option>
                <option value="this_month">Tháng này</option>
                <option value="this_year">Năm nay</option>
            </select>
            <button id="filter-button">Lọc</button>
        </div>

        <div class="row">
            <!-- Khách hàng mới -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <h6 id="new-customers">20</h6>
                    <span id="new-customers-change" class="percentage-change text-success">30% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Khách hàng mới</span>
                </div>
            </div>
            <!-- Khách hàng quay lại -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <h6 id="returning-customers">50</h6>
                    <span id="returning-customers-change" class="percentage-change text-success">10% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Khách hàng quay lại</span>
                </div>
            </div>
            <!-- Khách hàng tiềm năng -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <h6 id="potential-customers">30</h6>
                    <span id="potential-customers-change" class="percentage-change text-danger">5% giảm</span>
                    <span class="text-muted small pt-2 ps-1">Khách hàng tiềm năng</span>
                </div>
            </div>
            <!-- Khách hàng không hoạt động -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-dash"></i>
                    </div>
                    <h6 id="inactive-customers">10</h6>
                    <span id="inactive-customers-change" class="percentage-change text-danger">20% giảm</span>
                    <span class="text-muted small pt-2 ps-1">Khách hàng không hoạt động</span>
                </div>
            </div>
        </div>

        <!-- Biểu đồ thống kê khách hàng -->
        <div id="customerChartContainer" class="row">
            <div class="col-12">
                <canvas id="customerChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('customerChart').getContext('2d');
            let customerChart;

            function renderCustomerChart(data) {
                if (customerChart) {
                    customerChart.destroy();  // Xóa biểu đồ cũ trước khi vẽ biểu đồ mới
                }

                customerChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Khách hàng mới', 'Khách hàng quay lại', 'Khách hàng tiềm năng', 'Khách hàng không hoạt động'],
                        datasets: [{
                            label: 'Số lượng khách hàng',
                            data: data,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(255, 99, 132, 0.7)'
                            ],
                            borderColor: [
                                '#4bc0c0', '#36a2eb', '#ffce56', '#ff6384'
                            ],
                            borderWidth: 2,
                            hoverBackgroundColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            hoverBorderColor: [
                                '#249fa1', '#2b89d0', '#d4a319', '#cc0b29'
                            ]
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(200, 200, 200, 0.2)'
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    },
                                    color: '#333'
                                }
                            },
                            x: {
                                grid: {
                                    color: 'rgba(200, 200, 200, 0.2)'
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    },
                                    color: '#333'
                                }
                            }
                        },
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                titleFont: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 14
                                },
                                cornerRadius: 4,
                                padding: 10,
                                displayColors: false
                            }
                        },
                        layout: {
                            padding: {
                                left: 20,
                                right: 20,
                                top: 20,
                                bottom: 20
                            }
                        }
                    }
                });
            }

            function updateDataBasedOnFilter(period) {
                const apiUrl = `http://127.0.0.1:8000/api/report/users?period=${period}`;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        let periodData;
                        if (period === 'today') {
                            periodData = data.today;
                        } else if (period === 'this_month') {
                            periodData = data.this_month;
                        } else if (period === 'this_year') {
                            periodData = data.this_year;
                        }

                        const userData = {
                            newCustomers: periodData['Khách hàng mới'].count,
                            returningCustomers: periodData['Khách hàng quay lại'].count,
                            potentialCustomers: periodData['Khách hàng tiềm năng'].count,
                            inactiveCustomers: periodData['Khách hàng không hoạt động'].count,
                        };

                        // Cập nhật các khối thống kê
                        $('#new-customers').text(userData.newCustomers);
                        $('#new-customers-change').text(`${periodData['Khách hàng mới'].percentage_change}% ${periodData['Khách hàng mới'].change}`);

                        $('#returning-customers').text(userData.returningCustomers);
                        $('#returning-customers-change').text(`${periodData['Khách hàng quay lại'].percentage_change}% ${periodData['Khách hàng quay lại'].change}`);

                        $('#potential-customers').text(userData.potentialCustomers);
                        $('#potential-customers-change').text(`${periodData['Khách hàng tiềm năng'].percentage_change}% ${periodData['Khách hàng tiềm năng'].change}`);

                        $('#inactive-customers').text(userData.inactiveCustomers);
                        $('#inactive-customers-change').text(`${periodData['Khách hàng không hoạt động'].percentage_change}% ${periodData['Khách hàng không hoạt động'].change}`);

                        // Vẽ lại biểu đồ với dữ liệu mới
                        renderCustomerChart([
                            userData.newCustomers,
                            userData.returningCustomers,
                            userData.potentialCustomers,
                            userData.inactiveCustomers
                        ]);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Lắng nghe sự kiện nhấp vào nút Lọc
            $('#filter-button').on('click', function () {
                const period = $('#filter-period').val();
                updateDataBasedOnFilter(period);
            });

            // Khởi tạo dữ liệu ban đầu
            updateDataBasedOnFilter('today');
        });
    </script>
@endsection
