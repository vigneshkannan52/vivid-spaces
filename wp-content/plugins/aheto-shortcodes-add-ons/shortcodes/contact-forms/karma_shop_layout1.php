<?php
/**
 * Contact Forms default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto__cf--line-karma_shop');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
/**
 * Set dependent style
 */

$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contact-forms/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
	wp_enqueue_style('karma_shop-contact-forms-layout1', $shortcode_dir . 'assets/css/karma_shop_layout1.css', null, null);
}
wp_enqueue_script('karma_shop-contact-forms-layout1-js', $shortcode_dir . 'assets/js/karma_shop_layout1.min.js', array('jquery'), null);

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="widget_aheto__form">

		<?php if ( !empty($karma_shop_title) ) : ?>
			<div class="widget_aheto__form-title"><?php echo esc_html($karma_shop_title); ?></div>
		<?php endif; ?>
		<?php if ( !empty($contact_form) ) : ?>

			<div class="widget_aheto__form-wrap <?php echo Helper::get_button($this, $atts, 'form_', true); ?>">
				<?php echo do_shortcode('[contact-form-7 id="' . esc_attr($contact_form) . '"]'); ?>
			</div>

		<?php endif; ?>

	</div>

</div>

