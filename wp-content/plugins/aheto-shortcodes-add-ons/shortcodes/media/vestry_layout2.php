<?php

/**
 * The Vestry Media Shortcode.
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $vestry_image ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto_media--vestry' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
wp_enqueue_script( 'magnific' );
wp_enqueue_script( 'isotope' );

$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'vestry-media-layout2', $shortcode_dir . 'assets/css/vestry_layout2.css', null, null );
}
wp_enqueue_script( 'vestry-media-layout2-js', $shortcode_dir . 'assets/js/vestry_layout2.js', array( 'jquery' ), null );

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<?php
	$show_all = $vestry_all_item ? '' : 'hide-item';
	?>
    <div class="aheto-vestry-gallery-img">
        <div class="grid-sizer"></div>
		<?php
		$counter = 1;

		foreach ( $vestry_image as $image ) {
			$image_id         = is_array( $image ) && ! empty( $image['id'] ) ? $image['id'] : $image;
			$image_url        = wp_get_attachment_image_url( $image_id, 'full' );
			$background_image = Helper::get_background_attachment( $image, $vestry_image_size, $atts, 'vestry_' ); ?>
            <figure data-mfp-src="<?php echo esc_url( $image_url ) ?>"
                    class="grid-item <?php echo esc_attr( $show_all ); ?>">
                <span <?php echo esc_attr( $background_image ); ?>></span>
            </figure>
			<?php
		} ?>
    </div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/vestry_layout2.css'?>" rel="stylesheet">
	<script>
; (function ($, window, document, undefined) {
    "use strict";

    function vestry_gallery() {
        if ($('.aheto-vestry-gallery-img').length) {
            $('.aheto-vestry-gallery-img').isotope({
                itemSelector: '.grid-item',
                percentPosition: true,
                masonry: {
                    columnWidth: '.grid-sizer'
                }
            })
        }

    }

    function vestry_popup() {
        if ($('.aheto-vestry-gallery-img').length) {
            $('.aheto-vestry-gallery-img').magnificPopup({
                delegate: 'figure',
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                }
            });
        }
    }

    function showGallery() {
        let parent = $('.grid-item').closest('.aheto-vestry-gallery-img');

        if (parent.find('.hide-item').length >= 6) {
            parent.find('.hide-item').slice(0, 6).removeClass('hide-item');
        } else {
            parent.find('.hide-item').removeClass('hide-item');
        }
    }

    showGallery();

    $(window).on('load resize orientationchange', function () {
        vestry_gallery();
    });


    $(window).on('load', function () {
        vestry_popup();

        let checkItem = $('.grid-item').closest('.aheto-vestry-gallery-img');

        checkItem.find('.hide-item').length == 0 ? $('.aheto-vestry-gallery-button').hide() : $('.aheto-vestry-gallery-button').show();
    });

})(jQuery, window, document);
	</script>
	<?php
endif;