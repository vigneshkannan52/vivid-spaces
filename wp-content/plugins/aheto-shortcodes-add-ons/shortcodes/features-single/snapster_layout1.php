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

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Block Wrapper.
$this->add_render_attribute( 'block_wrapper', 'class', 'aheto-features--snapster-modern' );


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'snapster-features-single-layout1', $shortcode_dir . 'assets/css/snapster_layout1.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div <?php $this->render_attribute_string( 'block_wrapper' ); ?>>
		<?php
		$background_image = \Aheto\Helper::get_background_attachment( $s_image, $snapster_image_size, $atts, 'snapster_' );
		?>


		<?php
		if ( isset( $snapster_link_url ) && ! empty( $snapster_link_url['url'] ) ) {

		$target = $snapster_link_url['is_external'] == 'on' ? '_blank' : '_self'; ?>
        <a href="<?php echo esc_url( $snapster_link_url['url'] ); ?>" target="<?php echo esc_attr( $target ); ?>"
           class="aheto-features-block__wrap" <?php echo esc_attr( $background_image ); ?>>
			<?php } else { ?>

            <div class="aheto-features-block__wrap" <?php echo esc_attr( $background_image ); ?>>
				<?php } ?>
                <div class="aheto-features-block__wrap-overlay"></div>


				<?php if ( ! empty( $snapster_heading ) ) : ?>
                    <h4 class="aheto-content-block__title"><?php echo esc_html( $snapster_heading ); ?></h4>
				<?php endif; ?>


            <?php
            if ( isset( $snapster_link_url ) && ! empty( $snapster_link_url['url'] ) ) { ?>
                </a>
            <?php } else { ?>
                </div>
            <?php } ?>
    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/snapster_layout1.css'?>" rel="stylesheet">
	<?php
endif;