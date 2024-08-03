
$(document).ready(function() {

    $(".voucher_apply").on('click',function (){

        var total_cart = $("#total_cart").data('total');

        var url = $(this).data('url');

        var voucher_id = $(this).val();

       if(voucher_id){
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify({
                    voucher_id: voucher_id,
                    total_cart: total_cart,
                }),
                success: function (response) {
                    console.log(response);
                    hideVoucher();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Có lỗi xảy ra khi lấy dữ liệu quận huyện!');
                }
            });

       }
    });

    function hideVoucher(){
        $("#page-header-voucher-dropdown").click();
    }


    $("#province").on("change",function (){
        var url = $(this).data('url');
        var province = $(this).val();
        var parts = province.split(' - ');
        var id = +parts[0].trim();
        if (id != 0){
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'Content-Type' : 'application/json',
                },
                data:JSON.stringify({
                    province_id: id
                }),
                success: function (response) {
                    renderDistrictOptions(response.data);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Có lỗi xảy ra khi lấy dữ liệu quận huyện!');
                }
            });
        }else{
            reset($(this));
        }

    })

    $("#district").on("change",function (){
        var url = $(this).data('url');
        var district = $(this).val();
        var parts = district.split(' - ');
        var id = +parts[0].trim();
        to_district_id = id;
        if (id != 0) {
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify({
                    district_id: id
                }),
                success: function (response) {
                    if(response.data != null){
                        renderWardOptions(response.data);
                    }else {
                        resetWard()
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Có lỗi xảy ra khi lấy dữ liệu quận huyện!');
                }
            });
        }else {
            reset($(this));
        }
    })

    var total_after = $("#total_cart").data('total');
    var total_befor = 0;
    var price_shipping = $("#service_fee");

    $("#ward").on("change",function (){
        let url = $(this).data('url')
        let Ward = $(this).val();
        var parts = Ward.split(' - ');
        var WardCode = parts[0].trim();
        if (WardCode){
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:JSON.stringify({
                    ward_code: WardCode,
                    district_id: to_district_id,
                }),
                success: function (response) {
                    switch (response.message){
                        case 'Success':
                            // Trường hợp message là 'Success'
                            total_befor = total_after + response.data.total;
                            price_shipping.html(number_format(response.data.total));
                            break;
                        case 'missing':
                            total_befor = total_after + 0;
                            price_shipping.html(number_format(0));
                            break;
                        default:
                            total_befor = total_after + response.total;
                            price_shipping.html(number_format(response.total));
                    }

                    $("#total_cart").html(number_format(total_befor, 2, '.', ','));
                },
                error: function (xhr, status, error) {

                }
            });
        }
    })

    function renderDistrictOptions(data) {
            let optionsHtml = '';
            optionsHtml = '<option value="0">Chọn Quận/Huyện</option>';
            data.forEach(function (item) {
                optionsHtml += `<option value="${item.DistrictID} - ${item.DistrictName}">${item.DistrictName}</option>`;
            });
            resetWard();
            $('#district').html(optionsHtml);

    }

    function renderWardOptions(data) {
        let optionsHtml = '';
        optionsHtml = '<option value="0">Chọn Phường/Xã</option>';
        data.forEach(function (item) {
        optionsHtml += `<option value="${item.WardCode} - ${item.WardName}">${item.WardName}</option>`;
        });
        $('#ward').html(optionsHtml);
    }

    function resetProvince() {
        $('#district').html('<option value="0">Chọn Quận/Huyện</option>');
        $('#ward').html('<option value="0">Chọn Phường/Xã</option>');
    }

    function resetWard(){
        $('#ward').html('<option value="0">Chọn Phường/Xã</option>');
    }

    function reset(element){
       if (element.attr('id') === 'province'){
           resetProvince();
       }else{
           resetWard();
       }
    }

    function number_format(number, decimals, dec_point, thousands_sep) {
        // Kiểm tra và gán giá trị mặc định cho các tham số nếu chưa được cung cấp
        number = parseFloat(number);
        if (!decimals) decimals = 0;
        if (!dec_point) dec_point = '.';
        if (!thousands_sep) thousands_sep = ',';

        // Tách phần nguyên và phần thập phân
        var rounded_number = Math.round(Math.abs(number) * Math.pow(10, decimals)) / Math.pow(10, decimals);
        var number_string = rounded_number.toFixed(decimals);
        var parts = number_string.split('.');
        var int_part = parts[0];
        var dec_part = (parts[1] ? dec_point + parts[1] : '');

        // Thêm dấu phân cách hàng nghìn
        var pattern = /(\d+)(\d{3})/;
        while (pattern.test(int_part)) {
            int_part = int_part.replace(pattern, '$1' + thousands_sep + '$2');
        }

        // Định dạng cuối cùng
        return (number < 0 ? '-' : '') + int_part + dec_part;
    }

})
