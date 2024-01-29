<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'funero_media_layout3');

/**
 * Media member
 */

function funero_media_layout3($shortcode) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/media/previews/';

	$shortcode->add_layout('funero_layout3', [
		'title' => esc_html__('Funero Gallery Bordered', 'funero'),
		'image' => $preview_dir . 'funero_layout3.jpg',
	]);

	$shortcode->add_dependecy('funero_gallery_simple', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_image_border', 'template', ['funero_layout3']);

	$shortcode->add_params([
		'funero_gallery_simple' => [
			'type'    => 'group',
			'heading' => esc_html__('Gallery', 'funero'),
			'params'  => [
				'funero_image' => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'funero'),
				],
			],
		],
		'funero_image_border'   => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image for Border', 'funero'),
		],
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => 'Funero Image',
		'prefix'     => 'funero_media_',
		'dependency' => ['template', ['funero_layout3']]
	]);
}
