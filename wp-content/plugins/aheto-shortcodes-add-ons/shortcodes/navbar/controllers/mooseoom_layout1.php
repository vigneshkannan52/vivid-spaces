<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'mooseoom_navbar_layout1');


/**
 * Navbar
 */

function mooseoom_navbar_layout1($shortcode)
{

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/navbar/previews/';

	$shortcode->add_layout('mooseoom_layout1', [
		'title' => esc_html__('Mooseoom Top Nav', 'mooseoom'),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	]);


	$shortcode->add_dependecy('mooseoom_search', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_max_width', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_use_justtext_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_justtext_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_justtext_typo', 'mooseoom_use_justtext_typo', 'true');

	aheto_addon_add_dependency (['remove_borders', 'columns', 'right_links', 'right_hide_mobile', 'left_links', 'left_hide_mobile', 'use_links_typo', 'links_typo', 'use_socials_typo', 'socials_typo'], ['mooseoom_layout1'], $shortcode);

	$shortcode->add_params([
		'mooseoom_search'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Searchbox', 'mooseoom'),
		],
		'mooseoom_max_width'          => [
			'type'      => 'slider',
			'heading'   => esc_html__('Max width for navbar', 'mooseoom'),
			'grid'      => 12,
			'range'     => [
				'px' => [
					'min'  => 0,
					'max'  => 3000,
					'step' => 5,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-navbar--wrap' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		],
		'mooseoom_use_justtext_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for text?', 'mooseoom'),
		],
		'mooseoom_justtext_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-navbar--item-label',
		],
	]);
}
function mooseoom_navbar_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['mooseoom_use_justtext_typo']) && !empty($shortcode->atts['mooseoom_justtext_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-navbar--item-label'], $shortcode->parse_typography($shortcode->atts['mooseoom_justtext_typo']));
	}
	return $css;
}

add_filter('aheto_navbar_shortcode_dynamic_css', 'mooseoom_navbar_layout1_dynamic_css', 10, 2);