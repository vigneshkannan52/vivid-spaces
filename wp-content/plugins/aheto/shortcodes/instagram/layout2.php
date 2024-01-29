<?php
/**
 * About default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     FOX-THEMES <info@foxthemes.me>
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $token ) || empty ( $username ) ) {
	return;
}

$this->generate_css();

$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-instagram' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-instagram--list' );

$this->add_render_attribute( 'instagram', 'class', 'aheto-instagram__list' );
$this->add_render_attribute( 'instagram', 'class', 'js-instagram' );
$this->add_render_attribute( 'instagram', 'data-token', $token );
$this->add_render_attribute( 'instagram', 'data-size', $size );
$this->add_render_attribute( 'instagram', 'data-max', $limit );
$this->add_render_attribute( 'instagram', 'data-id', $atts['_id'] );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/instagram/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'instagram-style-2', $sc_dir . 'assets/css/layout2.css', null, null );
}

wp_enqueue_script( 'instagram-2-js', $sc_dir . 'assets/js/layout2.min.js', array( 'jquery' ), null );


?>


<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <ul <?php $this->render_attribute_string( 'instagram' ); ?>></ul>

    <div class="aheto-instagram__link">
        <a href="http://instagram.com/<?php echo esc_attr( $username ); ?>"
           target="_blank">@<?php echo esc_html( $username ); ?></a>
    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $sc_dir . 'assets/css/layout2.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document) {
    "use strict";

    $( () => {
        const instagram = $('.js-instagram');

        if (instagram.length) {
            instagram.each(function () {
                const token = $(this).attr('data-token');
                const size  = $(this).attr('data-size');
                const max   = +$(this).attr('data-max') || 6;

                $.fn.spectragram.accessData = {
                    accessToken: token
                };

                $(this).spectragram({
                    size: size,
                    max: max,
                    accessToken: token
                });
            });
        }
    });

})(jQuery, window, document);
	</script>
	<?php
endif;