<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_video-btn_register', 'ninedok_video_btn_layout1' );
/**
 * Video Button
 */

function ninedok_video_btn_layout1 ( $shortcode )
{
	$dir = plugins_url ( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/video-btn/previews/';

	$shortcode -> add_layout ( 'ninedok_layout1', [
		'title' => esc_html__ ( 'Ninedok Modern', 'ninedok' ),
		'image' => $dir . 'ninedok_layout1.jpg',
	] );
}
