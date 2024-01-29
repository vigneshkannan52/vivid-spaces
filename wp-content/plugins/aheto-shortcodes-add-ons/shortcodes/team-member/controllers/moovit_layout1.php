<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_team-member_register', 'moovit_team_member_layout1' );
/**
 * Team Member
 */

function moovit_team_member_layout1( $shortcode ) {
	$dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/team-member/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Moovit Simple', 'moovit' ),
		'image' => $dir . 'moovit_layout1.jpg',
	] );

	aheto_addon_add_dependency( ['image', 'name', 'designation'], [ 'moovit_layout1' ], $shortcode );

	$shortcode->add_dependecy('moovit_background', 'template', 'moovit_layout1');

	$shortcode->add_dependecy( 'moovit_use_title_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_title_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_title_typo', 'moovit_use_title_typo', 'true' );

	$shortcode->add_dependecy( 'moovit_use_designation_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_designation_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_designation_typo', 'moovit_use_designation_typo', 'true' );

	$shortcode->add_params( [
		'moovit_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Background color', 'moovit' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-team-member__text' => 'background: {{VALUE}}' ],
		],
		'moovit_use_title_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for name?', 'moovit' ),
			'grid'    => 3,
		],
		'moovit_title_typo'        => [
			'type'     => 'typography',
			'group'    => 'Moovit Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__name',
		],
		'moovit_use_designation_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for position?', 'moovit' ),
			'grid'    => 3,
		],
		'moovit_designation_typo'     => [
			'type'     => 'typography',
			'group'    => 'Moovit Designation Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} "aheto-team-member__position',
		],

	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'moovit_',
		'dependency' => ['template', [ 'moovit_layout1'] ]
	]);

}

function moovit_team_member_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_background'] ) ) {
		$color                                                        = Sanitize::color( $shortcode->atts['moovit_background'] );
		$css['global']['%1$s .aheto-team-member__text']['background'] = $color;
	}

	if ( ! empty( $shortcode->atts['moovit_use_title_typo'] ) && ! empty( $shortcode->atts['moovit_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography( $shortcode->atts['moovit_title_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['moovit_use_designation_typo'] ) && ! empty( $shortcode->atts['moovit_designation_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography( $shortcode->atts['moovit_designation_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_team_member_dynamic_css', 'moovit_team_member_layout1_dynamic_css', 10, 2 );