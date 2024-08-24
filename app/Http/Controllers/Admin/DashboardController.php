<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\PurchaseReceipt;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetail;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $topProducts = OrderDetail::getTopSellingProducts(5);
        return view('admin.dashboard.dashboard', compact('topProducts'));
    }

    private function calculatePercentageChange($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    public function orders(Request $request)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $ordersToday = Order::whereDate('created_at', $today)->count();
        $ordersYesterday = Order::whereDate('created_at', $yesterday)->count();
        $percentageChangeToday = $this->calculatePercentageChange($ordersYesterday, $ordersToday);

        return response()->json([
            'orders_today' => $ordersToday,
            'percentage_change_today' => $percentageChangeToday,
        ]);
    }

    public function users(Request $request)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Số lượng người dùng đăng ký trong ngày hôm nay và hôm qua
        $usersToday = User::whereDate('created_at', $today)->count();
        $usersYesterday = User::whereDate('created_at', $yesterday)->count();

        // Tính toán tăng/giảm và tỷ lệ thay đổi so với hôm qua
        $increaseDecreaseYesterday = $usersToday - $usersYesterday;
        $percentageChangeYesterday = $this->calculatePercentageChange($usersYesterday, $usersToday);

        return response()->json([
            'users_today' => $usersToday,
            'increase_decrease_yesterday' => $increaseDecreaseYesterday,
            'percentage_change_yesterday' => $percentageChangeYesterday,
        ]);
    }

    public function ordersTotal(Request $request)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Tổng số tiền của ngày hôm nay
        $totalToday = DB::table('orders')
            ->whereDate('created_at', $today)
            ->sum('after_total_amount');

        // Tổng số tiền của ngày hôm qua
        $totalYesterday = DB::table('orders')
            ->whereDate('created_at', $yesterday)
            ->sum('after_total_amount');

        // Tính toán tỷ lệ thay đổi so với hôm qua
        $percentageChangeToday = $this->calculatePercentageChange($totalYesterday, $totalToday);

        return response()->json([
            'total_today' => $totalToday,
            'percentage_change_today' => $percentageChangeToday,
        ]);
    }
    public function purchase_receipt()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Tổng số phiếu nhập hàng trong ngày hôm nay
        $totalReceiptsToday = DB::table('purchase_receipts')
            ->whereDate('created_at', $today)
            ->count();

        // Tổng số phiếu nhập hàng trong ngày hôm qua
        $totalReceiptsYesterday = DB::table('purchase_receipts')
            ->whereDate('created_at', $yesterday)
            ->count();

        // Tính phần trăm thay đổi phiếu nhập hàng
        $receiptsPercentageChange = $this->calculatePercentageChange($totalReceiptsYesterday, $totalReceiptsToday);

        // Tổng số lượng sản phẩm nhập kho trong ngày hôm nay
        $totalQuantityToday = DB::table('purchase_receipts')
            ->whereDate('created_at', $today)
            ->sum('quantity');

        // Tổng số lượng sản phẩm nhập kho trong ngày hôm qua
        $totalQuantityYesterday = DB::table('purchase_receipts')
            ->whereDate('created_at', $yesterday)
            ->sum('quantity');

        // Tính phần trăm thay đổi số lượng sản phẩm
        $quantityPercentageChange = $this->calculatePercentageChange($totalQuantityYesterday, $totalQuantityToday);

        // Tổng giá trị của các sản phẩm nhập kho trong ngày hôm nay
        $totalValueToday = DB::table('purchase_receipts')
            ->whereDate('created_at', $today)
            ->sum(DB::raw('quantity * cost'));

        // Tổng giá trị của các sản phẩm nhập kho trong ngày hôm qua
        $totalValueYesterday = DB::table('purchase_receipts')
            ->whereDate('created_at', $yesterday)
            ->sum(DB::raw('quantity * cost'));

        // Tính phần trăm thay đổi giá trị sản phẩm
        $valuePercentageChange = $this->calculatePercentageChange($totalValueYesterday, $totalValueToday);

        return response()->json([
            'total_receipts_today' => $totalReceiptsToday,
            'receipts_percentage_change' => $receiptsPercentageChange,
            'total_quantity_today' => $totalQuantityToday,
            'quantity_percentage_change' => $quantityPercentageChange,
            'total_value_today' => $totalValueToday,
            'value_percentage_change' => $valuePercentageChange,
        ]);
    }

    public function voucher()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisYear = Carbon::now()->year;
        $lastYear = Carbon::now()->subYear()->year;
        $thisMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;

        // Số lượng đơn hàng sử dụng voucher trong hôm nay và hôm qua
        $voucherApplyOrderToday = \App\Models\Order::query()
            ->with('voucher')
            ->whereNotNull('voucher_id')
            ->whereDate('created_at', $today)
            ->count();

        $voucherApplyOrderYesterday = \App\Models\Order::query()
            ->with('voucher')
            ->whereNotNull('voucher_id')
            ->whereDate('created_at', $yesterday)
            ->count();

        // Số lượng đơn hàng sử dụng voucher trong tháng này và tháng trước
        $voucherApplyOrderMonth = \App\Models\Order::query()
            ->with('voucher')
            ->whereNotNull('voucher_id')
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();

        $voucherApplyOrderLastMonth = \App\Models\Order::query()
            ->with('voucher')
            ->whereNotNull('voucher_id')
            ->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastYear)
            ->count();

        // Số lượng đơn hàng sử dụng voucher trong năm nay và năm ngoái
        $voucherApplyOrderYear = \App\Models\Order::query()
            ->with('voucher')
            ->whereNotNull('voucher_id')
            ->whereYear('created_at', $thisYear)
            ->count();

        $voucherApplyOrderLastYear = \App\Models\Order::query()
            ->with('voucher')
            ->whereNotNull('voucher_id')
            ->whereYear('created_at', $lastYear)
            ->count();

        // Tính toán tăng/giảm và tỷ lệ thay đổi
        $increaseDecreaseYesterday = $voucherApplyOrderToday - $voucherApplyOrderYesterday;
        $percentageChangeYesterday = $this->calculatePercentageChange($voucherApplyOrderYesterday, $voucherApplyOrderToday);

        $increaseDecreaseLastMonth = $voucherApplyOrderMonth - $voucherApplyOrderLastMonth;
        $percentageChangeLastMonth = $this->calculatePercentageChange($voucherApplyOrderLastMonth, $voucherApplyOrderMonth);

        $increaseDecreaseLastYear = $voucherApplyOrderYear - $voucherApplyOrderLastYear;
        $percentageChangeLastYear = $this->calculatePercentageChange($voucherApplyOrderLastYear, $voucherApplyOrderYear);

        return response()->json([
            'total_today' => $voucherApplyOrderToday,
            'increase_decrease_yesterday' => $increaseDecreaseYesterday,
            'percentage_change_yesterday' => $percentageChangeYesterday,
            'total_this_month' => $voucherApplyOrderMonth,
            'increase_decrease_last_month' => $increaseDecreaseLastMonth,
            'percentage_change_last_month' => $percentageChangeLastMonth,
            'total_this_year' => $voucherApplyOrderYear,
            'increase_decrease_last_year' => $increaseDecreaseLastYear,
            'percentage_change_last_year' => $percentageChangeLastYear,
            'voucher_usage_by_month' => $this->charsVoucher() // Dữ liệu để đưa vào biểu đồ
        ]);
    }

    public function charsVoucher()
    {
        $currentDate = Carbon::now();
        $voucherUsage = [];

        // Lặp qua 12 tháng trước đó (bao gồm tháng hiện tại)
        for ($i = 0; $i < 12; $i++) {
            $month = $currentDate->copy()->subMonths($i)->format('Y-m'); // Định dạng theo năm-tháng

            // Đếm số lượng đơn hàng sử dụng voucher trong mỗi tháng
            $voucherApplyOrder = \App\Models\Order::query()
                ->with('voucher')
                ->whereNotNull('voucher_id')
                ->whereYear('created_at', $currentDate->copy()->subMonths($i)->year)
                ->whereMonth('created_at', $currentDate->copy()->subMonths($i)->month)
                ->count();

            // Lưu kết quả vào mảng
            $voucherUsage[$month] = $voucherApplyOrder;
        }

        // Đảo ngược mảng để hiển thị từ tháng cũ nhất đến mới nhất
        $voucherUsage = array_reverse($voucherUsage);

        return $voucherUsage;
    }
}
