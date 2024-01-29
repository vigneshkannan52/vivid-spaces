;(function ($, window, document, undefined) {

    'use strict';

    $(document).ready(function() {
        $(".aheto-banner-slider--snapster-creative .aheto-banner__title").lettering();
    });




    let a = 0;
    $(document).ready(function() {
        animationStart();
        $('.aheto-banner-slider--snapster-creative .swiper-button-next').append('<span></span>');
        $('.aheto-banner-slider--snapster-creative .swiper-button-prev').append('<span></span>');
    }, 1000);

    $('.aheto-banner-slider--snapster-creative .swiper-button-next, .aheto-banner-slider--snapster-creative .swiper-button-prev').click(function() {
        if (a === 0) {
            a++;
            setTimeout(animation, 1000);
        }
    });


    function animation() {
        var title1 = new TimelineMax();
        title1.staggerFromTo(".aheto-banner-slider--snapster-creative .swiper-slide-visible .aheto-banner__title span", 0.5,
            {ease: Back.easeOut.config(1.2), opacity: 0, bottom: -40},
            {ease: Back.easeOut.config(1.2), opacity: 1, bottom: 0}, 0.03);
        a = 0;
    }
    function animationStart() {
        var title1 = new TimelineMax();
        title1.staggerFromTo(".aheto-banner-slider--snapster-creative .swiper-slide .aheto-banner__title span", 0.5,
            {ease: Back.easeOut.config(1.2), opacity: 0, bottom: -40},
            {ease: Back.easeOut.config(1.2), opacity: 1, bottom: 0}, 0.03);
    }



})(jQuery, window, document);