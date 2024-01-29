<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'funero_contact_info_layout1');

/**
 * Contact Info shortcode
 */

function funero_contact_info_layout1($shortcode) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contact-info/previews/';

	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Funero Simple', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);

	aheto_addon_add_dependency(['address','phone','email','use_typo_text', 'text_typo'], ['funero_layout1'], $shortcode);
}