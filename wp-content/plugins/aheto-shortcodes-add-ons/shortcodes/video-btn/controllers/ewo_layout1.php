<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_video-btn_register', 'ewo_video_btn_layout1' );

/**
 * Title Bar
 */

function ewo_video_btn_layout1( $shortcode ) {
	$dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/title-bar/previews/';

	$shortcode->add_layout( 'ewo_layout1', [
		'title' => esc_html__( 'Ewo Modern', 'ewo' ),
		'image' => $dir . 'ewo_layout1.jpg',
	] );

	$shortcode->add_dependecy('ewo_video_image', 'template', 'ewo_layout1');
	$shortcode->add_params([
		'ewo_video_image' => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Video Button Image', 'ewo'),
		],
	]);
}