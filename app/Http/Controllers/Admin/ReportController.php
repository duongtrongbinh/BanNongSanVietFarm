<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\PurchaseReceipt;

class ReportController extends Controller
{
    private function getOrderData($startDate, $endDate)
    {
        return DB::table('orders')
            ->select(DB::raw('status, COUNT(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->pluck('count', 'status');
    }

    private function getUserData($startDate, $endDate)
    {
        // Khách hàng mới
        $newUsers = DB::table('users')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Khách hàng quay lại
        $returningUsers = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('users.id')
            ->havingRaw('COUNT(orders.id) > 1')
            ->count();

        // Khách hàng tiềm năng (đăng ký nhưng chưa mua hàng)
        $potentialUsers = DB::table('users')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('orders')
                    ->whereRaw('orders.user_id = users.id');
            })
            ->count();

        // Khách hàng không hoạt động (dựa trên cột `updated_at`)
        $inactiveUsers = DB::table('users')
            ->where('updated_at', '<', $startDate) // Chưa cập nhật thông tin hoặc hoạt động trong khoảng thời gian này
            ->count();

        return [
            'Khách hàng mới' => $newUsers,
            'Khách hàng quay lại' => $returningUsers,
            'Khách hàng tiềm năng' => $potentialUsers,
            'Khách hàng không hoạt động' => $inactiveUsers
        ];
    }

    private function calculatePercentageChange($currentData, $previousData, $statusMap = null)
    {
        $result = [];

        if ($statusMap) {
            foreach ($statusMap as $key => $status) {
                $currentCount = $currentData[$key] ?? 0;
                $previousCount = $previousData[$key] ?? 0;
                if ($previousCount === 0) {
                    $percentageChange = $currentCount > 0 ? 100 : 0;
                } else {
                    $percentageChange = (($currentCount - $previousCount) / $previousCount) * 100;
                }
                $result[$status] = [
                    'count' => $currentCount,
                    'percentage_change' => round($percentageChange, 2),
                    'change' => $currentCount > $previousCount ? 'tăng' : ($currentCount < $previousCount ? 'giảm' : 'không đổi')
                ];
            }
        } else {
            foreach ($currentData as $type => $currentCount) {
                $previousCount = $previousData[$type] ?? 0;

                if ($previousCount === 0) {
                    $percentageChange = $currentCount > 0 ? 100 : 0;
                } else {
                    $percentageChange = (($currentCount - $previousCount) / $previousCount) * 100;
                }

                $result[$type] = [
                    'count' => $currentCount,
                    'percentage_change' => round($percentageChange, 2),
                    'change' => $currentCount > $previousCount ? 'tăng' : ($currentCount < $previousCount ? 'giảm' : 'không đổi')
                ];
            }
        }

        return $result;
    }

    private function getRevenueData($startDate, $endDate)
    {
        return DB::table('orders')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('after_total_amount');
    }

    private function calculateRevenueChange($currentData, $previousData)
    {
        if ($previousData === 0) {
            return $currentData > 0 ? 100 : 0;
        }

        return (($currentData - $previousData) / $previousData) * 100;
    }

    public function orders()
    {
        return view('admin.reports.orders');
    }

    public function report_orders(Request $request)
    {
        // Lấy các mốc thời gian
        $period = $request->query('period', 'today');

        $start = now()->startOfDay();
        $end = now();

        switch ($period) {
            case 'this_month':
                $start = now()->startOfMonth();
                break;
            case 'this_year':
                $start = now()->startOfYear();
                break;
        }

        $previousStart = (clone $start)->subDay();
        $previousEnd = (clone $end)->subDay();

        $statusMap = Order::getStatusMap();

        $ordersCurrentPeriod = $this->getOrderData($start, $end);
        $ordersPreviousPeriod = $this->getOrderData($previousStart, $previousEnd);

        $reportData = [
            $period => $this->calculatePercentageChange($ordersCurrentPeriod, $ordersPreviousPeriod, $statusMap)
        ];

        return response()->json($reportData);
    }

    public function users()
    {
        return view('admin.reports.users');
    }

    public function report_users(Request $request)
    {
        // Lấy các mốc thời gian
        $period = $request->query('period', 'today');

        $start = now()->startOfDay();
        $end = now();

        switch ($period) {
            case 'this_month':
                $start = now()->startOfMonth();
                break;
            case 'this_year':
                $start = now()->startOfYear();
                break;
        }

        $previousStart = (clone $start)->subDay();
        $previousEnd = (clone $end)->subDay();

        $usersCurrentPeriod = $this->getUserData($start, $end);
        $usersPreviousPeriod = $this->getUserData($previousStart, $previousEnd);

        $reportData = [
            $period => $this->calculatePercentageChange($usersCurrentPeriod, $usersPreviousPeriod)
        ];

        return response()->json($reportData);
    }

    public function revenue()
    {
        return view('admin.reports.revenue');
    }

