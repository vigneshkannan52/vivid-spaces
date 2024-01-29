<?php

use Aheto\Helper;

extract( $atts );

if ( empty( $token ) || empty ( $username ) ) {
	return;
}

$this->generate_css();

$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-instagram' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-instagram--snapster-list' );

$this->add_render_attribute( 'instagram', 'class', 'js-instagram' );
$this->add_render_attribute( 'instagram', 'data-token', $token );
$this->add_render_attribute( 'instagram', 'data-size', $size );
$this->add_render_attribute( 'instagram', 'data-max', $limit );
$this->add_render_attribute( 'instagram', 'data-id', $atts['_id'] );


/**
 * Set dependent style
 */
$shortcode_dir     = SNAPSTER_T_URI . '/aheto/instagram/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'snapster-instagram-layout1', $shortcode_dir . 'assets/css/snapster_layout1.css', null, null );
}
?>


<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<?php if ( ! empty( $title ) ) : ?>

        <h4 class="aheto-instagram--title"><?php echo wp_kses_post( $title ); ?></h4>

	<?php endif; ?>

    <div class="aheto-instagram__link">
        <a href="http://instagram.com/<?php echo esc_attr( $username ); ?>"
           target="_blank">@<?php echo esc_html( $username ); ?></a>
    </div>

    <ul <?php $this->render_attribute_string( 'instagram' ); ?>></ul>

</div>
