<?php
namespace App\Enums;

enum OrderStatus: int
{   
    case PENDING = 0;                     // Đang chờ xử lý
    case PROCESSING  = 1;                 // Đang xử lý
    case SHIPPING = 2;                    // Vận chuyển
    case SHIPPED = 3;                     // Giao hàng
    case DELIVERED = 4;                   // Đã nhận hàng
    case COMPLETED = 5;                    // Hoàn thành
    case CANCELLED = 6;                   // Đã hủy
    case RETURNED = 7;                    // Trả hàng/Hoàn tiền
    case RETRY = 8;                    // Gửi yêu cầu lỗi
    
    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Đang chờ xử lý',
            self::PROCESSING => 'Đang xử lý',
            self::SHIPPING => 'Vận chuyển',
            self::SHIPPED => 'Giao hàng',
            self::DELIVERED => 'Đã nhận hàng',
            self::COMPLETED => 'Hoàn thành',
            self::CANCELLED => 'Đã hủy',
            self::RETURNED => 'Trả hàng/Hoàn tiền',
            self::RETRY => 'Gửi yêu cầu lỗi',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::PENDING => 'ri-more-fill',
            self::PROCESSING => 'ri-loader-2-fill',
            self::SHIPPING => 'ri-truck-fill',
            self::SHIPPED => 'ri-takeaway-fill',
            self::DELIVERED => 'ri-user-received-fill',
            self::COMPLETED => 'ri-checkbox-circle-fill',
            self::CANCELLED => 'ri-close-circle-fill',
            self::RETURNED => 'ri-reply-fill',
        };
    }
}