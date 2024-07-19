<?php
namespace App\Enums;

enum PaymentStatus: int
{
    case PENDING_PAYMENT = 0;             // Chờ thanh toán
    case SUCCESS_PAYMENT = 1;             // Thanh toán thành công
    
    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
