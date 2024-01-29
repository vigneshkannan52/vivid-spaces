<?php

/**
 * Feature Single
 */

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'vestry_features_single_layout1');

function vestry_features_single_layout1($shortcode) {

  $preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/features-single/previews/';
  
	$shortcode->add_layout('vestry_layout1', [
		'title' => esc_html__('Vestry image with subtitle', 'vestry'),
		'image' => $preview_dir . 'vestry_layout1.jpg',
  ]);
  
	aheto_addon_add_dependency(['s_image', 's_heading', 's_description'], ['vestry_layout1'], $shortcode);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'vestry_main_',
		'dependency' => ['template', ['vestry_layout1']]
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__('Images size for images ', 'vestry'),
		'prefix'     => 'vestry_',
		'dependency' => ['template', ['vestry_layout1']]
	]);
}