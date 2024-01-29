<?php
/**
 * The Testimonials Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$funero_testimonials_simple_item = $this->parse_group($funero_testimonials_simple_item);
if ( empty($funero_testimonials_simple_item) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--funero-arrow-bottom');


/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'          => 1500,
	'autoplay'       => 0,
	'simulate_touch' => 1,
	'loop'           => 1,
	'initial_slide'  => 0,
	'spaces'         => 25,
	'slides'         => 2,
	'arrows'         => 1,
	'direction'      => 'horizontal'
]; // will use when not chosen option 'Change slider params'
$carousel_params         = Helper::get_carousel_params($atts, 'funero_swiper_', $carousel_default_params);


$space_class = isset($funero_big_spaces) && $funero_big_spaces == true ? 'big-spaces' : '';

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/testimonials/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
	wp_enqueue_style('funero-testimonials-layout2', $shortcode_dir . 'assets/css/funero_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr($carousel_params); ?> >
			<div class="swiper-wrapper">
				<?php foreach ( $funero_testimonials_simple_item as $item ) : ?>
					<div class="swiper-slide">
						<div class="aheto-tm__content <?php echo esc_attr($space_class); ?>">
							<?php if ( !empty($item['funero_image_bg']) ) :
								$background_image = Helper::get_background_attachment($item['funero_image_bg'], 'medium_large', $atts);
								?>
								<div class="aheto-tm__border aheto-tm__border-tl" <?php echo esc_attr($background_image); ?>></div>
								<div class="aheto-tm__border aheto-tm__border-tr" <?php echo esc_attr($background_image); ?>></div>
								<div class="aheto-tm__border aheto-tm__border-bl" <?php echo esc_attr($background_image); ?>></div>
								<div class="aheto-tm__border aheto-tm__border-br" <?php echo esc_attr($background_image); ?>></div>
							<?php endif; ?>
							<?php if ( !empty($item['funero_testimonial']) ) {
								echo '<h4 class="aheto-tm__blockquote">' . esc_html($item['funero_testimonial']) . '</h4>';
							}
							if ( !empty($item['funero_name']) ) {
								echo '<p class="aheto-tm__name">' . esc_html($item['funero_name']) . '</p>';
							}
							if ( !empty($item['funero_date']) ) {
								echo '<p class="aheto-tm__date">' . esc_html($item['funero_date']) . '</p>';
							} ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_pagination('funero_swiper_'); ?>
		</div>
		<?php $this->swiper_arrow('funero_swiper_'); ?>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/funero_layout2.css'?>" rel="stylesheet">
	<?php
endif;