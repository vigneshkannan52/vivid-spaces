<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'funero_navbar_layout2');

/**
 *  Navbar Shortcode
 */

function funero_navbar_layout2($shortcode) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/navbar/previews/';

	$shortcode->add_layout('funero_layout2', [
		'title' => esc_html__('Funero Page Search', 'funero'),
		'image' => $preview_dir . 'funero_layout2.jpg',
	]);
	$shortcode->add_dependecy('funero_label', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_image_bg', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_label_use_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_label_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_label_typo', 'funero_label_use_typo', 'true');
	$shortcode->add_dependecy('funero_search_use_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_search_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_search_typo', 'funero_search_use_typo', 'true');
	$shortcode->add_dependecy('funero_submit_use_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_submit_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_submit_typo', 'funero_submit_use_typo', 'true');

	$shortcode->add_params([
		'funero_label' => [
			'type'    => 'text',
			'heading' => esc_html__('Label', 'funero'),
		],
		'funero_image_bg'        => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Background Image', 'funero'),
		],
		'funero_label_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Label?', 'funero'),
			'grid'    => 3,
		],
		'funero_label_typo'        => [
			'type'     => 'typography',
			'group'    => 'Funero Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__label, {{WRAPPER}} .aheto-navbar--item',
		],
		'funero_search_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Search?', 'funero'),
			'grid'    => 3,
		],
		'funero_search_typo'        => [
			'type'     => 'typography',
			'group'    => 'Funero Search Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}}  input[type="search"]',
		],
		'funero_submit_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for submit?', 'funero'),
			'grid'    => 3,
		],
		'funero_submit_typo'        => [
			'type'     => 'typography',
			'group'    => 'Funero Submit Button Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}}  input[type="submit"]',
		],
	]);
}


function funero_navbar_layout2_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['funero_label_use_typo']) && $shortcode->atts['funero_label_use_typo'] && isset($shortcode->atts['funero_label_typo'])  && !empty($shortcode->atts['funero_label_typo']) ) {
		\aheto_add_props($css['global']['%1$s .widget_aheto__label, %1$s  .aheto-navbar--item'], $shortcode->parse_typography($shortcode->atts['funero_label_typo']));
	}

	if ( isset($shortcode->atts['funero_search_use_typo']) && $shortcode->atts['funero_search_use_typo'] && isset($shortcode->atts['funero_search_typo']) && !empty($shortcode->atts['funero_search_typo']) ) {
		\aheto_add_props($css['global']['%1$s input[type="search"]'], $shortcode->parse_typography($shortcode->atts['funero_search_typo']));
	}
	if ( isset($shortcode->atts['funero_submit_use_typo']) && $shortcode->atts['funero_submit_use_typo'] && isset($shortcode->atts['funero_submit_typo'])  && !empty($shortcode->atts['funero_submit_typo']) ) {
		\aheto_add_props($css['global']['%1$s input[type="submit"]'], $shortcode->parse_typography($shortcode->atts['funero_submit_typo']));
	}

	return $css;
}
add_filter('aheto_navbar_dynamic_css', 'funero_navbar_layout2_dynamic_css', 10, 2);