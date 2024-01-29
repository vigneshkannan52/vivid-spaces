;(function ($, window, document, undefined) {
    'use strict';

    function acacio_banner_slider_height(){

        if($('.acacio-full-min-height-js').length){

            const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
            let headerH = header.length ? header.outerHeight() : 0;

            $('.acacio-full-min-height-js').css('min-height', $(window).outerHeight() - headerH );
        }
    }

    $(window).on('load resize orientationchange', function () {
        if ($(window).width() > 768) {
            acacio_banner_slider_height();
        }
    });

})(jQuery, window, document);
