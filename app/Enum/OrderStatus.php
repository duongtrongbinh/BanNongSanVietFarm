<?php
namespace App\Enum;

enum OrderStatus: int
{
    case PENDING = 0;                     // Chờ xử lý
    case PREPARE = 1;                     // Đang chuẩn bị
    case PENDING_PAYMENT = 2;             // Chờ thanh toán
    case SUCCESS_PAYMENT = 3;             // Thanh toán thành công
    case READY_TO_PICK = 4;               // Sẵn sàng lấy hàng
    case PICKING = 5;                     // Đang lấy hàng
    case PICKED = 6;                      // Đã lấy hàng
    case STORING = 7;                     // Đang nhập kho
    case TRANSPORTING = 8;                // Đang vận chuyển
    case SORTING = 9;                     // Đang phân loại
    case DELIVERING = 10;                 // Đang giao hàng
    case DELIVERED = 11;                  // Đã giao hàng
    case MONEY_COLLECT_DELIVERING = 12;   // Đang tương tác thu tiền với người nhận
    case DELIVERY_FAIL = 13;              // Giao hàng không thành công
    case WAITING_TO_RETURN = 14;          // Chờ xác nhận giao lại
    case RETURN = 15;                     // Đang hoàn hàng
    case RETURN_TRANSPORTING = 16;        // Đang vận chuyển hàng hoàn
    case RETURN_SORTING = 17;             // Đang phân loại hàng hoàn
    case RETURNING = 18;                  // Đang hoàn hàng
    case RETURN_FAIL = 19;                // Hoàn hàng không thành công
    case RETURNED = 20;                   // Hoàn hàng thành công
    case CANCELLED = 21;                  // Đơn hàng đã huỷ
    case EXCEPTION = 22;                  // Hàng ngoại lệ
    case LOST = 23;                       // Hàng thất lạc
    case DAMAGED = 24;                    // Hàng hư hỏng
    case RETRY = 25;
    
    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}