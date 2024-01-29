<?php
/**
 * The Noize Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($noize_image) ) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto_media--noize' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/media/';
wp_enqueue_script( 'magnific' );
wp_enqueue_script( 'isotope' );

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( empty($custom_css) || ($custom_css == "disabled") ) {
    wp_enqueue_style( 'noize-media-layout1', $shortcode_dir . 'assets/css/noize_layout1.css', null, null );
}

wp_enqueue_script( 'noize-media-layout1-js', $shortcode_dir . 'assets/js/noize_layout1.js', array( 'jquery' ), null );

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto_media--noize-img">
        <div class="grid-sizer"></div>
        <?php
            $counter = 1;

            foreach ($noize_image as $image) {
                $hide_item = $counter > 6 && $noize_load_add_button ? 'hide-item' : '';
                $image_id = is_array( $image ) && ! empty( $image['id'] ) ? $image['id'] : $image;
                $image_url = wp_get_attachment_image_url( $image_id, 'full' );
                $background_image = Helper::get_background_attachment($image, $noize_image_size, $atts, 'noize_');
        ?>
            <a href="<?php echo esc_url($image_url) ?>" class="grid-item <?php echo esc_attr($hide_item); ?>">
                <span <?php echo esc_attr($background_image); ?>></span>
            </a>
        <?php
            $counter++;
        } ?>
    </div>

    <?php if ( $noize_load_add_button ) { ?>
        <div class="aheto_media--noize-btn <?php echo esc_attr($this->atts['noize_align']); ?>">
            <?php echo \Aheto\Helper::get_button($this, $atts, 'noize_load_'); ?>
        </div>
    <?php } ?>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/noize_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    "use strict";

    function noize_gallery () {
        if ( $('.aheto_media--noize-img').length ) {
            $('.aheto_media--noize-img').isotope({
                itemSelector: '.grid-item',
                percentPosition: true,
                masonry: {
                    // use outer width of grid-sizer for columnWidth
                    columnWidth: '.grid-sizer'
                }
            })
        }
    }

    function noize_popup() {
        if ($('.aheto_media--noize-img').length) {
            $('.aheto_media--noize-img').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                }
            });
        }
    }

    $('.aheto_media--noize-btn .cs-btn').on('click', function (e) {
        e.preventDefault();

        let parent = $('.grid-item').closest('.aheto_media--noize-img');

        if ( parent.find('.hide-item').length >= 6 ){
            parent.find('.hide-item').slice(0, 6).removeClass('hide-item');
            $(this).hide();
        } else {
            parent.find('.hide-item').removeClass('hide-item');
            $(this).hide();
        }

        noize_gallery();
    });

    $(window).on('load resize orientationchange', function() {
        noize_gallery();
    });

    $(window).on('load', function() {
        noize_popup();

        let checkItem = $('.grid-item').closest('.aheto_media--noize-img');

        checkItem.find('.hide-item').length == 0 ? $('.aheto_media--noize-btn .cs-btn').hide() : $('.aheto_media--noize-btn .cs-btn').show();
    });

})(jQuery, window, document);
	</script>
	<?php
endif;