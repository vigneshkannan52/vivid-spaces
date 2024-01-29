<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'funero_banner_slider_layout1');

/**
 * Features Banner Slider
 */

function funero_banner_slider_layout1($shortcode) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/banner-slider/previews/';

	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Funero Simple', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);

	$shortcode->add_dependecy('funero_simple_banners', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_title_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_title_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_title_typo', 'funero_title_use_typo', 'true');
	$shortcode->add_dependecy('funero_subtitle_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_subtitle_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_subtitle_typo', 'funero_subtitle_use_typo', 'true');
	$shortcode->add_dependecy('funero_desc_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_desc_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_desc_typo', 'funero_desc_use_typo', 'true');
	$shortcode->add_dependecy('funero_arrows_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_arrows_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_arrows_typo', 'funero_arrows_use_typo', 'true');

	$shortcode->add_params([
		'funero_simple_banners'    => [
			'type'    => 'group',
			'heading' => esc_html__('Banners', 'funero'),
			'params'  => [
				'funero_image_bg'                 => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Background Image', 'funero'),
				],
				'funero_image'                    => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image Before Subtitle', 'funero'),
				],
				'funero_subtitle'                 => [
					'type'    => 'text',
					'heading' => esc_html__('Subtitle', 'funero'),
				],
				'funero_subtitle_spaces'          => [
					'type'    => 'switch',
					'heading' => esc_html__('Remove space under subtitle?', 'funero'),
					'grid'    => 12,
				],
				'funero_title'                    => [
					'type'    => 'textarea',
					'heading' => esc_html__('Title', 'funero'),
				],
				'funero_desc'                     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'funero'),
				],
				'funero_title_tag'                => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for Title', 'funero'),
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
				'funero_align'                    => [
					'type'    => 'select',
					'heading' => esc_html__('Align', 'funero'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'funero_overlay'                  => [
					'type'    => 'select',
					'heading' => esc_html__('Overlay', 'funero'),
					'options' => [
						''      => 'None',
						'light' => 'Light',
						'dark'  => 'Dark',
					],
					'default' => '',
					'grid'    => 5,
				],
				'funero_smaller_space_before_btn' => [
					'type'    => 'switch',
					'heading' => esc_html__('Smaller space before button?', 'funero'),
					'grid'    => 3,
				],
			]
		],
		'funero_title_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Title?', 'funero'),
			'grid'    => 3,
		],
		'funero_title_typo'        => [
			'type'     => 'typography',
			'group'    => 'Funero Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__title',
		],
		'funero_subtitle_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'funero'),
			'grid'    => 3,
		],
		'funero_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Funero Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__subtitle',
		],
		'funero_desc_use_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'funero'),
			'grid'    => 3,
		],
		'funero_desc_typo'         => [
			'type'     => 'typography',
			'group'    => 'Funero Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
		],
		'funero_arrows_use_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Arrows?', 'funero'),
			'grid'    => 3,
		],
		'funero_arrows_typo'       => [
			'type'     => 'typography',
			'group'    => 'Funero Swiper',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .swiper-slides-prev, {{WRAPPER}} .swiper-slides-next',
		],
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'add_button' => true,
		'group'    => 'Funero Button',
		'prefix'     => 'main_',
		'include'    => ['style', 'size'],
	], 'funero_simple_banners');

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'group'          => 'Funero Swiper',
		'prefix'         => 'funero_swiper_simple_',
		'include'        => ['effect', 'speed', 'loop', 'autoplay', 'arrows', 'arrows_style'],
		'dependency'     => ['template', ['funero_layout1']]
	]);


}

function funero_banner_slider_layout1_dynamic_css($css, $shortcode) {


	if ( isset($shortcode->atts['funero_title_use_typo']) && $shortcode->atts['funero_title_use_typo'] && isset($shortcode->atts['funero_title_typo']) && !empty($shortcode->atts['funero_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__title'], $shortcode->parse_typography($shortcode->atts['funero_title_typo']));
	}
	if ( isset($shortcode->atts['funero_subtitle_use_typo']) && $shortcode->atts['funero_subtitle_use_typo'] && isset($shortcode->atts['funero_subtitle_typo']) && !empty($shortcode->atts['funero_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__subtitle'], $shortcode->parse_typography($shortcode->atts['funero_subtitle_typo']));
	}
	if ( isset($shortcode->atts['funero_desc_use_typo']) && $shortcode->atts['funero_desc_use_typo'] && isset($shortcode->atts['funero_desc_typo']) && !empty($shortcode->atts['funero_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography($shortcode->atts['funero_desc_typo']));
	}
	if ( isset($shortcode->atts['funero_arrows_use_typo']) && $shortcode->atts['funero_arrows_use_typo'] && isset($shortcode->atts['funero_arrows_typo']) && !empty($shortcode->atts['funero_arrows_typo']) ) {
		\aheto_add_props($css['global']['%1$s .swiper-slides-prev, %1$s  .swiper-slides-next'], $shortcode->parse_typography($shortcode->atts['funero_arrows_typo']));
	}

	return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'funero_banner_slider_layout1_dynamic_css', 10, 2);
