<?php

	use Aheto\Helper;

	add_action ( 'aheto_before_aheto_banner-slider_register', 'ninedok_banner_slider_layout1' );

	/**
	 *  Banner Slider
	 */

	function ninedok_banner_slider_layout1 ( $shortcode ){

		$preview_dir = plugins_url ( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/banner-slider/previews/';

		$shortcode -> add_layout ( 'ninedok_layout1', [
			'title' => esc_html__ ( 'Ninedok Modern', 'ninedok' ),
			'image' => $preview_dir . 'ninedok_layout1.jpg',
		] );


		$shortcode->add_dependecy ( 'ninedok_modern_banners', 'template',  'ninedok_layout1' );

		$shortcode->add_dependecy( 'ninedok_use_heading', 'template', 'ninedok_layout1' );
		$shortcode->add_dependecy( 'ninedok_t_heading', 'template', 'ninedok_layout1' );
		$shortcode->add_dependecy( 'ninedok_t_heading', 'ninedok_use_heading', 'true' );

		$shortcode->add_dependecy( 'ninedok_use_description', 'template', 'ninedok_layout1' );
		$shortcode->add_dependecy( 'ninedok_t_description', 'template', 'ninedok_layout1' );
		$shortcode->add_dependecy( 'ninedok_t_description', 'ninedok_use_description', 'true' );

		$shortcode->add_dependecy( 'ninedok_use_sub_title', 'template', 'ninedok_layout1' );
		$shortcode->add_dependecy( 'ninedok_t_sub_title', 'template', 'ninedok_layout1' );
		$shortcode->add_dependecy( 'ninedok_t_sub_title', 'ninedok_use_sub_title', 'true' );


		$shortcode -> add_params ( [
			'ninedok_modern_banners' => [
				'type' => 'group',
				'heading' => esc_html__ ( 'Banners', 'ninedok' ),
				'params' => [
					'ninedok_image' => [
						'type' => 'attach_image',
						'heading' => esc_html__ ( 'Background Image', 'ninedok' ),
					],
					'ninedok_title_tag'    => [
						'type'    => 'select',
						'heading' => esc_html__( 'Element tag for title', 'aheto' ),
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
						'default'    => 'div',
						'grid'    => 6,
					],
					'ninedok_subtitle' => [
						'type' => 'textarea',
						'heading' => esc_html__ ( 'Subtitle', 'ninedok' ),
						'description' => esc_html__ ( 'Add some text for Subtitle', 'ninedok' ),
						'admin_label' => true,
						'default' => esc_html__ ( 'Add some text for Subtitle', 'ninedok' ),
					],
					'ninedok_title' => [
						'type' => 'text',
						'heading' => esc_html__ ( 'Heading', 'ninedok' ),
					],
					'ninedok_desc' => [
						'type' => 'textarea',
						'heading' => esc_html__ ( 'Description', 'ninedok' ),
					],
					'ninedok_align' => [
						'type' => 'select',
						'heading' => esc_html__ ( 'Align', 'ninedok' ),
						'options' => Helper ::choices_alignment (),
					],
					'ninedok_overlay' => [
						'type' => 'colorpicker',
						'heading' => esc_html__ ( 'Overlay color', 'ninedok' ),
						'grid' => 6,
						'default' => 'transparent',
						'selectors' => [
							'{{WRAPPER}} .aheto-banner-slider__overlay' => 'background: {{VALUE}}',
						],
					],
					'ninedok_add_image' => [
						'type' => 'attach_image',
						'heading' => esc_html__ ( 'Additional Image', 'ninedok' ),
					],
				]
			],
			'ninedok_use_heading' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for heading?', 'aheto' ),
				'grid'    => 3,
			],
			'ninedok_t_heading'   => [
				'type'     => 'typography',
				'group'    => 'Ninedok Heading Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .aheto-banner__title',
			],
			'ninedok_use_description' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for description?', 'ninedok' ),
				'grid'    => 3,
			],
			'ninedok_t_description'   => [
				'type'     => 'typography',
				'group'    => 'Ninedok Description Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
			],
			'ninedok_use_sub_title' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for subtitle?', 'ninedok' ),
				'grid'    => 3,
			],
			'ninedok_t_sub_title'   => [
				'type'     => 'typography',
				'group'    => 'Ninedok Subtitle Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .aheto-banner__subtitle',
			],

		] );

		\Aheto\Params ::add_image_sizer_params ( $shortcode, [
			'group' => esc_html__ ( 'Size for additional image', 'ninedok' ),
			'prefix' => 'ninedok_',
			'dependency' => [ 'template', [ 'ninedok_layout1' ] ]
		] );
		\Aheto\Params ::add_carousel_params ( $shortcode, [
			'custom_options' => true,
			'prefix' => 'ninedok_swiper_',
			'include' => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'simulate_touch' ],
			'dependency' => [ 'template', [ 'ninedok_layout1' ] ]
		] );
	}

	function ninedok_banner_slider_layout1_dynamic_css ( $css, $shortcode )
	{

		if ( !empty( $shortcode -> atts['ninedok_overlay'] )) {
			$color = Sanitize ::color ( $shortcode -> atts['ninedok_overlay'] );
			$css['global']['%1$s .aheto-banner-slider__overlay']['background'] = $color;
		}
		if (!empty($shortcode->atts['ninedok_use_heading']) && !empty($shortcode->atts['ninedok_t_heading'])) {
			\aheto_add_props($css['global']['%1$s .aheto-banner__title'], $shortcode->parse_typography($shortcode->atts['ninedok_t_heading']));
		}

		if (!empty($shortcode->atts['ninedok_use_description']) && !empty($shortcode->atts['ninedok_t_heading'])) {
			\aheto_add_props($css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography($shortcode->atts['ninedok_t_heading']));
		}
		if (!empty($shortcode->atts['ninedok_use_sub_title']) && !empty($shortcode->atts['ninedok_t_sub_title'])) {
			\aheto_add_props($css['global']['%1$s .aheto-banner__subtitle'], $shortcode->parse_typography($shortcode->atts['ninedok_t_sub_title']));
		}

		return $css;
	}

	add_filter ( 'aheto_banner_slider_dynamic_css', 'ninedok_banner_slider_layout1_dynamic_css', 10, 2 );
