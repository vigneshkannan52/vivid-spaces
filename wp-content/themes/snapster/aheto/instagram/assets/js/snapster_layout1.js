;(function ($, window, document) {
    "use strict";

    function snapster_instagram(){
        const instagram = $('.aheto-instagram--snapster-list .js-instagram');

        if (instagram.length) {
            instagram.each(function () {
                const token = $(this).attr('data-token');
                const size  = $(this).attr('data-size');
                const max   = +$(this).attr('data-max') || 6;

                $.fn.spectragram.accessData = {
                    accessToken: token
                };

                $(this).spectragram('getUserFeed', {
                    size: size,
                    max: max,
                    accessToken: token
                });
            });
        }
    }

    $( () => {
        snapster_instagram();
    });


    if (window.elementorFrontend) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/widget', (scope) => {
            const widgetName = scope.context.dataset.widget_type;
            if (widgetName.indexOf('instagram') > -1) {
                snapster_instagram();
            }
        });
    }

})(jQuery, window, document);
