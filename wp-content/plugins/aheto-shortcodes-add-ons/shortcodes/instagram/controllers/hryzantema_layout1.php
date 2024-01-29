<?php

use Aheto\Helper;

add_action('aheto_before_aheto_instagram_register', 'hryzantema_instagram_layout1');

/**
 * HR Consult Instagram
 */

function hryzantema_instagram_layout1($shortcode) {
	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/instagram/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'HR Consult Instagram', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );

	aheto_addon_add_dependency(['limit', 'size'], ['hryzantema_layout1'], $shortcode);

}

