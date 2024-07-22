<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
    <tr style="font-family: 'Roboto', sans-serif; font-size: 14px; margin: 0;">
        <td class="content-wrap" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;" valign="top">
            <meta itemprop="name" content="Confirm Email" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />
            <table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td class="content-block" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px; text-align: center;" valign="top">
                        <h4 style="font-family: 'Roboto', sans-serif; margin-bottom: 10px; font-weight: 600;">Đặt hàng thành công </h5>
                    </td>
                </tr>
                <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td class="content-block" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 12px;" valign="top">
                        <h5 style="font-family: 'Roboto', sans-serif; margin-bottom: 3px;">Hey, {{ $data['name'] }}</h5>
                        <p style="font-family: 'Roboto', sans-serif; margin-bottom: 8px; color: #878a99;">Đơn hàng của bạn đã được xác nhận và sẽ sớm được vận chuyển.</p>
                    </td>
                </tr>
                <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td class="content-block" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 18px;" valign="top">
                        <table style="width:100%;">
                            <tbody>
                            <tr style="text-align: left;">
                                <th style="padding: 5px;">
                                    <p style="color: #878a99; font-size: 13px; margin-bottom: 2px; font-weight: 400;">Mã đơn hàng.</p>
                                    <span>{{ $data['order_code'] }}</span>
                                </th>

                                <th style="padding: 5px;">
                                    <p style="color: #878a99; font-size: 13px; margin-bottom: 2px; font-weight: 400;">Phương thức thanh toán:</p>
                                    <span>{{ $data['payment_status'] == 0 ? 'COD' : 'VNPAY' }}</span>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td class="content-block" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 12px;" valign="top">
                        <h6 style="font-family: 'Roboto', sans-serif; font-size: 15px; text-decoration-line: underline;margin-bottom: 15px;">Her'e what you ordered:</h6>
                        <table style="width:100%;" cellspacing="0" cellpadding="0">
                            <thead style="text-align: left;">
                            <th style="padding: 8px;border-bottom: 1px solid #e9ebec;">Chi tiết sản phẩm</th>
                            <th style="padding: 8px;border-bottom: 1px solid #e9ebec;">Số lượng</th>
                            <th style="padding: 8px;border-bottom: 1px solid #e9ebec;">Giá tiền</th>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td style="padding: 8px; font-size: 13px;">
                                    <h6 style="margin-bottom: 2px; font-size: 14px;">{{ $product->name }}</h6>
                                </td>
                                <td style="padding: 8px; font-size: 13px;">
                                    {{ $product->quantity }}
                                </td>
                                <td style="padding: 8px; font-size: 13px;">
                                    {{ $product->price }}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" style="padding: 8px; font-size: 13px; text-align: end;border-top: 1px solid #e9ebec;">
                                    Giá trị đơn hàng:
                                </td>
                                <th style="padding: 8px; font-size: 13px;border-top: 1px solid #e9ebec;">
                                    $334.97
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 8px; font-size: 13px; text-align: end;">
                                    Phí vận chuyện:
                                </td>
                                <th style="padding: 8px; font-size: 13px;">
                                    $9.50
                                </th>
                            </tr>

                            <tr>
                                <td colspan="2" style="padding: 8px; font-size: 13px; text-align: end;border-top: 1px solid #e9ebec;">
                                    Tổng tiền :
                                </td>
                                <th style="padding: 8px; font-size: 13px;border-top: 1px solid #e9ebec;">
                                    $338.95
                                </th>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td class="content-block" style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 0px;" valign="top">
                        <p style="font-family: 'Roboto', sans-serif; margin-bottom: 8px; color: #878a99;">Tôi sẽ gửi cho bạn xác nhận vận chuyển khi (các) mặt hàng của bạn đang được vận chuyển! Chúng tôi đánh giá cao hoạt động kinh doanh của bạn và hy vọng bạn thích mua hàng của mình.</p>
                        <h6 style="font-family: 'Roboto', sans-serif; font-size: 14px; margin-bottom: 0px; text-align: end;">Cảm ơn !</h6>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
