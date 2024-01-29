;(function ($, window, document, undefined) {

    'use strict';


    var wrap = $(".aheto-features-tabs-wrap-js");
    var block = $(".tab-lists-split-js");
    var img = $(".tab-img-split-js");
    block.length && block.each(function () {
        var a = $(this);
        a.on("mousemove", function (e) {
            let active = $(this).data("item");
            if (!$(this).hasClass('active')) {
                block.removeClass("active");
                img.removeClass("active");
                img.removeClass("prev");
                wrap.find('[data-img="' + active + '"]').addClass('active');
                if ((active - 1) !== -1) {
                    wrap.find('[data-img="' + (active - 1) + '"]').addClass('prev');
                } else {
                    wrap.find('[data-img="' + (img.length - 1) + '"]').addClass('prev');
                }
                $(this).addClass('active');
            }



        });
    });

})(jQuery, window, document);
