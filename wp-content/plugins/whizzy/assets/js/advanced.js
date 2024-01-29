;(function($) {
    'use strict';

    // comments for gallery
    (function() {
        var $body = $('body');
        var $lightGallery = $('.js-whizzy-gallery.lightpopup');
        var $magnificGallery = $('.js-whizzy-gallery:not(.lightpopup)');
        var attachmentId = null;

        $lightGallery.on('onAfterOpen.lg', function() {
            $('.lg-toolbar').append('<span class="whizzy-open-photo-comments lg-icon fa fa-comments"></span>');
        });
        $lightGallery.on('onBeforeSlide.lg', function(e, prevIndex, index) {
            attachmentId = $lightGallery.find('.js-proof-photo').eq(index).data('attachment_id');
        });

        $magnificGallery.on('mfpOpen', function() {
            $('.mfp-figure').prepend('<button type="button" class="whizzy-open-photo-comments magnific"><i class="fa fa-comments"></i></button>');
        });
        $magnificGallery.on('mfpChange', function() {
            var index = $.magnificPopup.instance.currItem.index;

            attachmentId = $magnificGallery.find('.js-proof-photo').eq(index).data('attachment_id');
        });

        $body.on('click', '.whizzy-open-photo-comments', function() {
            getPhotoComments();
        });
        $body.on('click', '.whizzy-popup-close', function() {
            $('.whizzy-popup-wrapper').addClass('hidden');
            $('.whiizy-pro--comments-list-container').empty();
            $('body').css('overflow', '');
        });
        $body.on('submit', '#whizzy-photo-comments-form', function(e) {
            e.preventDefault();

            var $form = $(this);
            var $btn = $form.find('button');
            var btnText = $btn.text();
            var formData = new FormData($form[0]);
                formData.append('attachment_id', attachmentId);

            $.ajax({
                url: whizzy.ajaxurl,
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $form.find('.errors-list').html('').addClass('hidden');
                    $btn.html('<div class="whizzy-load-speeding-wheel button"></div>');
                },
                success: function(res) {
                    if (true === res.status) {
                        getPhotoComments();
                        $form.find('input[type="text"], input[type="email"], textarea').val('');
                    } else {
                        $form.find('.errors-list').html(res.msg).removeClass('hidden');
                    }
                },
                complete: function() {
                    $btn.html(btnText);
                }
            });
        });

        var getPhotoComments = function() {
            $.ajax({
                url: whizzy.ajaxurl,
                method: 'get',
                data: {
                    action: 'whizzy-get-photo-comments',
                    attachment_id: attachmentId
                },
                beforeSend: function() {
                    $('#whizzy-pro--loader').removeClass('hidden');
                },
                success: function(res) {
                    $('.whiizy-pro--comments-list-container').html(res);
                    $('.popup-scroll').animate({scrollTop: 0}, 'slow');
                },
                complete: function() {
                    $('body').css('overflow', 'hidden');
                    $('#whizzy-pro--loader').addClass('hidden');
                    $('.whizzy-popup-wrapper').removeClass('hidden');
                }
            });
        };

    })();

    // approve gallery
    (function() {
        $('.whizzy-pro--approve-gallery').on('click', function(e) {
            e.preventDefault();

            var $btn = $(this);
            var btnText = $btn.html();

            $.ajax({
                url: whizzy.ajaxurl,
                method: 'post',
                data: {
                    action: 'whizzy-approve-galley',
                    gallery_id: $btn.data('id'),
                    nonce: $btn.data('nonce')
                },
                beforeSend: function() {
                    $btn.html('<div class="whizzy-load-speeding-wheel button small"></div>');
                },
                success: function(res) {
                    $btn.html(btnText);
                    $btn.find('em').addClass('hidden');

                    if (true === res) {
                        $btn.attr('disabled', 'disabled');
                        $btn.find('em').last().removeClass('hidden');
                    } else {
                        $btn.find('em').first().removeClass('hidden');
                    }
                }
            });
        });
    })();

    // login
    (function() {
        $('#whizzy-pro--login').on('submit', function(e) {
            e.preventDefault();

            var $form = $(this);
            var $btn = $form.find('button');
            var btnText = $btn.text();
            var formData = new FormData($form[0]);

            $.ajax({
                url: whizzy.ajaxurl,
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $btn.html('<div class="whizzy-load-speeding-wheel button black"></div>');
                    $form.find('.errors-list').html('').addClass('hidden');
                },
                success: function(res) {
                    if (true === res.status) {
                        window.location.href = res.redirect_to;
                    } else {
                        $form.find('.errors-list').html(res.msg).removeClass('hidden');
                    }
                },
                complete: function() {
                    $btn.html(btnText);
                }
            });
        });
    })();

})(jQuery);