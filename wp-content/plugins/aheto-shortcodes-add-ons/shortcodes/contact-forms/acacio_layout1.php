<?php
/**
 * Contact Forms default templates.
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
$this->add_render_attribute( 'wrapper', 'class', 'widget_aheto__cf--acacio-classic-form' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$this->add_render_attribute( 'title', 'class', 'widget_aheto__title' );
$this->add_render_attribute( 'form', 'class', 'widget_aheto__form text-' . $button_align . ' count-' . $count_input );

$full_width_button = isset($full_width_button) && $full_width_button ? 'full_width_button' : '';
$this->add_render_attribute( 'wrapper', 'class', $full_width_button );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/contact-forms/';


$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style('acacio-contact-forms-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null);
}

wp_enqueue_script( 'acacio-contact-forms-layout1-js', $shortcode_dir . 'assets/js/acacio_layout1.js', array( 'jquery' ), null );

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( !empty( $title ) ) : ?>
        <h5 <?php $this->render_attribute_string( 'title' ); ?>>
			<?php echo wp_kses_post( $title ); ?>
        </h5>
	<?php endif; ?>

	<div <?php $this->render_attribute_string( 'form' ); ?>>

		<?php if ( !empty( $contact_form ) ) : ?>
            <div class="<?php echo Helper::get_button($this, $atts, 'form_', true); ?>">
				<?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $contact_form ) . '"]' ); ?>
            </div>
		<?php endif; ?>
	</div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/acacio_layout1.css'?>" rel="stylesheet">
	<script>
	/**
	 * CF7 Input Wrap
	 * ==============================================
	 */

	;(function ($, window, document, undefined) {
		"use strict";

		if($('.widget_aheto__cf--acacio-classic-form input[type="submit"]').length){
			$('.widget_aheto__cf--acacio-classic-form input[type="submit"]').each(function () {
				$(this).wrap('<div class="submit-wrap"></div>')
			})
		}
		if($('.widget_aheto__cf--acacio-classic-form textarea').length){
			$('.widget_aheto__cf--acacio-classic-form textarea').each(function () {
				$(this).closest('.wpcf7-form-control-wrap').wrap('<div class="textarea-wrap"></div>')
			})
		}

	})(jQuery, window, document);
	</script>
	<?php
endif;