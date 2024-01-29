<?php
/**
 * About default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($token) || empty ($username) ) {
	return;
}

$this->generate_css();


$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-instagram--mooseoom-list');
$this->add_render_attribute('instagram', 'class', 'mooseoom-instagram');
$this->add_render_attribute('instagram', 'data-token', $token);
$this->add_render_attribute('instagram', 'data-size', $size);
$this->add_render_attribute('instagram', 'data-max', $limit);
$this->add_render_attribute('instagram', 'data-id', $atts['_id']);


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/instagram/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
	wp_enqueue_style( 'mooseoom-instagram-layout1', $shortcode_dir . 'assets/css/mooseoom_layout1.css', null, null );
}

global $wp;

if ( empty( $_GET['elementor-preview'] )  ) {
	wp_enqueue_script( 'mooseoom-instagram-layout1-js', $shortcode_dir . 'assets/js/mooseoom_layout1.js', array( 'jquery' ), null );
}
?>


<div <?php $this->render_attribute_string('wrapper'); ?>>

	<ul <?php $this->render_attribute_string('instagram'); ?>></ul>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/mooseoom_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document) {
	"use strict";
	const instagram = $('.mooseoom-instagram');

	function getParamsInstagram() {
		if (instagram.length) {
			instagram.each(function () {
				const max   = +$(this).attr('data-max') || 6;
				const token = $(this).attr('data-token');
				const size  = $(this).attr('data-size');

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
	$(window).on('load', function () {
		getParamsInstagram();
	});
	

})(jQuery, window, document);
	</script>
	<?php
endif;