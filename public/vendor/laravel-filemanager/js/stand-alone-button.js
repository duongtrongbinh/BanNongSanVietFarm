(function($) {

    $.fn.filemanager = function(type, options) {
        type = type || 'file';

        this.on('click', function(e) {
            var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
            var target_input = $('#' + $(this).data('input'));
            var target_preview = $('#' + $(this).data('preview'));
            var base64_input = $('#' + $(this).data('base64')); // Trường Base64
            window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
            window.SetUrl = function(items) {
                var file_path = items.map(function(item) {
                    return item.url;
                }).join(',');

                // Cập nhật giá trị của input
                target_input.val('').val(file_path).trigger('change');

                // Cập nhật hình ảnh xem trước
                target_preview.attr('src', items[0].thumb_url); // Chỉ cập nhật hình ảnh đầu tiên trong danh sách

                // Chuyển đổi hình ảnh thành base64
                var img = new Image();
                img.src = items[0].url;
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    var base64 = canvas.toDataURL('image/png');
                    base64_input.val(base64).trigger('change');
                };

                // Trigger event cho preview
                target_preview.trigger('change');
            };
            return false;
        });
    }
})(jQuery);
