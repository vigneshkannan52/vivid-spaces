<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'mooseoom_list_layout2');

/**
 * List
 */

function mooseoom_list_layout2($shortcode)
{
	$dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/list/previews/';

	$shortcode->add_layout('mooseoom_layout2', [
		'title' => esc_html__('Mooseoom Links 2', 'mooseoom'),
		'image' => $dir . 'mooseoom_layout2.jpg',
	]);

	$shortcode->add_dependecy('mooseoom_links', 'template', ['mooseoom_layout2']);


	$shortcode->add_params([
		'mooseoom_links' => [
			'type'    => 'group',
			'heading' => esc_html__('Link Items', 'mooseoom'),
			'params'  => [
				'mooseoom_text'        => [
					'type'    => 'text',
					'heading' => esc_html__('Text', 'mooseoom'),
					'default' => esc_html__('Link text', 'mooseoom'),
				],
				'mooseoom_url'        => [
					'type'    => 'text',
					'heading' => esc_html__('URL', 'mooseoom'),
					'default' => esc_html__('https://', 'mooseoom'),
				],
			],
		],
	]);
}
