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
wp_enqueue_script( 'acacio-media-layout1-js', $shortcode_dir . 'assets/js/acacio_layout1.js', array( 'jquery' ), null );


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="aheto-single-img" data-width='<?php echo esc_attr($acacio_max_width_hide['size']) ?>'>
        <?php if (isset($acacio_image) && !empty($acacio_image)) : ?>
            <?php echo \Aheto\Helper::get_attachment( $acacio_image, ['class' => 'aheto-single-img__img'], $acacio_image_size, $atts, 'acacio_' ); ?>
        <?php endif; ?>
	</div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<script>
;(function ($, window, document, undefined) {
	'use strict';

		$(window).on('load resize', function () {
			const singleImg = $('.aheto-single-img');

			singleImg.each(function () {
				const dataWidth = $(this).data('width');

				if ($(window).width() < dataWidth) {
					$(this).fadeOut();
				} else {
					$(this).fadeIn();
				}
			})

		});

})(jQuery, window, document);
	</script>
	<?php
endif;