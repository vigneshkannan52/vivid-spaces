<?php
/**
 * About default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $token ) ) {
	return;
}

$this->generate_css();

$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-instagram--funero-list');
$this->add_render_attribute('instagram', 'data-token', $token);
$this->add_render_attribute('instagram', 'data-id', $atts['_id']);

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/instagram/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('funero-instagram-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null);
}
wp_enqueue_script( 'funero-spectragram', FUNERO_T_URI . '/assets/js/lib/spectragram.min.js', array( 'jquery' ), null );

wp_enqueue_script('funero-instagram-js-layout1', $shortcode_dir . 'assets/js/funero_layout1.min.js', null, null);


?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<ul class="aheto-instagram__list js-instagram"
		data-token="<?php echo esc_attr($token); ?>" data-id="<?php echo esc_attr($atts['_id']); ?>"></ul>
	<span class="aheto-instagram__text">.</span>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/funero_layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document) {
    "use strict";

        const instagram = $('.aheto-instagram--funero-list .js-instagram');

        if (instagram.length) {
            instagram.each(function () {
                const token = $(this).attr('data-token');
                const size  = 'small';
                const max   =  6;

                $.fn.spectragram.accessData = {
                    accessToken: token
                };

                $(this).spectragram('getUserFeed', {
                    size: size,
                    max: max,
                    accessToken: token
                });
            });
        }

})(jQuery, window, document);
	</script>
	<?php
endif;