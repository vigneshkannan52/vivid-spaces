<?php
/**
 * Contact Forms default templates.
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
$this->add_render_attribute( 'wrapper', 'class', 'widget widget_aheto__cf--classic-form' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$this->add_render_attribute( 'title', 'class', 'widget_aheto__title' );
$this->add_render_attribute( 'form', 'class', 'widget_aheto__form text-' . $button_align . ' count-' . $count_input );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/contact-forms/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'contact-forms-style-4', $sc_dir . 'assets/css/layout4.css', null, null );
}

wp_enqueue_script( 'contact-forms-4-js', $sc_dir . 'assets/js/layout4.min.js', array( 'jquery' ), null );

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $title ) ) : ?>
        <h5 <?php $this->render_attribute_string( 'title' ); ?>>
			<?php echo wp_kses_post( $title ); ?>
        </h5>
	<?php endif; ?>

    <div <?php $this->render_attribute_string( 'form' ); ?>>

		<?php if ( ! empty( $contact_form ) ) : ?>
            <div class="<?php echo Helper::get_button( $this, $atts, 'form_', true ); ?>">
				<?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $contact_form ) . '"]' ); ?>
            </div>
		<?php endif; ?>

    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $sc_dir . 'assets/css/layout4.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    "use strict";

    function cf_wrap() {
        if ($('.widget_aheto__cf--classic-form input[type="submit"]').length) {
            $('.widget_aheto__cf--classic-form input[type="submit"]').each(function () {
                $(this).wrap('<div class="submit-wrap"></div>')
            })
        }
        if ($('.widget_aheto__cf--classic-form textarea').length) {
            $('.widget_aheto__cf--classic-form textarea').each(function () {
                $(this).closest('.wpcf7-form-control-wrap').wrap('<div class="textarea-wrap"></div>')
            })
        }
    }

    cf_wrap();

    if ( window.elementorFrontend ) {
        cf_wrap();
    }

})(jQuery, window, document);
	</script>
	<?php
endif;