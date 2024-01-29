<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-tabs_register', 'snapster_features_tabs_layout1');

/**
 * Navbar
 */

function snapster_features_tabs_layout1($shortcode) {

	$theme_dir = SNAPSTER_T_URI . '/shortcodes/features-tabs/previews/';

	$shortcode->add_layout('snapster_layout1', [
		'title' => esc_html__('Snapster Tabs', 'snapster'),
		'image' => $theme_dir . 'snapster_layout1.jpg',
	]);

	$shortcode->add_dependecy('snapster_tabs', 'template', 'snapster_layout1');
	$shortcode->add_dependecy('snapster_block_paddings', 'template', 'snapster_layout1');
	$shortcode->add_dependecy('snapster_tab_paddings', 'template', 'snapster_layout1');

	$shortcode->add_dependecy('snapster_use_title_typo', 'template', 'snapster_layout1');
	$shortcode->add_dependecy('snapster_title_typo', 'template', 'snapster_layout1');
	$shortcode->add_dependecy('snapster_title_typo', 'snapster_use_title_typo', 'true');
	$shortcode->add_dependecy('snapster_tab_paddings', 'snapster_use_title_typo', 'true');

	$shortcode->add_params([

		'snapster_tabs'        => [
			'type'    => 'group',
			'heading' => esc_html__('Features Tabs', 'snapster'),
			'params'  => [
				'snapster_main_heading'     => [
					'type'    => 'text',
					'heading' => esc_html__('Tab Link', 'snapster'),
				],
				'snapster_main_href'     => [
					'type'    => 'text',
					'heading' => esc_html__('Url', 'snapster'),
				],
				'snapster_bg_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background bg', 'snapster' ),
				],
			],
		],

		'snapster_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Tab text?', 'snapster'),
		],
		'snapster_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Tab Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-tabs__list-link',
		],
		'snapster_use_number_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Number text?', 'snapster'),
		],
		'snapster_number_typo' => [
			'type'     => 'typography',
			'group'    => 'Number Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-tabs__list-item span',
		],
		'snapster_block_paddings'    => [
			'type'      => 'responsive_spacing',
			'heading'   => esc_html__( 'Block content padding', 'snapster' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-features-tabs__list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		],
		'snapster_tab_paddings'    => [
			'type'      => 'responsive_spacing',
			'group'    => 'Tab Typography',
			'heading'   => esc_html__( 'Tab padding', 'snapster' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-features-tabs__list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		],
		'snapster_tab_width' => [
			'type'      => 'slider',
			'heading'   => esc_html__('Content Max Width', 'snapster'),
			'grid'      => 4,
			'range'     => [
				'px' => [
					'min'  => 200,
					'max'  => 600,
					'step' => 5,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-features-tabs__list ul' => 'max-width: {{SIZE}}{{UNIT}} !important;',
			],
		],
		'snapster_reverse' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable reverse block?', 'snapster' ),
			'grid'    => 3,
		],


	]);

}

function snapster_features_tabs_layout1_shortcode_dynamic_css($css, $shortcode)  {
	if ( isset($shortcode->atts['snapster_tab_width']) && !empty($shortcode->atts['snapster_tab_width']) ) {
		$css['global']['%1$s .aheto-features-tabs__list ul']['max-width']    = \Aheto\Sanitize::size($shortcode->atts['snapster_tab_width']);
	}

	if ( isset( $shortcode->atts['snapster_use_number_typo'] ) && $shortcode->atts['snapster_use_number_typo'] && isset( $shortcode->atts['snapster_number_typo'] ) && ! empty( $shortcode->atts['snapster_number_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-features-tabs__list-item span'], $shortcode->parse_typography( $shortcode->atts['snapster_number_typo'] ) );
	}

	if ( isset( $shortcode->atts['snapster_use_title_typo'] ) && $shortcode->atts['snapster_use_title_typo'] && isset( $shortcode->atts['snapster_title_typo'] ) && ! empty( $shortcode->atts['snapster_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-features-tabs__list-link'], $shortcode->parse_typography( $shortcode->atts['snapster_title_typo'] ) );
	}
	return $css;
}

add_filter('aheto_features_tabs_dynamic_css', 'snapster_features_tabs_layout1_shortcode_dynamic_css', 10, 2);