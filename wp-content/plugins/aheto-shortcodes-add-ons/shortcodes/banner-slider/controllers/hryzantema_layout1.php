<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'hryzantema_banner_slider_layout1');

/**
 * Contact forms Shortcode
 */

function hryzantema_banner_slider_layout1($shortcode) {
	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/banner-slider/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'HR Consult Modern', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );

	aheto_addon_add_dependency(['use_heading', 't_heading'], ['hryzantema_layout1'], $shortcode);
	$shortcode->add_dependecy('hr_modern_banners', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_use_subtitle_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_subtitle_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_subtitle_typo', 'hryzantema_use_subtitle_typo', 'true');
	$shortcode->add_dependecy('hryzantema_use_description_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_description_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_description_typo', 'hryzantema_use_description_typo', 'true');
	$shortcode->add_dependecy('hryzantema_use_arrow_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_arrow_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_arrow_typo', 'hryzantema_use_arrow_typo', 'true');

	$shortcode->add_params( [
		'hr_modern_banners' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Banners', 'hryzantema' ),
			'params'  => [
				'hryzantema_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background Image', 'hryzantema' ),
				],
				'hryzantema_heading_tag'      => [
					'type'    => 'select',
					'heading' => esc_html__( 'Element tag for title', 'hryzantema' ),
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
					'default' => 'h2',
				],
				'hryzantema_subtitle'          => [
					'type'    => 'text',
					'heading' => esc_html__( 'Subtitle', 'hryzantema' ),
				],
				'hryzantema_title'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Title', 'hryzantema' ),
					'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]', 'hryzantema' ),
					'admin_label' => true,
					'default'     => esc_html__( 'Heading with [[ hightlight ]] text. For set some words for repeat animation separate them by coma : [[London,New York,Paris]]', 'hryzantema' ),
				],
				'hryzantema_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description', 'hryzantema' ),
				],
				'hryzantema_align' => [
					'type'    => 'select',
					'heading' => esc_html__('Align', 'hryzantema'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'hryzantema_btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Buttons Direction', 'hryzantema' ),
					'options' => [
						''            => esc_html__( 'Horizontal', 'hryzantema' ),
						'is-vertical' => esc_html__( 'Vertical', 'hryzantema' ),
					],
				],
			]
		],
		'hryzantema_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for subtitle?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__subtitle',
		],
		'hryzantema_use_description_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_description_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
		],
		'hryzantema_use_arrow_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for arrows?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_arrow_typo' => [
			'type'     => 'typography',
			'group'    => 'Swiper',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .swiper-button-prev::before, {{WRAPPER}} .swiper-button-next::before',
		],
	] );


	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'hryzantema_swiper_banner_',
		'include'        => [ 'effect', 'speed', 'pagination', 'loop', 'autoplay','lazy', 'arrows', 'simulate_touch' ],
		'group'      => esc_html__( 'Hryzantema Swiper', 'hryzantema' ),
		'dependency'     => [ 'template', [ 'hryzantema_layout1' ] ]
	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'hryzantema_main_',
	], 'hr_modern_banners' );

	\Aheto\Params::add_button_params( $shortcode, [
		'add_label' => esc_html__( 'Add additional button?', 'hryzantema' ),
		'prefix'    => 'hryzantema_add_',
	], 'hr_modern_banners' );

}

function hryzantema_banner_slider_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_subtitle_typo'] ) && $shortcode->atts['hryzantema_use_subtitle_typo'] && isset( $shortcode->atts['hryzantema_subtitle_typo'] ) && ! empty( $shortcode->atts['hryzantema_subtitle_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-banner-slider__subtitle'], $shortcode->parse_typography( $shortcode->atts['hryzantema_subtitle_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_description_typo'] ) && $shortcode->atts['hryzantema_use_description_typo'] && isset( $shortcode->atts['hryzantema_description_typo'] ) && ! empty( $shortcode->atts['hryzantema_description_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography( $shortcode->atts['hryzantema_description_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_arrow_typo'] ) && $shortcode->atts['hryzantema_use_arrow_typo'] && isset( $shortcode->atts['hryzantema_arrow_typo'] ) && ! empty( $shortcode->atts['hryzantema_arrow_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .swiper-button-prev::before, %1$s .swiper-button-next::before'], $shortcode->parse_typography( $shortcode->atts['hryzantema_arrow_typo'] ) );
	}
	return $css;
}

add_filter( 'aheto_banner_slider_dynamic_css', 'hryzantema_banner_slider_layout1_dynamic_css', 10, 2 );

