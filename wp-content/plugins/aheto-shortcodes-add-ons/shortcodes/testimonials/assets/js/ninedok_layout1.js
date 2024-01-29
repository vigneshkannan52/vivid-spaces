;(function ($, window, document, undefined) {
    "use strict";

    $(window).on('load resize orientationchange', () => {

        if ($(window).width() > 1200) {

            let $blockOutCont = ($(window).outerWidth(true) - $('.elementor-section.elementor-section-boxed>.elementor-container').width()) / 2;

            $('.aheto-tm-wrapper--ninedok-modern .swiper').css({
                'left': $blockOutCont
            });
        } else {
            $('.aheto-tm-wrapper--ninedok-modern .swiper').css({
                'left': 0
            });
        }

    })

})(jQuery, window, document);

