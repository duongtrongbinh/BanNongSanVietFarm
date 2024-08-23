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

        /* Biểu đồ */
        #revenueChartContainer {
            margin-top: 30px;
        }

        #revenueChart {
            height: 300px;
        }
    </style>

    <div class="container mt-5">
        <div class="row">
            <!-- Doanh thu hôm nay -->
            <div class="col-md-4 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <h6 id="revenue-today">0 VND</h6>
                    <span id="revenue-today-change" class="percentage-change text-success">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Doanh thu hôm nay</span>
                </div>
            </div>
            <!-- Doanh thu tháng này -->
            <div class="col-md-4 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <h6 id="revenue-this-month">0 VND</h6>
                    <span id="revenue-this-month-change" class="percentage-change text-success">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Doanh thu tháng này</span>
                </div>
            </div>
            <!-- Doanh thu năm nay -->
            <div class="col-md-4 text-center">
                <div class="stat-box">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h6 id="revenue-this-year">0 VND</h6>
                    <span id="revenue-this-year-change" class="percentage-change text-success">0% tăng</span>
                    <span class="text-muted small pt-2 ps-1">Doanh thu năm nay</span>
                </div>
            </div>
        </div>

        <!-- Biểu đồ thống kê doanh thu -->
        <div id="revenueChartContainer" class="row">
            <div class="col-12">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            let revenueChart;

            function renderRevenueChart(data) {
                if (revenueChart) {
                    revenueChart.destroy();  // Xóa biểu đồ cũ trước khi vẽ biểu đồ mới
                }

                revenueChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Hôm nay', 'Tháng này', 'Năm nay'],
                        datasets: [{
                            label: 'Doanh thu (VND)',
                            data: data,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)'
                            ],
                            borderColor: [
                                '#4bc0c0', '#36a2eb', '#ffce56'
                            ],
                            borderWidth: 2,
                            hoverBackgroundColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
                            hoverBorderColor: [
                                '#249fa1', '#2b89d0', '#d4a319'
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

            function updateRevenueDisplay(data) {
                // Cập nhật các khối thống kê
                $('#revenue-today').text(data.today.revenue + ' VND');
                $('#revenue-today-change').text(data.today.percentage_change + '% ' + data.today.change);

                $('#revenue-this-month').text(data.this_month.revenue + ' VND');
                $('#revenue-this-month-change').text(data.this_month.percentage_change + '% ' + data.this_month.change);

                $('#revenue-this-year').text(data.this_year.revenue + ' VND');
                $('#revenue-this-year-change').text(data.this_year.percentage_change + '% ' + data.this_year.change);

                // Cập nhật biểu đồ
                renderRevenueChart([data.today.revenue, data.this_month.revenue, data.this_year.revenue]);
            }

            // Lấy dữ liệu từ API
            fetch('http://127.0.0.1:8000/api/report/revenue')
                .then(response => response.json())
                .then(data => {
                    updateRevenueDisplay(data);
                })
                .catch(error => console.error('Error fetching revenue data:', error));
        });
    </script>
@endsection
