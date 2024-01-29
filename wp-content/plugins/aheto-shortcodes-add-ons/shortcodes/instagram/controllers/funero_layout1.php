<?php

use Aheto\Helper;

add_action('aheto_before_aheto_instagram_register', 'funero_instagram_layout1');

/**
 * Funero Instagram
 */

function funero_instagram_layout1($shortcode) {
	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/instagram/previews/';
	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Funero Instagram', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);
}