    public function report_revenue()
    {
        // Lấy các mốc thời gian
        $today = now()->startOfDay();
        $yesterday = now()->subDay()->startOfDay();
        $thisMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();
        $thisYear = now()->startOfYear();
        $lastYear = now()->subYear()->startOfYear();
        // Doanh thu hiện tại và trước đó
        $revenueToday = $this->getRevenueData($today, now());
        $revenueYesterday = $this->getRevenueData($yesterday, $today);
        $revenueThisMonth = $this->getRevenueData($thisMonth, now());
        $revenueLastMonth = $this->getRevenueData($lastMonth, $thisMonth);
        $revenueThisYear = $this->getRevenueData($thisYear, now());
        $revenueLastYear = $this->getRevenueData($lastYear, $thisYear);

        // Tính toán sự thay đổi phần trăm
        $reportData = [
            'today' => [
                'revenue' => $revenueToday,
                'percentage_change' => round($this->calculateRevenueChange($revenueToday, $revenueYesterday), 2),
                'change' => $revenueToday > $revenueYesterday ? 'tăng' : ($revenueToday < $revenueYesterday ? 'giảm' : 'không đổi'),
            ],
            'this_month' => [
                'revenue' => $revenueThisMonth,
                'percentage_change' => round($this->calculateRevenueChange($revenueThisMonth, $revenueLastMonth), 2),
                'change' => $revenueThisMonth > $revenueLastMonth ? 'tăng' : ($revenueThisMonth < $revenueLastMonth ? 'giảm' : 'không đổi'),
            ],
            'this_year' => [
                'revenue' => $revenueThisYear,
                'percentage_change' => round($this->calculateRevenueChange($revenueThisYear, $revenueLastYear), 2),
                'change' => $revenueThisYear > $revenueLastYear ? 'tăng' : ($revenueThisYear < $revenueLastYear ? 'giảm' : 'không đổi'),
            ],
        ];
        return response()->json($reportData);
    }

    public function purchase_receipt(Request $request)
    {
        // Lấy năm hiện tại hoặc từ request nếu có
        $year = $request->input('year', now()->year);

        // Truy vấn thông tin nhập hàng từ bảng purchase_receipts
        $purchaseReceipts = PurchaseReceipt::with(['supplier', 'products']) // Tải trước dữ liệu supplier và products
        ->select(
            'reference_code',
            'supplier_id',
            DB::raw('SUM(quantity) as total_imported'), // Tổng số lượng nhập
            DB::raw('SUM(quantity * cost) as total_cost'), // Tổng chi phí
            'product_id'
        )
            ->whereYear('created_at', $year)
            ->groupBy('reference_code', 'supplier_id', 'product_id')
            ->paginate(10);

        // Tính toán số lượng bán được (total_sold) và tồn kho (total_in_stock)
        foreach ($purchaseReceipts as $receipt) {
            $totalSold = DB::table('order_details')
                ->where('product_id', $receipt->product_id)
                ->whereYear('created_at', $year)
                ->sum('quantity');

            $receipt->total_sold = $totalSold;
            $receipt->total_in_stock = $receipt->total_imported - $totalSold;
        }

        // Chuẩn bị dữ liệu cho biểu đồ: Tổng số tiền nhập hàng theo từng tháng
        $chartData = PurchaseReceipt::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(quantity * cost) as total_amount')
        )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        // Tạo mảng chứa dữ liệu cho 12 tháng
        $monthlyData = array_fill(1, 12, 0);

        // Đổ dữ liệu vào mảng tương ứng với từng tháng
        foreach ($chartData as $data) {
            $monthlyData[$data->month] = $data->total_amount;
        }

        // Kiểm tra dữ liệu được trả về
        return view('admin.reports.purchase_receipt', compact('purchaseReceipts', 'monthlyData', 'year'));
    }

    public function voucherIndex()
    {
        return view('admin.reports.voucher');
    }

    public function report_vouchers(Request $request)
    {
        // Lấy các mốc thời gian
        $period = $request->query('period', 'today');

        $start = now()->startOfDay();
        $end = now();

        switch ($period) {
            case 'this_month':
                $start = now()->startOfMonth();
                break;
            case 'this_year':
                $start = now()->startOfYear();
                break;
        }

        $previousStart = (clone $start)->subDay();
        $previousEnd = (clone $end)->subDay();

        $vouchersCurrentPeriod = $this->getVoucherData($start, $end);
        $vouchersPreviousPeriod = $this->getVoucherData($previousStart, $previousEnd);

        $reportData = [
            $period => $this->calculatePercentageChange($vouchersCurrentPeriod, $vouchersPreviousPeriod)
        ];

        return response()->json($reportData);
    }

    private function getVoucherData($startDate, $endDate)
    {
        // Số lượng đơn hàng sử dụng voucher trong khoảng thời gian này
        $voucherApplyOrders = DB::table('orders')
            ->whereNotNull('voucher_id')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Số lượng voucher được phát hành trong khoảng thời gian này
        $issuedVouchers = DB::table('vouchers')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Số lượng voucher đang hoạt động (is_active = 1)
        $activeVouchers = DB::table('vouchers')
            ->where('is_active', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Số lượng voucher không hoạt động (is_active = 0)
        $inactiveVouchers = DB::table('vouchers')
            ->where('is_active', 0)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        return [
            'Số lượng đơn hàng sử dụng voucher' => $voucherApplyOrders,
            'Số lượng voucher đang phát hành' => $issuedVouchers,
            'Số lượng voucher đang hoạt động' => $activeVouchers,
            'Số lượng voucher không hoạt động' => $inactiveVouchers,
        ];
    }

}
