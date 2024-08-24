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
            <!-- Số lượng đơn hàng sử dụng voucher -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-gift"></i>
                    </div>
                    <h6 id="voucher-used">0</h6>
                    <span id="voucher-used-change" class="percentage-change text-success">0%</span>
                    <span class="text-muted small pt-2 ps-1">Đơn hàng sử dụng voucher</span>
                </div>
            </div>
            <!-- Số lượng voucher đang phát hành -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h6 id="voucher-issued">0</h6>
                    <span id="voucher-issued-change" class="percentage-change text-success">0%</span>
                    <span class="text-muted small pt-2 ps-1">Voucher phát hành</span>
                </div>
            </div>
            <!-- Số lượng voucher đang hoạt động -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h6 id="voucher-active">0</h6>
                    <span id="voucher-active-change" class="percentage-change text-success">0%</span>
                    <span class="text-muted small pt-2 ps-1">Voucher hoạt động</span>
                </div>
            </div>
            <!-- Số lượng voucher không hoạt động -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <h6 id="voucher-inactive">0</h6>
                    <span id="voucher-inactive-change" class="percentage-change text-danger">0%</span>
                    <span class="text-muted small pt-2 ps-1">Voucher không hoạt động</span>
                </div>
            </div>
        </div>

        <!-- Biểu đồ thống kê voucher -->
        <div id="voucherChartContainer" class="row">
            <div class="col-12">
                <canvas id="voucherChart"></canvas>
            </div>
        </div>
    </div>


    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('voucherChart').getContext('2d');
            let voucherChart;

            function renderVoucherChart(data) {
                console.log(data)
                if (voucherChart) {
                    voucherChart.destroy();  // Xóa biểu đồ cũ trước khi vẽ biểu đồ mới
                }

                voucherChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Đơn hàng sử dụng voucher', 'Voucher phát hành', 'Voucher hoạt động', 'Voucher không hoạt động'],
                        datasets: [{
                            label: 'Số lượng',
                            data: data,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(60, 179, 113, 0.7)',
                                'rgba(255, 99, 132, 0.7)'
                            ],
                            borderColor: [
                                '#4bc0c0', '#36a2eb', '#3cb371', '#ff6384'
                            ],
                            borderWidth: 2,
                            hoverBackgroundColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(60, 179, 113, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            hoverBorderColor: [
                                '#249fa1', '#2b89d0', '#2d9d6d', '#cc0b29'
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
                const apiUrl = `/api/report/vouchers?period=${period}`;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        let periodData = data[period];

                        const voucherData = {
                            usedOrders: periodData['Số lượng đơn hàng sử dụng voucher'],
                            issuedVouchers: periodData['Số lượng voucher đang phát hành'],
                            activeVouchers: periodData['Số lượng voucher đang hoạt động'],
                            inactiveVouchers: periodData['Số lượng voucher không hoạt động'],
                        };


                        // Cập nhật các khối thống kê
                        $('#voucher-used').text(voucherData.usedOrders.count);
                        $('#voucher-used-change').text(`${periodData['Số lượng đơn hàng sử dụng voucher'].percentage_change}%`);

                        $('#voucher-issued').text(voucherData.issuedVouchers.count);
                        $('#voucher-issued-change').text(`${periodData['Số lượng voucher đang phát hành'].percentage_change}%`);

                        $('#voucher-active').text(voucherData.activeVouchers.count);
                        $('#voucher-active-change').text(`${periodData['Số lượng voucher đang hoạt động'].percentage_change}%`);

                        $('#voucher-inactive').text(voucherData.inactiveVouchers.count);
                        $('#voucher-inactive-change').text(`${periodData['Số lượng voucher không hoạt động'].percentage_change}%`);

                        // Vẽ lại biểu đồ với dữ liệu mới
                        renderVoucherChart([
                            voucherData.usedOrders.count,
                            voucherData.issuedVouchers.count,
                            voucherData.activeVouchers.count,
                            voucherData.inactiveVouchers.count
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
