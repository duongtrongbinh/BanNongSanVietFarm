<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetail;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $topProducts = OrderDetail::getTopSellingProducts(5);
        return view('admin.dashboard.dashboard',compact('topProducts'));
    }


    public function orders(Request $request)
    {
        $filter = $request->query('filter', 'day');
        $totalOrders = Order::count();
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;
        $thisYear = Carbon::now()->year;
        $lastYear = Carbon::now()->subYear()->year;
        $ordersToday = Order::whereDate('created_at', $today)->count();
        $ordersYesterday = Order::whereDate('created_at', $yesterday)->count();
        $percentageChangeToday = $this->calculatePercentageChange($ordersYesterday, $ordersToday);
        $ordersThisMonth = Order::whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $ordersLastMonth = Order::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $percentageChangeMonth = $this->calculatePercentageChange($ordersLastMonth, $ordersThisMonth);

        $ordersThisYear = Order::whereYear('created_at', $thisYear)->count();
        $ordersLastYear = Order::whereYear('created_at', $lastYear)->count();
        $percentageChangeLastYear = $this->calculatePercentageChange($ordersLastYear, $ordersThisYear);

        return response()->json([
            'orders_today' => $ordersToday,
            'percentage_change_today' => $percentageChangeToday,
            'orders_this_month' => $ordersThisMonth,
            'percentage_change_month' => $percentageChangeMonth,
            'orders_this_year' => $ordersThisYear,
            'percentage_change_last_year' => $percentageChangeLastYear,
        ]);
    }

    public function users(Request $request)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisYear = Carbon::now()->year;
        $lastYear = Carbon::now()->subYear()->year;
        $thisMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;

        $totalUsers = User::count();

        // Số lượng người dùng đăng ký trong ngày hôm nay và hôm qua
        $usersToday = User::whereDate('created_at', $today)->count();

        $usersYesterday = User::whereDate('created_at', $yesterday)->count();

        // Số lượng người dùng đăng ký trong năm nay và năm ngoái
        $usersThisYear = User::whereYear('created_at', $thisYear)->count();
        $usersLastYear = User::whereYear('created_at', $lastYear)->count();

        // Số lượng người dùng đăng ký trong tháng này và tháng trước
        $usersThisMonth = User::whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)->count();
        $usersLastMonth = User::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastYear)->count();

        // Tính toán tăng/giảm và tỷ lệ thay đổi
        $increaseDecreaseYesterday = $usersToday - $usersYesterday;
        $percentageChangeYesterday = $this->calculatePercentageChange($usersYesterday, $usersToday);

        $increaseDecreaseLastMonth = $usersThisMonth - $usersLastMonth;
        $percentageChangeLastMonth = $this->calculatePercentageChange($usersLastMonth, $usersThisMonth);

        $increaseDecreaseLastYear = $usersThisYear - $usersLastYear;
        $percentageChangeLastYear = $this->calculatePercentageChange($usersLastYear, $usersThisYear);

        return response()->json([
            'total_users' => $totalUsers,
            'users_today' => $usersToday,
            'increase_decrease_yesterday' => $increaseDecreaseYesterday,
            'percentage_change_yesterday' => $percentageChangeYesterday,
            'users_this_month' => $usersThisMonth,
            'increase_decrease_last_month' => $increaseDecreaseLastMonth,
            'percentage_change_last_month' => $percentageChangeLastMonth,
            'users_this_year' => $usersThisYear,
            'increase_decrease_last_year' => $increaseDecreaseLastYear,
            'percentage_change_last_year' => $percentageChangeLastYear,
        ]);
    }

    public function ordersTotal(Request $request)
    {
        $today = Carbon::now();
        $startOfDay = $today->startOfDay();
        $startOfMonth = $today->startOfMonth();
        $startOfYear = $today->startOfYear();

        // Tổng số đơn hàng và tổng số tiền của ngày hôm nay
        $totalToday = DB::table('orders')
            ->whereDate('created_at', $startOfDay)
            ->sum('after_total_amount');

        // Tổng số đơn hàng và tổng số tiền của tháng này
        $totalThisMonth = DB::table('orders')
            ->whereMonth('created_at', $startOfMonth->month)
            ->whereYear('created_at', $startOfMonth->year)
            ->sum('after_total_amount');

        // Tổng số đơn hàng và tổng số tiền của năm nay
        $totalThisYear = DB::table('orders')
            ->whereYear('created_at', $startOfYear->year)
            ->sum('after_total_amount');

        // Tổng số đơn hàng và tổng số tiền của ngày hôm qua
        $yesterday = Carbon::yesterday();
        $totalYesterday = DB::table('orders')
            ->whereDate('created_at', $yesterday->startOfDay())
            ->sum('after_total_amount');

        // Tổng số đơn hàng và tổng số tiền của tháng trước
        $lastMonth = Carbon::now()->subMonth();
        $totalLastMonth = DB::table('orders')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('after_total_amount');

        // Tổng số đơn hàng và tổng số tiền của năm ngoái
        $lastYear = Carbon::now()->subYear();
        $totalLastYear = DB::table('orders')
            ->whereYear('created_at', $lastYear->year)
            ->sum('after_total_amount');

        // Tính toán tỷ lệ thay đổi
        $percentageChangeToday = $this->calculatePercentageChange($totalYesterday, $totalToday);
        $percentageChangeMonth = $this->calculatePercentageChange($totalLastMonth, $totalThisMonth);
        $percentageChangeYear = $this->calculatePercentageChange($totalLastYear, $totalThisYear);

        return response()->json([
            'total_today' => $totalToday,
            'total_this_month' => $totalThisMonth,
            'total_this_year' => $totalThisYear,
            'percentage_change_today' => $percentageChangeToday,
            'percentage_change_month' => $percentageChangeMonth,
            'percentage_change_year' => $percentageChangeYear,
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

    private function calculatePercentageChange($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }
}
