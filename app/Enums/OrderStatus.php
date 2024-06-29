<?php
namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 0;                     // Chờ xử lý
    case PREPARE = 1;                     // Đang chuẩn bị
    case PENDING_PAYMENT = 2;             // Chờ thanh toán
    case READY_TO_PICK = 3;               // Sẵn sàng lấy hàng
    case PICKING = 4;                     // Đang lấy hàng
    case PICKED = 5;                      // Đã lấy hàng
    case STORING = 6;                     // Đang nhập kho
    case TRANSPORTING = 7;                // Đang vận chuyển
    case SORTING = 8;                     // Đang phân loại
    case DELIVERING = 9;                  // Đang giao hàng
    case DELIVERED = 10;                  // Đã giao hàng
    case MONEY_COLLECT_DELIVERING = 11;   // Đang tương tác thu tiền với người nhận
    case DELIVERY_FAIL = 12;              // Giao hàng không thành công
    case WAITING_TO_RETURN = 13;          // Chờ xác nhận giao lại
    case RETURN = 14;                     // Đang hoàn hàng
    case RETURN_TRANSPORTING = 15;        // Đang vận chuyển hàng hoàn
    case RETURN_SORTING = 16;             // Đang phân loại hàng hoàn
    case RETURNING = 17;                  // Đang hoàn hàng
    case RETURN_FAIL = 18;                // Hoàn hàng không thành công
    case RETURNED = 19;                   // Hoàn hàng thành công
    case CANCELLED = 20;                  // Đơn hàng đã huỷ
    case EXCEPTION = 21;                  // Hàng ngoại lệ
    case LOST = 22;                       // Hàng thất lạc
    case DAMAGED = 23;                    // Hàng hư hỏng

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
