<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'famulus_navbar_layout2');


/**
 * Navbar
 */

function famulus_navbar_layout2($shortcode) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/navbar/previews/';

	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Famulus Navbar 1', 'famulus'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);


	$shortcode->add_dependecy('famulus_menus', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_title', 'template', 'famulus_layout2');
	$shortcode->add_params([
		'famulus_menus' => [
			'type'        => 'select',
			'heading'     => esc_html__('Menu', 'famulus'),
			'options'     => \Aheto\Helper::choices_nav_menu(),
			'description' => esc_html__('Use menu with one level items', 'famulus'),
		],
		'famulus_title' => [
			'type'    => 'text',
			'heading' => esc_html__('Menu Title', 'famulus'),
		],

	]);
}