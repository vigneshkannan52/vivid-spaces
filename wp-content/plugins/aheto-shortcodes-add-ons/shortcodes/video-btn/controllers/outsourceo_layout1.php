<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_video-btn_register', 'outsourceo_video_btn_layout1' );

/**
 * Video Button Shortcode
 */

function outsourceo_video_btn_layout1( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/video-btn/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Outsourceo Creative', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_video_image', 'template', 'outsourceo_layout1' );

	$shortcode->add_params( [
		'outsourceo_video_image' => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Video Button Image', 'outsourceo' ),
		],
	] );

	\Aheto\Params::add_image_sizer_params( $shortcode, [
		'prefix'     => 'outsourceo_',
		'dependency' => [ 'template', [ 'outsourceo_layout1' ] ]
	] );


}