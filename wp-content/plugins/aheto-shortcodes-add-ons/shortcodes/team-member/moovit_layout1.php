<?php
/**
 * The Team Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-team-member' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-team-member--moovit-simple' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/team-member/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'moovit-team-member-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<?php if ( ! empty( $image ) ) :

		$background_image = Helper::get_background_attachment( $image, $moovit_image_size, $atts, 'moovit_' ); ?>
        <div class="aheto-team-member__img-holder" <?php echo esc_attr( $background_image ); ?>></div>
	<?php endif; ?>

    <div class="aheto-team-member__text">
		<?php
		// Name.
		if ( ! empty( $name ) ) {
			echo '<h5 class="aheto-team-member__name">' . wp_kses( $name, 'post' ) . '</h5>';
		}

		// Designation.
		if ( ! empty( $designation ) ) {
			echo '<p class="aheto-team-member__position">' . esc_html( $designation ) . '</p>';
		} ?>
    </div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/moovit_layout1.css'?>" rel="stylesheet">
	<?php
endif;