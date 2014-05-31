jQuery(document).ready(function($) {
    "use strict";

    var hidden_logo_url = $('.lmub #hidden_logo_url');
    var uploadimg = $('.lmub img');

    // logo regular - media upload script
    $('.lmub #button').click(function() {
        var xthis = this;
        if (hidden_logo_url.val() == '') {
            tb_show('Upload an image', 'media-upload.php?referer=lana_page&type=image&TB_iframe=true&post_id=0', false);
            window.send_to_editor = function(html) {
                var image_url = $('img', html).attr('src');
                hidden_logo_url.val(image_url);
                tb_remove();
                uploadimg.attr('src', image_url);
                $(xthis).val('Remove');
            };
            return false;
        } else {
            hidden_logo_url.val('');
            uploadimg.attr('src', '');
            $(this).val('Upload');
        }
    });
});