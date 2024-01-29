<?php
/**
 * The Moovit Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $moovit_responsive_image ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $moovit_align );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-media--moovit-responsive' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_script( 'moovit-media-layout2', $shortcode_dir . 'assets/js/moovit_layout2.min.js', array( 'jquery' ), null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-single-img <?php echo esc_attr( $moovit_align ); ?>"
         data-width='<?php echo esc_attr( $moovit_max_width_hide['size'] ) ?>'>
		<?php echo Helper::get_attachment( $moovit_responsive_image, [ 'class' => 'aheto-single-img__img' ], $moovit_image_size, $atts, 'moovit_' ); ?>
    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<script>
;(function ($, window, document, undefined) {
    'use strict';
    
    function single_img(){
        const dataWidth = jQuery('.aheto-media--moovit-responsive .aheto-single-img').data('width');

        jQuery('.aheto-media--moovit-responsive .aheto-single-img').each(function () {
            if(jQuery(window).width() < dataWidth) {
                jQuery(this).fadeOut();
            } else {
                jQuery(this).fadeIn();
            }
        });
    }


    jQuery(window).on('load resize orientationchange', function () {
        single_img();

    });

})(jQuery, window, document);
	</script>
	<?php
endif;