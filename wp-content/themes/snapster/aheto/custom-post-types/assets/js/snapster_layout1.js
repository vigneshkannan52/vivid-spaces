; (function ($, window, document, undefined) {
    "use strict";

    $( ".aheto-cpt--snapster-slider-thumb .js-thumbs-switcher" ).on('click', function(){

        const parent = $(this).closest('.aheto-cpt--snapster-slider-thumb');

        parent.find( ".swiper-bottom" ).toggleClass("thumbs-hide");
        parent.find( ".aheto-cpt--slider-content" ).toggleClass("content-slide");

    });

    function snapster_cpt_height(){

        if($('.aheto-cpt--snapster-slider-thumb .snapster-full-min-height-js').length){

            const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
            let adminBarH = $('body.admin-bar').length ? 32 : 0;
            let headerH = header.length ? header.outerHeight() : 0;

            $('.aheto-cpt--snapster-slider-thumb .snapster-full-min-height-js').css('min-height', $(window).innerHeight() - headerH - adminBarH );

        }
    }

    $(window).on('load resize orientationchange', function () {

        snapster_cpt_height();

    });

    if ( window.elementorFrontend ) {
        snapster_cpt_height();
    }


})(jQuery, window, document);