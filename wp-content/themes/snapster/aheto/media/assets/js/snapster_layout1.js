;(function ($, window, document) {
    "use strict";


    function napster_creative_slider() {
        if ($('.aheto-media--snapster-creative .aheto-media--slider').length) {

            $('.aheto-media--snapster-creative .aheto-media--slider').each(function () {

                let $speed = $(this).attr('data-autoplay');
                let $check_autoplay = $(this).attr('data-check');

                if ($check_autoplay == 'false') {
                    $check_autoplay = false;
                }

                let parentSlider = $(this);

                parentSlider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: $check_autoplay,
                    arrows: true,
                    fade: false,
                    adaptiveHeight: true,
                    infinite: true,
                    useTransform: true,
                    speed: $speed,
                    cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
                });

                parentSlider.next('.aheto-media--slider-nav').on('init', function (event, slick) {
                    parentSlider.next('.aheto-media--slider-nav').find('.slick-slide.slick-current').addClass('is-active');
                }).slick({
                    slidesToShow: 8,
                    slidesToScroll: 4,
                    dots: false,
                    swipe: true,
                    focusOnSelect: false,
                    infinite: true,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 6,
                                slidesToScroll: 4,
                                swipe: true,
                            }
                        },
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 4,
                                swipe: true,
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                swipe: true,
                            }
                        },
                        {
                            breakpoint: 420,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2,
                                swipe: true,
                            }
                        }]
                });


                parentSlider.on('afterChange', function (event, slick, currentSlide) {
                    parentSlider.next('.aheto-media--slider-nav').slick('slickGoTo', currentSlide);

                    let currrentNavSlideElem = '.slick-slide[data-slick-index="' + currentSlide + '"]';

                    parentSlider.next('.aheto-media--slider-nav').find('.slick-slide.is-active').removeClass('is-active');
                    parentSlider.next('.aheto-media--slider-nav').find(currrentNavSlideElem).addClass('is-active');
                });

                parentSlider.next('.aheto-media--slider-nav').on('click', '.slick-slide', function (event) {
                    event.preventDefault();

                    let goToSingleSlide = $(this).data('slick-index');

                    parentSlider.slick('slickGoTo', goToSingleSlide);
                });


            });
        }
    }

    napster_creative_slider();

    if (window.elementorFrontend) {
        napster_creative_slider();
    }


})(jQuery, window, document);