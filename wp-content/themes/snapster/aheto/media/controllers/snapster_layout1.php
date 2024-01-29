<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_media_register', 'snapster_media_layout1' );


/**
 * Media Shortcode
 */

function snapster_media_layout1( $shortcode ) {

	$preview_dir = SNAPSTER_T_URI . '/aheto/banner-slider/previews/';

	$shortcode->add_layout( 'snapster_layout1', [
		'title' => esc_html__( 'Snapster Creative Slider', 'snapster' ),
		'image' => $preview_dir . 'snapster_layout1.jpg',
	] );

	aheto_addon_add_dependency( ['image'], [ 'snapster_layout1'], $shortcode );

	$shortcode->add_dependecy( 'snapster_time', 'template', 'snapster_layout1' );
	$shortcode->add_dependecy( 'snapster_autoplay_check', 'template', 'snapster_layout1' );


	$shortcode->add_params( [
		'snapster_time'  => [
			'type'    => 'text',
			'heading' => esc_html__('Speed (milliseconds)', 'snapster'),
			'group'      => esc_html__( 'Snapster Slider Options', 'snapster' ),
		],
		'snapster_autoplay_check'    => [
			'type'      => 'switch',
			'heading'   => esc_html__('Enable Autoplay?', 'snapster'),
			'grid'      => 4,
			'group'      => esc_html__( 'Snapster Slider Options', 'snapster' ),
		],

	] );

}