
$(document).ready(function() {

    var total =  $("#total_cart");

   if (serviceFeeDefault){
       let wardElement = $("#ward");
       let url = wardElement.data('url')
       let Ward = wardElement.val();
       let parts = Ward.split(' - ');
       let WardCode = parts[0].trim();

       let DistrictID = wardElement.find('option:selected').data('id');

       console.log(DistrictID);
       if (WardCode){
           serviceFee(url,WardCode,DistrictID);
       }
   }

    function serviceFee(URL,WardCode,DistrictID){
        $.ajax({
            url: URL,
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:JSON.stringify({
                ward_code: WardCode,
                district_id: DistrictID,
            }),
            success: function (response) {
                $("#service_fee").html(number_format(response.transport_fee, 0, '.', ','))
                total.html(number_format(response.total, 0, '.', ','));
                displayVoucher(true);
            },
            error: function (xhr, status, error) {
                alert('Có lỗi xảy ra khi lấy dữ liệu từ bên vận chuyển !');
            }
        });
    }

    $(".voucher_apply").on('click',function (){

        let url = $(this).data('url');

        let voucher_id = $(this).val();

        let total_cart = total.data('total');

       if(voucher_id){
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify({
                    voucher_id: voucher_id,
                    total : total_cart,
                }),
                success: function (response) {
                    if(response.message){
                      $("#voucher_fee").html('- '+number_format(response.price_after_apply));
                      total.html(number_format(response.total_after_apply));
                      total.data('total',+response.total_after_apply);
                    }
                    hideVoucher();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Có lỗi xảy ra khi lấy mã giảm giá !');
                }
            });

       }
    });

    function hideVoucher(){
        $("#page-header-voucher-dropdown").click();
    }

    $("#province").on("change",function (){
        let url = $(this).data('url');
        let province = $(this).val();
        let parts = province.split(' - ');
        let province_id = parts[0].trim();

        if (province_id != 0){
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'Content-Type' : 'application/json',

                },
                data:JSON.stringify({
                    province_id: province_id
                }),
                success: function (response) {
                    renderDistrictOptions(response.data);
                    displayVoucher(false);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Có lỗi xảy ra khi lấy dữ liệu quận huyện!');
                }
            });
        }else{
            reset($(this));
            displayVoucher(false);
        }

    })

    $("#district").on("change",function (){
        let url = $(this).data('url');
        let district = $(this).val();
        let parts = district.split(' - ');
        let district_id = parts[0].trim();

        if (district_id != 0) {
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                data: JSON.stringify({
                    district_id: district_id
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

    $("#ward").on("change",function (){
        let url = $(this).data('url')
        let Ward = $(this).val();
        let parts = Ward.split(' - ');
        let WardCode = parts[0].trim();

        let DistrictID = $(this).find('option:selected').data('id');

        console.log(DistrictID);
        if (WardCode){
            serviceFee(url,WardCode,DistrictID);
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
        optionsHtml += `<option value="${item.WardCode} - ${item.WardName}" data-id="${item.DistrictID}">${item.WardName}</option>`;
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


    function displayVoucher(display = false){
       let voucher_table = $("#voucher_table");
       let voucher_alert = voucher_table.find("#voucher-alert");
       let voucher_public = voucher_table.find("#voucher-public");
        if (display){
            voucher_public.css('display', '');
            voucher_alert.css('display', 'none');
        }else {
            voucher_public.css('display', 'none');
            resetVoucherSelection();
            voucher_alert.css('display', '');
        }
    }

    function resetVoucherSelection() {

        $("#service_fee").html('0.00');

        $("#voucher_fee").html('0.00');

        $(".voucher_apply").prop('checked', false);
    }

})
