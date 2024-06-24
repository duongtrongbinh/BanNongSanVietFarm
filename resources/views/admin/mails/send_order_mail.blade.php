<div>
    <h1>
        Cảm ơn bạn đã đặt hàng tại website của chúng tôi
    </h1>
    <h3>mã đơn hàng:<span>{{ $data['order_code'] }}</span></h3>
    <h3>Họ tên người nhận:<span>{{ $data['name'] }}</span></h3>
    <h3>Số điện thoại người nhận:<span>{{ $data['phone'] }}</span></h3>
    <h3>Địa chỉ người nhận:<span>{{ $data['address_detail'] }}</span></h3>
    <h3>Tổng tiền:<span>{{ $data['after_total_amount'] }}</span></h3>
    @if ($data['payment_method'] != 'VNPAYQR')
    <h3>Trạng thái:<span>Thanh toán khi nhận hàng</span></h3>
    @endif
    @if ($data['payment_method'] == 'VNPAYQR')
    <h3>Trạng thái:<span>Đã thanh toán</span></h3>
    @endif
</div>