<?php

add_action( 'aheto_before_aheto_custom-post-types_register', 'snapster_custom_post_types_skins_shortcode' );

/**
 * Custom post type style for blog items
 */
if( !function_exists( 'snapster_custom_post_types_skins_shortcode' ) ) {
	function snapster_custom_post_types_skins_shortcode($shortcode) {

		$aheto_skins      = $shortcode->params["skin"]["options"];
		$snapster_skins = array(
			"snapster_skin-1" => "Snapster skin 1",
		);


		$all_skins = array_merge($aheto_skins, $snapster_skins);
		$shortcode->params['skin']['options'] = $all_skins;


		$aheto_mosaics_skins      = $shortcode->params["mosaics_skin"]["options"];

		$all_mosaics_skins = array_merge($aheto_mosaics_skins, $snapster_skins);
		$shortcode->params['mosaics_skin']['options'] = $all_mosaics_skins;


		$shortcode->add_dependecy("snapster_use_date_typo", "skin", "snapster_skin-1" );
		$shortcode->add_dependecy("snapster_date_typo", "skin", "snapster_skin-1" );
		$shortcode->add_dependecy("snapster_date_typo", "snapster_use_date_typo", "true" );

		$shortcode->add_dependecy("snapster_paddings", "skin", ["snapster_skin-1"] );

		$shortcode->add_params([
			'snapster_use_date_typo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for Date?', 'snapster' ),
				'grid'    => 3,
			],
			'snapster_date_typo' => [
				'type'     => 'typography',
				'group'    => 'Snapster Date Typography',
				'settings' => [
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
			],
			'snapster_paddings'    => [
				'type'      => 'responsive_spacing',
				'heading'   => esc_html__( 'Block padding', 'snapster' ),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aheto-cpt-article__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			],
			'snapster_excerpt_paddings'    => [
				'type'      => 'responsive_spacing',
				'group'    => 'Snapster Excerpt Typography',
				'heading'   => esc_html__( 'Excerpt padding', 'snapster' ),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aheto-cpt-article__excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			],
			'snapster_link_paddings'    => [
				'type'      => 'responsive_spacing',
				'group'    => 'Snapster Link Typography',
				'heading'   => esc_html__( 'Link padding', 'snapster' ),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aheto-cpt-article__link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			],
		]);

	}
}
if( !function_exists( 'snapster_custom_post_types_skins_shortcode_dynamic_css' ) ) {
	function snapster_custom_post_types_skins_shortcode_dynamic_css( $css, $shortcode ) {

		if ( ! empty( $shortcode->atts['snapster_use_date_typo'] ) && ! empty( $shortcode->atts['snapster_date_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__terms'], $shortcode->parse_typography( $shortcode->atts['snapster_date_typo'] ) );
		}

		return $css;
	}
}
add_filter( 'aheto_cpt_dynamic_css', 'snapster_custom_post_types_skins_shortcode_dynamic_css', 10, 2 );