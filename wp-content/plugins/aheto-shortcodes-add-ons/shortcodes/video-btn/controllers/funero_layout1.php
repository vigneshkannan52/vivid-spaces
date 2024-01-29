<?php

use Aheto\Helper;

add_action('aheto_before_aheto_video-btn_register', 'funero_video_btn_layout1');
/**
 * Video Btn Shortcode
 */

function funero_video_btn_layout1($shortcode) {

	$dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/video-btn/previews/';

	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Funero Simple', 'funero'),
		'image' => $dir . 'funero_layout1.jpg',
	]);
}