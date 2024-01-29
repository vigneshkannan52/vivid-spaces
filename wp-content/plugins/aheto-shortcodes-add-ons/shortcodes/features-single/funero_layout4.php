<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-content-block--funero-big');
/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/features-single/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
	wp_enqueue_style('funero-features-single-layout4', $shortcode_dir . 'assets/css/funero_layout4.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php
	$background_image = '';
	if ( !empty($funero_image) ):
		$background_image = Helper::get_background_attachment($funero_image, $image_size, $atts);

	endif; ?>
	<div class="aheto-content-block__image-wrap " <?php echo esc_attr($background_image); ?>>
	</div>
	<div class="aheto-content-block__text-wrap">
		<?php if ( !empty($funero_image_bg) ) :
			$b_background_image = Helper::get_background_attachment($funero_image_bg, 'thumbnail', $atts);
			?>
			<div class="aheto-content-block__border aheto-content-block__border-tl" <?php echo esc_attr($b_background_image); ?>></div>
			<div class="aheto-content-block__border aheto-content-block__border-tr" <?php echo esc_attr($b_background_image); ?>></div>
			<div class="aheto-content-block__border aheto-content-block__border-bl" <?php echo esc_attr($b_background_image); ?>></div>
			<div class="aheto-content-block__border aheto-content-block__border-br" <?php echo esc_attr($b_background_image); ?>></div>
		<?php endif; ?>
		<?php if ( !empty($funero_subtitle) ) : ?>
			<p class="aheto-content-block__subtitle "><?php echo esc_html($funero_subtitle); ?></p>
		<?php endif; ?>
		<?php if ( !empty($funero_title) ) : ?>
			<h6 class="aheto-content-block__title "><?php echo esc_html($funero_title); ?></h6>
		<?php endif; ?>
		<?php if ( !empty($funero_desc) ) : ?>
			<p class="aheto-content-block__desc "><?php echo esc_html($funero_desc); ?></p>
		<?php endif; ?>
		<?php if ( !empty($funero_link_title) && !empty($funero_link_url['url']) ) :
			if ( !empty($funero_link_url['is_external']) ) {
				$target = 'target="_blank"';
			} else {
				$target = 'target="_self"';
			}
			?>
			<a href="<?php echo esc_url($funero_link_url['url']); ?>" <?php echo esc_attr($target); ?>
			   class="aheto-content-block__link "><?php echo esc_html($funero_link_title); ?></a>
		<?php endif; ?>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/funero_layout4.css'?>" rel="stylesheet">
	<?php
endif;