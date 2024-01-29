;(function ($, window, document, undefined) {
    'use strict';

    /* Copyright */
    if ($('.snapster_copyright_overlay').length) {
        $(document).on('contextmenu', function (event) {
            if ($('.snapster_copyright_overlay').hasClass('copy')) {
                event.preventDefault();
            } else if (event.target.tagName != 'A') {
                event.preventDefault();
            }
            $('.snapster_copyright_overlay').addClass('active');
        }).on('click', function () {
            $('.snapster_copyright_overlay').removeClass('active').removeAttr('style');
        });
    }

})(jQuery, window, document);