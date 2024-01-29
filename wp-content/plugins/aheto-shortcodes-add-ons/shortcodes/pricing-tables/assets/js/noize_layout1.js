;(function ($, window, document, undefined) {
    "use strict";

    const $isotope = $('.aheto-pricing-tables--noize-lay1 .aheto-pricing-tables--noize-lay1__content');

    if ( window.elementorFrontend ) {
        isotopeInit();
    }

    $( () => {

        $('.aheto-pricing-tables--noize-lay1 .aheto-pricing-tables--noize-lay1__list-item a').on('click', function () {

            $('.aheto-pricing-tables--noize-lay1 .aheto-pricing-tables--noize-lay1__list-item a').removeClass('active');

            $(this).addClass('active');

            let filterValue = $(this).attr('data-pricing-filter');

            if ($isotope.length) {
                $isotope.isotope({
                    filter: filterValue
                });
            }

        });
    });

    function isotopeInit() {
        if ($isotope.length) {
            $isotope.each(function () {
                $(this).isotope({
                    itemSelector: '.js-isotope-box',
                    layoutMode: 'masonry',
                    percentPosition: true,
                    masonry: {
                        gutter: 15
                    }
                })
            });
        }
    }

    $(window).on('load', () => {
        isotopeInit();
    });

    if (window.elementorFrontend && ( window.location.href.indexOf("elementor-preview") > -1 ) ) {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
            var  widget_name = $scope.context.dataset.widget_type;
            if ( widget_name.indexOf('pricing-tables') > -1  ) {
                init_map();
            }
        } );
    }

})(jQuery, window, document);