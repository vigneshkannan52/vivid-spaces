<?php
/**
 * The Contents Shortcode.
 */

use Aheto\Helper;

extract( $atts );

if ( ! is_array( $image ) ) {
	$image = explode( ',', $image );
}
if ( empty( $image ) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-media--snapster-creative' );

$snapster_autoplay_check = isset($snapster_autoplay_check) && !empty($snapster_autoplay_check) ? $snapster_autoplay_check : 'false';
$snapster_time = isset($snapster_time) && !empty($snapster_time) ? $snapster_time : 0;

$this->add_render_attribute( 'slider', 'data-autoplay', $snapster_time );
$this->add_render_attribute( 'slider', 'data-check', $snapster_autoplay_check );
$this->add_render_attribute( 'slider', 'class', 'aheto-media--slider' );

/**
 * Set dependent style
 */
$shortcode_dir = SNAPSTER_T_URI . '/aheto/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'snapster-media-layout1', $shortcode_dir . 'assets/css/snapster_layout1.css', null, null );
}

wp_enqueue_style('slick');
wp_enqueue_script('slick');

wp_enqueue_script('snapster-media-layout1-js', $shortcode_dir . 'assets/js/snapster_layout1.min.js', array('jquery', 'slick'), null); ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div <?php $this->render_attribute_string( 'slider' ); ?>>

		<?php foreach ( $image as $item ) :

			$background_image = \Aheto\Helper::get_background_attachment($item, 'full', $atts); ?>

            <div class="aheto-media--slider-item aheto-full-min-height-js" <?php echo esc_attr($background_image); ?>></div>
		<?php endforeach; ?>

    </div>

    <div class="aheto-media--slider-nav">

	    <?php foreach ( $image as $item ) :

		    $background_thumb = \Aheto\Helper::get_background_attachment($item, 'medium', $atts);  ?>

            <div class="aheto-media--slider-item">
                <div class="aheto-media--slider-img-wrap" <?php echo esc_attr($background_thumb); ?>></div>
            </div>

	    <?php endforeach; ?>

    </div>

</div>
