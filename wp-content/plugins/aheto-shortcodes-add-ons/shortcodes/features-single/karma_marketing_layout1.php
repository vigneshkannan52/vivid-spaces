<?php
/**
 * The Heading Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

use Aheto\Helper;

extract ( $atts );

$this -> generate_css ();


// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-content-block--karma_marketing-layout1' );
$this->add_render_attribute( 'wrapper', 'class', 't-center' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/features-single/';

$custom_css = Helper ::get_settings ( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && !empty( $custom_css ) ) ? $custom_css : false;

if (empty( $custom_css ) || ( $custom_css == "disabled" )) {
    wp_enqueue_style ( 'karma_marketing-features-single-layout1', $shortcode_dir . 'assets/css/karma_marketing_layout1.css', null, null );
}

?>

<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>

	<?php if ( ! empty( $s_image ) ) : ?>
        <div class="aheto-content-block__image">
			<?php echo Helper::get_attachment( $s_image, [],  $karma_marketing_image_size, $atts, 'karma_marketing_' ); ?>
        </div>
	<?php endif; ?>

	<?php if ( ! empty( $s_heading ) ) : ?>
        <h5 class="aheto-content-block__title"><?php echo $this->highlight_text( $s_heading ); ?></h5>
	<?php endif; ?>

	<?php if ( ! empty( $s_description ) ) : ?>
        <p class="aheto-content-block__info-text">
			<?php echo wp_kses_post( $s_description ); ?>
        </p>
	<?php endif; ?>


</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/karma_marketing_layout1.css'?>" rel="stylesheet">
	<?php
endif;