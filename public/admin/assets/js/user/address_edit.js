$(document).ready(function () {
    $.ajax({
        url: '/api/provinces',
        method: 'GET',
        success: function (data) {
            var options = '<option value="">Chọn Tỉnh / Thành phố</option>';
            $.each(data, function (key, value) {
                options += '<option value="' + value.ProvinceID + '">' + value.ProvinceName + '</option>';
            });
            $('#province_id').html(options);
            var selectedProvinceId = "{{ old('province_id', $user->province_id) }}";
            if (selectedProvinceId) {
                $('#province_id').val(selectedProvinceId).trigger('change');
            }
        }
    });

    // Khi tỉnh/thành phố được chọn
    $('#province_id').change(function () {
        var provinceId = $(this).val();
        if (provinceId) {
            $.ajax({
                url: '/api/districts/' + provinceId, // Đảm bảo URL API đúng
                method: 'GET',
                success: function (data) {
                    var options = '<option value="">Chọn Quận / Huyện</option>';
                    $.each(data, function (key, value) {
                        options += '<option value="' + value.DistrictID + '">' + value.DistrictName + '</option>';
                    });
                    $('#district_id').html(options);

                    // Load ward if user has it
                    var selectedDistrictId = "{{ old('district_id', $user->district_id) }}";
                    if (selectedDistrictId) {
                        $('#district_id').val(selectedDistrictId).trigger('change');
                    }
                }
            });
        } else {
            $('#district_id').html('<option value="">Chọn Quận / Huyện</option>');
            $('#ward_id').html('<option value="">Chọn Xã / Phường</option>');
        }
    });

    // Khi quận/huyện được chọn
    $('#district_id').change(function () {
        var districtId = $(this).val();
        if (districtId) {
            $.ajax({
                url: '/api/wards/' + districtId, // Đảm bảo URL API đúng
                method: 'GET',
                success: function (data) {
                    var options = '<option value="">Chọn Xã / Phường</option>';
                    $.each(data, function (key, value) {
                        options += '<option value="' + value.id + '">' + value.WardName + '</option>';
                    });
                    $('#ward_id').html(options);
                    var selectedWardId = "{{ old('ward_id', $user->ward_id) }}";
                    if (selectedWardId) {
                        $('#ward_id').val(selectedWardId);
                    }
                }
            });
        } else {
            $('#ward_id').html('<option value="">Chọn Xã / Phường</option>');
        }
    });

    // Khởi tạo File Manager
    var lfm = $('#lfm').filemanager('image');
});
