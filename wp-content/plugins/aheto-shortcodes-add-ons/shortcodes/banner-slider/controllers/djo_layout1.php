<?php
use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'djo_banner_slider_layout1');

/**
 *  Banner Slider
 */

function djo_banner_slider_layout1( $shortcode ) {
	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/banner-slider/previews/';

	$shortcode->add_layout('djo_layout1', [
		'title' => esc_html__('Djo Modern', 'djo'),
		'image' => $preview_dir . 'djo_layout1.jpg',
	]);
	aheto_addon_add_dependency(['use_heading', 't_heading'], ['djo_layout1'], $shortcode);

	$shortcode->add_dependecy('djo_overlay_color', 'overlay', 'true');
	$shortcode->add_dependecy('djo_subtitle_use_typo', 'template', 'djo_layout1');
	$shortcode->add_dependecy('djo_subtitle_typo', 'template', 'djo_layout1');
	$shortcode->add_dependecy('djo_subtitle_typo', 'djo_subtitle_use_typo', 'true');
	$shortcode->add_dependecy('djo_djo_modern_banners', 'template', 'djo_layout1');
	$shortcode->add_params([
		'djo_djo_modern_banners' => [
			'type'    => 'group',
			'heading' => esc_html__('Banners', 'djo'),
			'params'  => [
				'djo_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Background Image', 'djo'),
				],
				'djo_overlay'       => [
					'type'    => 'switch',
					'heading' => esc_html__('Enable overlay for background image?', 'djo'),
					'grid'    => 12,
				],
				'djo_overlay_color' => [
					'type'    => 'colorpicker',
					'heading' => esc_html__('Overlay Color', 'djo'),
					'grid'    => 12,
					'default' => ''
				],
				'djo_desc'          => [
					'type'    => 'text',
					'heading' => esc_html__('Subtitle', 'djo'),
				],
				'djo_title'         => [
					'type'    => 'text',
					'heading' => esc_html__('Title', 'djo'),
				],
				'djo_align'         => [
					'type'    => 'select',
					'heading' => esc_html__('Align', 'djo'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'djo_title_tag'     => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for Title', 'djo'),
					'options' => [
						'h1'  => 'h1',
						'h2'  => 'h2',
						'h3'  => 'h3',
						'h4'  => 'h4',
						'h5'  => 'h5',
						'h6'  => 'h6',
						'p'   => 'p',
						'div' => 'div',
					],
					'default' => 'h1',
					'grid'    => 5,
				],
			]
		],
		'djo_subtitle_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'djo'),
			'grid'    => 3,
		],
		'djo_subtitle_typo'      => [
			'type'     => 'typography',
			'group'    => 'Banner Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'djo_main_',
	], 'djo_djo_modern_banners');

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'djo_swiper_',
		'include'        => ['effect', 'arrows', 'speed', 'loop', 'autoplay', 'lazy', 'simulate_touch'],
		'dependency'     => ['template', ['djo_layout1']]
	]);
}

function djo_banner_slider_layout1_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['djo_subtitle_use_typo']) && $shortcode->atts['djo_subtitle_use_typo'] && isset($shortcode->atts['djo_subtitle_typo']) && !empty($shortcode->atts['djo_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['djo_subtitle_typo']));
	}

	return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'djo_banner_slider_layout1_dynamic_css', 10, 2);
