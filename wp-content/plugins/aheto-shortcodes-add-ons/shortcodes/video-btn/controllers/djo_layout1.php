<?php

use Aheto\Helper;

add_action('aheto_before_aheto_video-btn_register', 'djo_video_btn_layout1');

/**
 * Video Button Shortcode
 */

function djo_video_btn_layout1($shortcode) {
	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/video-btn/previews/';

	$shortcode->add_layout('djo_layout1', [
		'title' => esc_html__('Djo Popup', 'djo'),
		'image' => $preview_dir . 'djo_layout1.jpg',
	]);
}
