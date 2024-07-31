<?php

namespace App\Enums;

enum  Permissions: string
{
    case manage_system = '1'; // Quản lý hệ thống

    case statistical = '2'; // Thống kê mua bán hàng

    case sales_management = '3';// Quản lý bán hàng

    case inventory_management = '4'; // Quản lý xuất nhập hàng
    case post_ads = '5'; // Đăng bài, quảng cáo

    case handling_customer_requests = '6'; // Xử lý yêu cầu khách hàng ;

    case order_processing = '7'; // Xử lý đơn hàng;

    case add_delete_and_edit_products = '8'; // Thêm sửa xóa sản phẩm

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::manage_system => 'Quản lý hệ thống',
            self::statistical => 'Thống kê mua bán hàng',
            self::sales_management => 'Quản lý bán hàng',
            self::post_ads => ' Đăng bài, quảng cáo',
            self::inventory_management => 'Quản lý xuất nhập hàng',
            self::handling_customer_requests => 'Xử lý yêu cầu khách hàng ;',
            self::order_processing => 'Xử lý đơn hàng;',
            self::add_delete_and_edit_products => 'Thêm,sửa,xóa sản phẩm ',
        };
    }
}