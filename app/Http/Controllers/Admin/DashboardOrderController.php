<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardOrderController extends Controller
{
    public function orders()
    {
        return view('admin.dashboard.orders');
    }

    // Hàm tính tỷ lệ thay đổi phần trăm
    public function orders_pending(Request $request)
    {
        $filter = $request->query('filter', 'day');
        $status = 0;

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastYear = Carbon::now()->subYear()->year;

        // Lọc các đơn hàng theo trạng thái
        $query = Order::where('status', $status);

        // Kiểm tra xem có đơn hàng nào không
        $orders = $query->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No pending orders found'], 404);
        }

        // Tính toán số lượng đơn hàng và tỷ lệ thay đổi
        $ordersToday = (clone $query)->whereDate('created_at', $today)->count();
        $ordersYesterday = (clone $query)->whereDate('created_at', $yesterday)->count();
        $percentageChangeToday = $this->calculatePercentageChange($ordersYesterday, $ordersToday);

        $ordersThisMonth = (clone $query)->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $ordersLastMonth = (clone $query)->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $percentageChangeMonth = $this->calculatePercentageChange($ordersLastMonth, $ordersThisMonth);

        $ordersThisYear = (clone $query)->whereYear('created_at', $thisYear)->count();
        $ordersLastYear = (clone $query)->whereYear('created_at', $lastYear)->count();
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

    public function orders_processing(Request $request)
    {
        $filter = $request->query('filter', 'day');
        $status = 1;

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastYear = Carbon::now()->subYear()->year;

        // Lọc các đơn hàng theo trạng thái
        $query = Order::where('status', $status);

        // Kiểm tra xem có đơn hàng nào không
        $orders = $query->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No pending orders found'], 404);
        }

        // Tính toán số lượng đơn hàng và tỷ lệ thay đổi
        $ordersToday = (clone $query)->whereDate('created_at', $today)->count();
        $ordersYesterday = (clone $query)->whereDate('created_at', $yesterday)->count();
        $percentageChangeToday = $this->calculatePercentageChange($ordersYesterday, $ordersToday);

        $ordersThisMonth = (clone $query)->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $ordersLastMonth = (clone $query)->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $percentageChangeMonth = $this->calculatePercentageChange($ordersLastMonth, $ordersThisMonth);

        $ordersThisYear = (clone $query)->whereYear('created_at', $thisYear)->count();
        $ordersLastYear = (clone $query)->whereYear('created_at', $lastYear)->count();
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

    public function orders_shipping(Request $request)
    {
        $filter = $request->query('filter', 'day');
        $status = 2;

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastYear = Carbon::now()->subYear()->year;

        // Lọc các đơn hàng theo trạng thái
        $query = Order::where('status', $status);

        // Kiểm tra xem có đơn hàng nào không
        $orders = $query->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No pending orders found'], 404);
        }

        // Tính toán số lượng đơn hàng và tỷ lệ thay đổi
        $ordersToday = (clone $query)->whereDate('created_at', $today)->count();
        $ordersYesterday = (clone $query)->whereDate('created_at', $yesterday)->count();
        $percentageChangeToday = $this->calculatePercentageChange($ordersYesterday, $ordersToday);

        $ordersThisMonth = (clone $query)->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $ordersLastMonth = (clone $query)->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $percentageChangeMonth = $this->calculatePercentageChange($ordersLastMonth, $ordersThisMonth);

        $ordersThisYear = (clone $query)->whereYear('created_at', $thisYear)->count();
        $ordersLastYear = (clone $query)->whereYear('created_at', $lastYear)->count();
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

    public function orders_delivery(Request $request)
    {
        $filter = $request->query('filter', 'day');
        $status = 3;

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastYear = Carbon::now()->subYear()->year;

        // Lọc các đơn hàng theo trạng thái
        $query = Order::where('status', $status);

        // Kiểm tra xem có đơn hàng nào không
        $orders = $query->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No pending orders found'], 404);
        }

        // Tính toán số lượng đơn hàng và tỷ lệ thay đổi
        $ordersToday = (clone $query)->whereDate('created_at', $today)->count();
        $ordersYesterday = (clone $query)->whereDate('created_at', $yesterday)->count();
        $percentageChangeToday = $this->calculatePercentageChange($ordersYesterday, $ordersToday);

        $ordersThisMonth = (clone $query)->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $ordersLastMonth = (clone $query)->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $percentageChangeMonth = $this->calculatePercentageChange($ordersLastMonth, $ordersThisMonth);

        $ordersThisYear = (clone $query)->whereYear('created_at', $thisYear)->count();
        $ordersLastYear = (clone $query)->whereYear('created_at', $lastYear)->count();
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

    public function orders_received(Request $request)
    {
        $filter = $request->query('filter', 'day');
        $status = 4;

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastYear = Carbon::now()->subYear()->year;

        // Lọc các đơn hàng theo trạng thái
        $query = Order::where('status', $status);

        // Kiểm tra xem có đơn hàng nào không
        $orders = $query->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No pending orders found'], 404);
        }

        // Tính toán số lượng đơn hàng và tỷ lệ thay đổi
        $ordersToday = (clone $query)->whereDate('created_at', $today)->count();
        $ordersYesterday = (clone $query)->whereDate('created_at', $yesterday)->count();
        $percentageChangeToday = $this->calculatePercentageChange($ordersYesterday, $ordersToday);

        $ordersThisMonth = (clone $query)->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $ordersLastMonth = (clone $query)->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $percentageChangeMonth = $this->calculatePercentageChange($ordersLastMonth, $ordersThisMonth);

        $ordersThisYear = (clone $query)->whereYear('created_at', $thisYear)->count();
        $ordersLastYear = (clone $query)->whereYear('created_at', $lastYear)->count();
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

    public function orders_completed(Request $request)
    {
        $filter = $request->query('filter', 'day');
        $status = 5;

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastYear = Carbon::now()->subYear()->year;

        // Lọc các đơn hàng theo trạng thái
        $query = Order::where('status', $status);

        // Kiểm tra xem có đơn hàng nào không
        $orders = $query->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No pending orders found'], 404);
        }

        // Tính toán số lượng đơn hàng và tỷ lệ thay đổi
        $ordersToday = (clone $query)->whereDate('created_at', $today)->count();
        $ordersYesterday = (clone $query)->whereDate('created_at', $yesterday)->count();
        $percentageChangeToday = $this->calculatePercentageChange($ordersYesterday, $ordersToday);

        $ordersThisMonth = (clone $query)->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $ordersLastMonth = (clone $query)->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $percentageChangeMonth = $this->calculatePercentageChange($ordersLastMonth, $ordersThisMonth);

        $ordersThisYear = (clone $query)->whereYear('created_at', $thisYear)->count();
        $ordersLastYear = (clone $query)->whereYear('created_at', $lastYear)->count();
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

    public function orders_cancellation(Request $request)
    {
        $filter = $request->query('filter', 'day');
        $status = 6; // Trạng thái đơn hàng đã hủy

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastYear = Carbon::now()->subYear()->year;

        // Lọc các đơn hàng theo trạng thái
        $query = Order::where('status', $status);

        // Kiểm tra xem có đơn hàng nào không
        $orders = $query->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No canceled orders found'], 404);
        }

        // Tính toán số lượng đơn hàng và tỷ lệ thay đổi
        $ordersToday = (clone $query)->whereDate('created_at', $today)->count();
        $ordersYesterday = (clone $query)->whereDate('created_at', $yesterday)->count();
        $percentageChangeToday = $this->calculatePercentageChange($ordersYesterday, $ordersToday);

        $ordersThisMonth = (clone $query)->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $ordersLastMonth = (clone $query)->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $percentageChangeMonth = $this->calculatePercentageChange($ordersLastMonth, $ordersThisMonth);

        $ordersThisYear = (clone $query)->whereYear('created_at', $thisYear)->count();
        $ordersLastYear = (clone $query)->whereYear('created_at', $lastYear)->count();
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
    public function orders_Returns(Request $request)
    {
        $filter = $request->query('filter', 'day');
        $status = 7; // Trạng thái đơn hàng đã hủy

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastYear = Carbon::now()->subYear()->year;

        // Lọc các đơn hàng theo trạng thái
        $query = Order::where('status', $status);

        // Kiểm tra xem có đơn hàng nào không
        $orders = $query->get();
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No canceled orders found'], 404);
        }

        // Tính toán số lượng đơn hàng và tỷ lệ thay đổi
        $ordersToday = (clone $query)->whereDate('created_at', $today)->count();
        $ordersYesterday = (clone $query)->whereDate('created_at', $yesterday)->count();
        $percentageChangeToday = $this->calculatePercentageChange($ordersYesterday, $ordersToday);

        $ordersThisMonth = (clone $query)->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $ordersLastMonth = (clone $query)->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $thisYear)
            ->count();
        $percentageChangeMonth = $this->calculatePercentageChange($ordersLastMonth, $ordersThisMonth);

        $ordersThisYear = (clone $query)->whereYear('created_at', $thisYear)->count();
        $ordersLastYear = (clone $query)->whereYear('created_at', $lastYear)->count();
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
    private function calculatePercentageChange($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return (($current - $previous) / $previous) * 100;
    }
}
