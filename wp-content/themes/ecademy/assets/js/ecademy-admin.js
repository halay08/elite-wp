(function($){
    "use strict";
    // Hook into the "notice-my-class" class we added to the notice, so
    // Only listen to YOUR notices being dismissed
    $(document).ready( function() {
        $('.ecademy-purchase-notice .notice-dismiss').on('click', function() {
            let url = new URL(location.href);
            url.searchParams.append('dismissed', 1);
            location.href = url;
        });
        $('.ecademy-plugin-purchase-notice .notice-dismiss').on('click', function() {
            let url = new URL(location.href);
            url.searchParams.append('plugin_dismissed', 1);
            location.href = url;
        })
    });

})(jQuery);

jQuery(document).ready(function ($) {
    $('body').on('change', '#post-format-selector-0', function () {
        var metaboxes = $('#fw-backend-option-fw-option-video_url, #fw-backend-option-fw-option-soundcloud_embed, #fw-backend-option-fw-option-gallery_images')
        metaboxes.hide();
        var format_metaboxes = {
            video: 'video_url',
            audio: 'soundcloud_embed',
            gallery: 'gallery_images',
        };
        var selected_format = $(this).val();
        $('#fw-backend-option-fw-option-' + format_metaboxes[selected_format]).show();
    });
    for (let index = 0; index < 5; index++) {
        setTimeout(() => {
            $('#post-format-selector-0').trigger('change');
        }, 1000);
        console.log(index);
    }
});