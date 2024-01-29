<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_banner-slider_register', 'mooseoom_banner_slider_layout2' );

/**
 *  Banner Slider
 */

function mooseoom_banner_slider_layout2( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/banner-slider/previews/';

	$shortcode->add_layout( 'mooseoom_layout2', [
		'title' => esc_html__( 'Mooseoom Creative', 'mooseoom' ),
		'image' => $preview_dir . 'mooseoom_layout2.jpg',
	] );

	
	aheto_addon_add_dependency( ['use_heading', 't_heading'], [ 'mooseoom_layout2' ], $shortcode );

	$shortcode->add_dependecy('mooseoom_banner_theme', 'template', 'mooseoom_layout2');

	$shortcode->add_dependecy('mooseoom_modern_banners', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_banner_theme', 'template', 'mooseoom_layout2');

	$shortcode->add_dependecy('mooseoom_use_subtitle_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_subtitle_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_subtitle_typo', 'mooseoom_use_subtitle_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_desc_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_desc_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_desc_typo', 'mooseoom_use_desc_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_arrows_text_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_arrows_text_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_arrows_text_typo', 'mooseoom_use_arrows_text_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_fontarrov_text_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_fontarrov_text_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_fontarrov_text_typo', 'mooseoom_use_fontarrov_text_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_fontarrov_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_fontarrov_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_fontarrov_typo', 'mooseoom_use_fontarrov_typo', 'true');

	$shortcode->add_params( [

		'mooseoom_use_fontarrov_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'When arrow On, typography?', 'mooseoom' ),
			'grid'    => 3,
		],
		'mooseoom_fontarrov_typo'        => [
			'type'     => 'typography',
			'group'    => 'Arrows Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} div.swiper-button-prev, {{WRAPPER}} div.swiper-button-next',
		],
		'mooseoom_banner_theme'         => [
			'type'    => 'select',
			'heading' => esc_html__('Banner theme', 'mooseoom'),
			'options' => [
				''            => esc_html__('Light', 'mooseoom'),
				'banner-dark' => esc_html__('Dark', 'mooseoom'),
			],
		],
		'mooseoom_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for subtitle?', 'mooseoom' ),
			'grid'    => 3,
		],
		'mooseoom_subtitle_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__sub-title',
		],
		'mooseoom_modern_banners' => [
			'type'    => 'group',
			'heading' => esc_html__('Banners', 'mooseoom'),
			'params'  => [
				'mooseoom_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Background Image', 'mooseoom'),
				],
				'mooseoom_title'         => [
					'type'    => 'text',
					'heading' => esc_html__('Title', 'mooseoom'),
				],
				'mooseoom_sub_title' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Subtitle', 'mooseoom'),
				],
				'mooseoom_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'mooseoom'),
				],
				'mooseoom_align'             => [
					'type'    => 'select',
					'heading' => esc_html__('Align', 'outsourceo'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'mooseoom_btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__('Buttons Direction', 'mooseoom'),
					'options' => [
						''            => esc_html__('Horizontal', 'mooseoom'),
						'is-vertical' => esc_html__('Vertical', 'mooseoom'),
					],
				],
			]
		],
		'mooseoom_use_desc_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'mooseoom' ),
			'grid'    => 3,
		],
		'mooseoom_desc_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
		],
		'mooseoom_use_arrows_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for arrows text?', 'mooseoom' ),
			'grid'    => 3,
		],
		'mooseoom_arrows_text_typo'        => [
			'type'     => 'typography',
			'group'    => 'Arrows text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} div.swiper-button-prev span, {{WRAPPER}} div.swiper-button-next span',
		],
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'mooseoom_main_',
	], 'mooseoom_modern_banners');

	\Aheto\Params::add_button_params($shortcode, [
		'add_label' => esc_html__('Add additional button?', 'mooseoom'),
		'prefix'    => 'mooseoom_add_',
	], 'mooseoom_modern_banners');

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'mooseoom_swiper_',
		'include'        => ['effect', 'speed', 'loop', 'autoplay', 'lazy', 'simulate_touch','arrows', 'arrows_style', 'arrows_num_typo', 'arrows_color', 'arrows_size'],
		'dependency'     => ['template', ['mooseoom_layout2']]
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__('Images size for additional image', 'mooseoom'),
		'prefix'     => 'mooseoom_',
		'dependency' => ['template', ['mooseoom_layout2']]
	]);

}

function mooseoom_banner_slider_layout2_dynamic_css( $css, $shortcode ) {
	
	if ( !empty($shortcode->atts['mooseoom_use_fontarrov_typo']) && !empty($shortcode->atts['mooseoom_fontarrov_typo']) ) {
		\aheto_add_props($css['global']['%1$s .div.swiper-button-prev, %1$s .div.swiper-button-next'], $shortcode->parse_typography($shortcode->atts['mooseoom_fontarrov_typo']));
	}

	if ( !empty($shortcode->atts['mooseoom_use_subtitle_typo']) && !empty($shortcode->atts['mooseoom_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__sub-title'], $shortcode->parse_typography($shortcode->atts['mooseoom_subtitle_typo']));
	}

	if ( !empty($shortcode->atts['mooseoom_use_desc_typo']) && !empty($shortcode->atts['mooseoom_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography($shortcode->atts['mooseoom_desc_typo']));
	}
	
	if ( !empty($shortcode->atts['mooseoom_use_arrows_text_typo']) && !empty($shortcode->atts['mooseoom_arrows_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s div.swiper-button-prev span, %1$s div.swiper-button-next span'], $shortcode->parse_typography($shortcode->atts['mooseoom_arrows_text_typo']));
	}

	if ( !empty($shortcode->atts['mooseoom_arrows_color']) ) {
        $css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['mooseoom_arrows_color']);
	}
	
	if ( !empty($shortcode->atts['mooseoom_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['mooseoom_arrows_size'] );
    }
	if ( ! empty($shortcode->atts['mooseoom_arrows_num_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .swiper-button-next span, %1$s .swiper-button-prev span'], $shortcode->parse_typography( $shortcode->atts['mooseoom_arrows_num_typo'] ) );
    }



	return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'mooseoom_banner_slider_layout2_dynamic_css', 10, 2);