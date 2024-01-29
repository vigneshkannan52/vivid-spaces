<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'famulus_banner_slider_layout2');

/**
 *  Banner Slider
 */

function famulus_banner_slider_layout2($shortcode) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/banner-slider/previews/';

	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Famulus Simple', 'famulus'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);

	aheto_addon_add_dependency(['use_heading', 't_heading'], ['famulus_layout2'], $shortcode);

	$shortcode->add_dependecy('famulus_h_title_use_typo', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_h_title_typo', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_h_title_typo', 'famulus_h_title_use_typo', 'true');
	$shortcode->add_dependecy('famulus_desc_use_typo', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_desc_typo', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_desc_typo', 'famulus_desc_use_typo', 'true');
	$shortcode->add_dependecy('famulus_image_overlay', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_image_overlay', 'famulus_overlay_img', 'true');
	$shortcode->add_dependecy('famulus_overlay_img', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('banners', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_video_use_typo', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_video_typo', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_change_arrow_position', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_video_typo', 'famulus_video_use_typo', 'true');
	$shortcode->add_dependecy('famulus_video_title', 'famulus_video', 'true');
	$shortcode->add_dependecy('famulus_video_link', 'famulus_video', 'true');
	$shortcode->add_dependecy('famulus_video_style', 'famulus_video', 'true');
	$shortcode->add_dependecy('famulus_arrow_square', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_arrow_square', 'famulus_change_arrow_position', 'true');


	$shortcode->add_params([
		'banners' => [
			'type'    => 'group',
			'heading' => esc_html__('Banners', 'famulus'),
			'params'  => [
				'image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'famulus'),
				],
				'title'         => [
					'type'        => 'textarea',
					'heading'     => esc_html__('Title', 'famulus'),
					'description' => esc_html__('To Hightlight text insert text between: <i> Your Text Here </i>, To Hightlight text with color insert text between: [[ Your Text Here ]], For text in new line use <br> ', 'famulus'),

				],
				'title_tag'     => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for Title', 'famulus'),
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
				'desc_tag'     => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for Description', 'famulus'),
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
					'default' => 'p',
					'grid'    => 5,
				],
				'desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'famulus'),
				],
				'align'         => [
					'type'    => 'select',
					'heading' => esc_html__('Align', 'famulus'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'tablet_align'         => [
					'type'    => 'select',
					'heading' => esc_html__('Tablet Align', 'famulus'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__('Buttons Direction', 'famulus'),
					'options' => [
						''            => esc_html__('Horizontal', 'famulus'),
						'is-vertical' => esc_html__('Vertical', 'famulus'),
					],
				],
				'famulus_video'         => [
					'type'    => 'switch',
					'heading' => esc_html__('Add Video Button?', 'famulus'),
					'grid'    => 12,
				],
				'famulus_video_title'   => [
					'type'    => 'text',
					'heading' => esc_html__('Video Title', 'famulus'),
				],
				'famulus_video_link'    => [
					'type'    => 'text',
					'heading' => esc_html__('Video Link', 'famulus'),
				],
				'famulus_video_style'   => [
					'type'    => 'select',
					'heading' => esc_html__('Buttons Style', 'famulus'),
					'options' => [
						''          => esc_html__('Default', 'famulus'),
						'is-active' => esc_html__('Active', 'famulus'),
					],
					'default' => '',
				],
				'overlay'       => [
					'type'    => 'switch',
					'heading' => esc_html__('Add dark overlay?', 'famulus'),
					'grid'    => 12,
				],
			]
		],

		'famulus_h_title_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Highlight?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_h_title_typo'               => [
			'type'     => 'typography',
			'group'    => 'Banner Highlight Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner__title i, .aheto-banner__title span',
		],
		'famulus_desc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_desc_typo'               => [
			'type'     => 'typography',
			'group'    => 'Famulus Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner__desc',
		],
		'famulus_overlay_img'              => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable overlay image for slider?', 'famulus'),
			'grid'    => 12,
		],
		'famulus_image_overlay'            => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Overlay Image', 'famulus')
		],
		'famulus_video_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Video Link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_video_typo'        => [
			'type'     => 'typography',
			'group'    => 'Video Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner__video',
		],
		'famulus_change_arrow_position'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Change arrows position?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_arrow_square'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Arrow square style?', 'famulus'),
			'grid'    => 3,
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'main_',
	], 'banners');

	\Aheto\Params::add_button_params($shortcode, [
		'add_label' => esc_html__('Add additional button?', 'famulus'),
		'prefix'    => 'add_',
	], 'banners');

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'famulus_swiper_simple_',
		'include'        => ['effect', 'speed', 'loop', 'autoplay', 'arrows'],
		'dependency'     => ['template', ['famulus_layout2']]
	]);


}

function famulus_banner_slider_layout2_dynamic_css($css, $shortcode) {


	if ( isset($shortcode->atts['famulus_h_title_use_typo']) && $shortcode->atts['famulus_h_title_use_typo'] && isset($shortcode->atts['famulus_h_title_typo']) && !empty($shortcode->atts['famulus_h_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner__title i, .aheto-banner__title span'], $shortcode->parse_typography($shortcode->atts['famulus_h_title_typo']));
	}
	if ( isset($shortcode->atts['famulus_desc_use_typo']) && $shortcode->atts['famulus_desc_use_typo'] && isset($shortcode->atts['famulus_desc_typo']) && !empty($shortcode->atts['famulus_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner__desc'], $shortcode->parse_typography($shortcode->atts['famulus_desc_typo']));
	}
	return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'famulus_banner_slider_layout2_dynamic_css', 10, 2);
