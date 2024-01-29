;(function ($, window, document, undefined) {
    'use strict';

    function hryzantema_banner_slider_height(){

        if($('.hryzantema-full-min-height-js').length){

            const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
            let adminBarH = $('body.admin-bar').length ? 32 : 0;
            if($(window).width() < 768) {
                adminBarH = $('body.admin-bar').length ? 46 : 0;
            }
            let headerH = header.length ? header.outerHeight() : 0;

            $('.hryzantema-full-min-height-js').css('min-height', $(window).outerHeight() - headerH );

        }
    }

    $(window).on('load resize orientationchange', function () {
        if ($(this).width() > 768) {
            hryzantema_banner_slider_height();
        }
    });


})(jQuery, window, document);
