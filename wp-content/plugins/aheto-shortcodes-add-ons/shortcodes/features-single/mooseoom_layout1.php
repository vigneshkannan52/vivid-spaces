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
$this->add_render_attribute('wrapper', 'class', $mooseoom_align);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content-block--mooseoom-creative');

$overlay  = isset($overlay) && !empty($overlay) ? 'overlay-show' : '';
$link_url = isset($link_url) && !empty($link_url) ? $link_url : '#';


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('mooseoom-features-single-layout1', $shortcode_dir . 'assets/css/mooseoom_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>>

		<?php
		// Icon.
		if ( !empty($s_image) ) {?>
			<div class="aheto-content-block__img-wrap">
				<img src="<?php echo esc_attr($s_image['url']); ?>" alt="<?php echo esc_attr($s_heading)?>">
			</div>
		<?php }?>

		<div class="aheto-content-block__info-wrap">
			<?php if (!empty( $s_heading )) : ?>
				<h2 class="aheto-content-block__title"><?php echo wp_kses_post($this->highlight_text( $s_heading )); ?></h2>
			<?php endif; ?>

			<?php if ( !empty($s_description) ) : ?>
				<p class="aheto-content-block__info-text">
					<?php echo wp_kses_post($s_description); ?>
				</p>
			<?php endif; ?>

		</div>
	</div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/mooseoom_layout1.css'?>" rel="stylesheet">
	<?php
endif;