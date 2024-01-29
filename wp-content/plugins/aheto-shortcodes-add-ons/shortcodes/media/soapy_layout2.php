<?php
/**
 * The Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$soapy_gallery = $this->parse_group($soapy_gallery);

if ( empty($soapy_gallery) ) {

	return '';
}
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-media-gallery');
$this->add_render_attribute('wrapper', 'class', 'aheto-soapy-gallery');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

if(isset($soapy_space) && $soapy_space == true){
	$this->add_render_attribute('wrapper', 'class', 'aheto-soapy-gallery--no-spaces');
}
/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/media/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
	wp_enqueue_style('soapy-media-layout2', $shortcode_dir . 'assets/css/soapy_layout2.css', null, null);
wp_enqueue_script('magnific');
wp_enqueue_script('soapy-media-layout2-js', $shortcode_dir . 'assets/js/soapy_layout2.js', array('jquery'), null);

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-soapy-gallery-img">
	<?php foreach ( $soapy_gallery as $index => $item ) :
		$background_image = \Aheto\Helper::get_background_attachment($item['soapy_image'], $atts['soapy_media_image_size'], $atts, 'soapy_media_');
		if ( !empty($item['soapy_image']) ) :?>
			<figure data-mfp-src="<?php echo esc_url($item['soapy_image']['url']); ?>" class="aheto-media-gallery__item grid-item">
                <span <?php echo esc_attr($background_image); ?>></span>
			</figure>
		<?php endif; ?>
	<?php endforeach; ?>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/soapy_layout2.css'?>" rel="stylesheet">
	<script>
; (function ($, window, document, undefined) {
	"use strict";
	function soapy_popup() {
		if ($('.aheto-soapy-gallery-img').length)  {
			$('.aheto-soapy-gallery-img').magnificPopup({
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
		let parent = $('.grid-item').closest('.aheto-soapy-gallery-img');

		if (parent.find('.hide-item').length >= 6) {
			parent.find('.hide-item').slice(0, 6).removeClass('hide-item');
		} else {
			parent.find('.hide-item').removeClass('hide-item');
		}
	}

	showGallery();

	$(window).on('load', function () {
		soapy_popup();

		let checkItem = $('.grid-item').closest('.aheto-soapy-gallery-img');

		checkItem.find('.hide-item').length == 0 ? $('.aheto-soapy-gallery-button').hide() : $('.aheto-soapy-gallery-button').show();
	});

})(jQuery, window, document);
	</script>
	<?php
endif;