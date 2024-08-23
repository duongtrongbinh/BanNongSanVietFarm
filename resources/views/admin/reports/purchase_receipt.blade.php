@extends('admin.layout.master')

@section('content')
    <style>
        .inventory-container {
            margin-top: 30px;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .inventory-table th, .inventory-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .inventory-table th {
            background-color: #f8f9fa;
            color: #333;
        }

        .inventory-table tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-edit, .btn-delete {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-edit {
            background-color: #4caf50;
            color: white;
        }

        .btn-edit:hover {
            background-color: #45a049;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn-delete:hover {
            background-color: #e53935;
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
            gap: 10px; /* Khoảng cách giữa các phần tử */
        }

        .filter-container select {
            width: auto;
            padding: 5px;
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
        #inventoryChartContainer {
            margin-top: 30px;
        }

        #inventoryChart {
            height: 300px;
        }
    </style>

    <div class="container inventory-container">
        <!-- Bộ lọc năm -->
        <div class="filter-container mb-4">
            <form method="GET" action="{{ route('report.purchase_receipt') }}" class="d-flex align-items-center">
                <label for="year" class="mr-2">Chọn năm:</label>
                <select id="year" name="year" class="form-control form-control-sm mr-2">
                    @for ($y = now()->year; $y >= now()->year - 10; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" id="filter-button" class="btn btn-primary btn-sm">Lọc</button>
            </form>
        </div>

        <!-- Bảng thông tin chi tiết nhập kho -->
        <table class="inventory-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Mã nhập hàng</th>
                <th>Nhà cung cấp</th>
                <th>Sản phẩm</th>
                <th>Tổng sản phẩm nhập</th>
                <th>Tổng sản phẩm bán</th>
                <th>Tồn kho</th>
                <th>Tổng tiền</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($purchaseReceipts as $key => $receipt)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $receipt->reference_code }}</td>
                    <td>{{ $receipt->supplier->name }}</td>
                    <td>{{$receipt->product->name}}
                    </td>
                    <td>{{ $receipt->total_imported }}</td>
                    <td>{{ $receipt->total_sold ?? 0 }}</td>
                    <td>{{ $receipt->total_in_stock }}</td>
                    <td>{{ number_format($receipt->total_cost) }} VND</td>
                </tr>
            @endforeach
            </tbody>

        </table>

        <!-- Phân trang -->
        <div class="pagination mt-4">
            {{ $purchaseReceipts->links() }}
        </div>
    </div>

    <!-- Biểu đồ -->
    <div id="inventoryChartContainer" class="row">
        <div class="col-12">
            <canvas id="inventoryChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dữ liệu từ server
        const monthlyData = @json($monthlyData);
        const labels = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];

        // Vẽ biểu đồ với dữ liệu thực tế
        const ctx = document.getElementById('inventoryChart').getContext('2d');
        const inventoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tổng tiền nhập hàng (VND)',
                    data: monthlyData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
