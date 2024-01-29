;(function($) {
    'use strict';

    // wordpress image uploader
    (function() {
        var frame;
        var $wrapper = $('.whizzy-pro--image-uploader');
        var $addImage = $wrapper.find('.upload-wp-image');
        var $imageAttr = $wrapper.find('.image-wp-image');
        var $imgInput = $wrapper.find('.input-wp-image');

        $addImage.on('click', function(e) {
            e.preventDefault();

            if (frame) { // If the media frame already exists, reopen it.
                frame.open();
                return;
            }

            // Create a new media frame
            frame = wp.media({
                title: 'Select or Upload Media Of Your Chosen Persuasion',
                button: {text: 'Use this media'},
                multiple: false // Set to true to allow multiple files to be selected
            });

            // When an image is selected in the media frame...
            frame.on('select', function() {
                // Get media attachment details from the frame state
                var attachment = frame.state().get('selection').first().toJSON();

                // Send the attachment URL to our custom image input field.
                $imageAttr.attr('src', attachment.url);

                // Send the attachment id to our hidden input
                $imgInput.val(attachment.id).trigger('change');
            });

            // Finally, open the modal on click
            frame.open();
        });
    })();

    // watermark editor
    (function() {
        $('#watermark-form').find('input, select').on('change', function() {
            var text = $('#watermark-field-text').val();

            if (text === '') {
                return;
            }

            $.ajax({
                url: ajaxurl,
                method: 'post',
                data: {
                    text: text,
                    type: $('#watermark-type').val(),
                    nonce: $('#watermark-field-nonce').val(),
                    action: 'whizzy-watermark-image',
                    font: $('#watermark-field-font').val(),
                    position: $('#watermark-field-position').val(),
                    font_size: $('#watermark-field-font-size').val(),
                    watermark_image: $('#watermark-image-preview-input').val(),
                    offsetx: $('#watermark-field-offsetx').val(),
                    offsety: $('#watermark-field-offsety').val(),
                    opacity: $('#watermark-field-opacity').val(),
                    color: $('#watermark-field-color').val()
                },
                beforeSend: function() {
                    $('.wew-preloader-wrapper .loader-wrap').removeClass('hidden');
                },
                success: function(res) {
                    if (true === res.status) {
                        $('#watermark-image-show').attr('src', res.img_url);
                    }
                },
                complete: function() {
                    $('.wew-preloader-wrapper .loader-wrap').addClass('hidden');
                }
            });
        });
    })();

    // Active Text or Image
    $('.wew-types div').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');

        if ( $(this).html() === 'Image' ) {
            $('.wew-hide-for-image').addClass('active');
            $('.wew-hide-for-text').removeClass('active');
            $('#watermark-type').val('image').trigger('change');
        } else {
            $('#watermark-type').val('text').trigger('change');
            $('.wew-hide-for-text').addClass('active');
            $('.wew-hide-for-image').removeClass('active');
        }
    });


    // Input font-size val
    function fontSizeWatermark() {
        var fontSize = $('.wew-content #watermark-field-font-size').val();
        $('.wew-content .wew-fontsize').html(fontSize);
    }
    fontSizeWatermark();

    $('.wew-content #watermark-field-font-size').on('change', function() {
        fontSizeWatermark();
    });

    //Input opacity val
    function opacityWatermark() {
        var opacity = $('.wew-content #watermark-field-opacity').val();
        $('.wew-content .wew-opacity').html(opacity  + '%');
    }
    opacityWatermark();

    $('.wew-content #watermark-field-opacity').on('change', function() {
        opacityWatermark();
    });

    // active default position
    (function() {
        var position = $('#watermark-field-position').val();

        $('.wew-position-wrapper .wew-position[data-position="'+ position +'"]').addClass('active');
    })();

    // Choosing of position
    $('.wew-position-wrapper .wew-position').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
        $('#watermark-field-position').val($(this).data('position')).trigger('change');
    });

})(jQuery);