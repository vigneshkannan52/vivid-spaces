<?php
/**
 * The Button Shortcode.
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
$this->add_render_attribute( 'wrapper', 'id', $this->atts['element_id'] );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/video-btn/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('djo-video-btn-layout1', $shortcode_dir . 'assets/css/djo_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="aheto-video-container aheto-video-container--creative <?php echo esc_attr($this->atts['align']); ?>">
		<div class="aheto-video-container__image">
			<?php echo Helper::get_video_button($atts); ?>
		</div>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/djo_layout1.css'?>" rel="stylesheet">
	<?php
endif;