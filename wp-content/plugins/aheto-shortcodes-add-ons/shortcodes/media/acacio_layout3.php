<?php
/**
 * The Acacio Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($acacio_image) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style( 'acacio-media-layout3', $shortcode_dir . 'assets/css/acacio_layout3.css', null, null );
}
wp_enqueue_script( 'acacio-media-layout3-js', $shortcode_dir . 'assets/js/acacio_layout3.js', array( 'jquery' ), null );


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <?php if (isset($acacio_image) && !empty($acacio_image) ) : ?>
        <?php $gallery_img =  \Aheto\Helper::get_background_attachment( $acacio_image, $acacio_image_size, $atts, 'acacio_' ); ?>
    <?php endif; ?>

    <div class="aheto-single-gallery-img" <?php echo esc_attr($gallery_img) ?>></div>

    <div class="aheto-single-gallery-popup">
        <?php if (isset($acacio_image) && !empty($acacio_image) ) : ?>
            <?php echo \Aheto\Helper::get_attachment( $acacio_image, ['class' => ''], $acacio_image_size, $atts, 'acacio_' ); ?>
        <?php endif; ?>
        <h3 class='close'>&times;</h3>
    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/acacio_layout3.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
	'use strict';

		$(window).on('load', function () {
			let imageBlock = $('.aheto-single-gallery-img');
			let closePopup = $('.aheto-single-gallery-popup .close');
			imageBlock.on('click', function () {
				let imageUrl = $(this).find('img').attr('src');

				$(this).next().find('img').attr('src', imageUrl);
				$(this).next().fadeIn();
			});
			closePopup.on('click', function () {
				$(this).parent().fadeOut();
			})
		});

})(jQuery, window, document);
	</script>
	<?php
endif;