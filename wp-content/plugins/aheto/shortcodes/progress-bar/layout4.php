<?php
/**
 * The Progress Bar Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     FOX-THEMES <info@foxthemes.me>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'progress-bar-style-4', $sc_dir . 'assets/css/layout4.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-counter aheto-counter--modern">
		<?php
		// Icon.
		$this->the_icon( 'aheto-counter__icon' );

		// Percentage.
		if ( ! empty( $percentage ) && is_numeric( $percentage ) ) {
			echo '<h6 class="aheto-counter__number js-counter">' . absint( $percentage ) . '</h6>';
		}

		// Description.
		if ( ! empty( $description ) ) {
			echo '<p class="aheto-counter__desc">' . esc_html( $description ) . '</p>';
		}
		?>
    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $sc_dir . 'assets/css/layout4.css'?>" rel="stylesheet">
	<?php
endif;