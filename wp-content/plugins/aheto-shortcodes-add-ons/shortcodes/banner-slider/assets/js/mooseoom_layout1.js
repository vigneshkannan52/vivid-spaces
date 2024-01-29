;(function ($, window, document, undefined) {
    'use strict';

    function banner_slider_height(){
        if($('.mooseoom-full-min-height-js').length){
            const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
            let adminBarH = $('body.admin-bar').length ? 32 : 0;
            let headerH = header.length ? header.outerHeight() : 0;
            $('.mooseoom-full-min-height-js').css('min-height', $(window).innerHeight() - headerH - adminBarH );
        }
    }

    //Add dark arrows to slider
    function darkArrowsSlider() {
        $('.aheto-banner-slider--mooseoom-modern').each(function () {
            if ($(this).hasClass('banner-dark')) {
                $(this).find('div.swiper-button-prev').addClass('dark');
                $(this).find('div.swiper-button-next').addClass('dark');
            }
        });
    }


    $(window).on('load', function () {
        darkArrowsSlider();
    });

    $(window).on('load resize orientationchange', function () {
        banner_slider_height();
    });

})(jQuery, window, document);
