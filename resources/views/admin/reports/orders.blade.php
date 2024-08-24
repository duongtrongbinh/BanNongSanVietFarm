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
        #orderChartContainer {
            margin-top: 30px;
        }

        #orderChart {
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
            <!-- Đang chờ xử lý -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h6 id="order-pending">0</h6>
                    <span id="pending-change" class="percentage-change text-success">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Đang chờ xử lý</span>
                </div>
            </div>
            <!-- Đang xử lý -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <h6 id="order-processing">0</h6>
                    <span id="processing-change" class="percentage-change text-success">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Đang xử lý</span>
                </div>
            </div>
            <!-- Vận chuyển -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h6 id="order-shipping">0</h6>
                    <span id="shipping-change" class="percentage-change text-danger">0% giảm</span>
                    <span class="text-muted small pt-2 ps-1">Vận chuyển</span>
                </div>
            </div>
            <!-- Giao hàng -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-box-arrow-down"></i>
                    </div>
                    <h6 id="order-delivered">0</h6>
                    <span id="delivered-change" class="percentage-change text-danger">0% giảm</span>
                    <span class="text-muted small pt-2 ps-1">Giao hàng</span>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Đã nhận hàng -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h6 id="order-received">0</h6>
                    <span id="received-change" class="percentage-change text-success">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Đã nhận hàng</span>
                </div>
            </div>
            <!-- Hoàn thành -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-award"></i>
                    </div>
                    <h6 id="order-completed">0</h6>
                    <span id="completed-change" class="percentage-change text-success">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Hoàn thành</span>
                </div>
            </div>
            <!-- Đã hủy -->
            <div class="col-md-3 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <h6 id="order-cancelled">0</h6>
                    <span id="cancelled-change" class="percentage-change text-danger">0% giảm</span>
                    <span class="text-muted small pt-2 ps-1">Đã hủy</span>
                </div>
            </div>
        </div>

        <!-- Biểu đồ thống kê đơn hàng -->
        <div id="orderChartContainer" class="row">
            <div class="col-12">
                <canvas id="orderChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('orderChart').getContext('2d');
            let orderChart;

            function renderOrderChart(data) {
                if (orderChart) {
                    orderChart.destroy();  // Xóa biểu đồ cũ trước khi vẽ biểu đồ mới
                }

                orderChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Đang chờ xử lý', 'Đang xử lý', 'Vận chuyển', 'Giao hàng', 'Đã nhận hàng', 'Hoàn thành', 'Đã hủy'],
                        datasets: [{
                            label: 'Số lượng đơn hàng',
                            data: data,
                            backgroundColor: [
                                'rgba(255, 204, 0, 0.7)',
                                'rgba(255, 153, 51, 0.7)',
                                'rgba(51, 204, 255, 0.7)',
                                'rgba(102, 255, 102, 0.7)',
                                'rgba(255, 102, 102, 0.7)',
                                'rgba(51, 153, 102, 0.7)',
                                'rgba(255, 51, 51, 0.7)'
                            ],
                            borderColor: [
                                '#ffcc00', '#ff9933', '#33ccff', '#66ff66', '#ff6666', '#339966', '#ff3333'
                            ],
                            borderWidth: 2,
                            hoverBackgroundColor: [
                                'rgba(255, 204, 0, 1)',
                                'rgba(255, 153, 51, 1)',
                                'rgba(51, 204, 255, 1)',
                                'rgba(102, 255, 102, 1)',
                                'rgba(255, 102, 102, 1)',
                                'rgba(51, 153, 102, 1)',
                                'rgba(255, 51, 51, 1)'
                            ],
                            hoverBorderColor: [
                                '#e6b800', '#e68a00', '#29a3a3', '#29a329', '#cc0000', '#26734d', '#cc0000'
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
                // Gọi API để lấy dữ liệu
                fetch(`http://127.0.0.1:8000/api/report/orders?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        // Cập nhật các khối thống kê
                        const orderData = data[period];

                        $('#order-pending').text(orderData['Đang chờ xử lý'].count);
                        $('#pending-change').text(`${orderData['Đang chờ xử lý'].percentage_change}% ${orderData['Đang chờ xử lý'].change}`);

                        $('#order-processing').text(orderData['Đang xử lý'].count);
                        $('#processing-change').text(`${orderData['Đang xử lý'].percentage_change}% ${orderData['Đang xử lý'].change}`);

                        $('#order-shipping').text(orderData['Vận chuyển'].count);
                        $('#shipping-change').text(`${orderData['Vận chuyển'].percentage_change}% ${orderData['Vận chuyển'].change}`);

                        $('#order-delivered').text(orderData['Giao hàng'].count);
                        $('#delivered-change').text(`${orderData['Giao hàng'].percentage_change}% ${orderData['Giao hàng'].change}`);

                        $('#order-received').text(orderData['Đã nhận hàng'].count);
                        $('#received-change').text(`${orderData['Đã nhận hàng'].percentage_change}% ${orderData['Đã nhận hàng'].change}`);

                        $('#order-completed').text(orderData['Hoàn thành'].count);
                        $('#completed-change').text(`${orderData['Hoàn thành'].percentage_change}% ${orderData['Hoàn thành'].change}`);

                        $('#order-cancelled').text(orderData['Đã hủy'].count);
                        $('#cancelled-change').text(`${orderData['Đã hủy'].percentage_change}% ${orderData['Đã hủy'].change}`);

                        // Vẽ lại biểu đồ với dữ liệu mới
                        renderOrderChart([
                            orderData['Đang chờ xử lý'].count,
                            orderData['Đang xử lý'].count,
                            orderData['Vận chuyển'].count,
                            orderData['Giao hàng'].count,
                            orderData['Đã nhận hàng'].count,
                            orderData['Hoàn thành'].count,
                            orderData['Đã hủy'].count
                        ]);
                    })
                    .catch(error => console.error('Error:', error));
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
