<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'mooseoom_team_member_layout2');
/**
 * Team Member
 */

function mooseoom_team_member_layout2($shortcode)
{
	$dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/team-member/previews/';

	$shortcode->add_layout('mooseoom_layout2', [
		'title' => esc_html__('Mooseoom Team social', 'mooseoom'),
		'image' => $dir . 'mooseoom_layout2.jpg',
	]);
	
	aheto_addon_add_dependency( ['image','name', 'designation', 'networks' ], [ 'mooseoom_layout2' ], $shortcode );

	$shortcode->add_dependecy( 'mooseoom_use_title_typo', 'template', ['mooseoom_layout2'] );
	$shortcode->add_dependecy( 'mooseoom_title_typo', 'template', 'mooseoom_layout2' );
	$shortcode->add_dependecy( 'mooseoom_title_typo', 'mooseoom_use_title_typo', 'true' );

	$shortcode->add_dependecy( 'mooseoom_use_position_typo', 'template', ['mooseoom_layout2'] );
	$shortcode->add_dependecy( 'mooseoom_position_typo', 'template', 'mooseoom_layout2' );
	$shortcode->add_dependecy( 'mooseoom_position_typo', 'mooseoom_use_position_typo', 'true' );

	$shortcode->add_params([
		'mooseoom_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for name?', 'mooseoom'),
			'grid'    => 3,
		],

		'mooseoom_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__name',
		],
		'mooseoom_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for position?', 'mooseoom'),
			'grid'    => 3,
		],

		'mooseoom_position_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__position',
		],
		'networks' => true
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'mooseoom_',
		'dependency' => ['template', ['mooseoom_layout2']]
	]);
}

function mooseoom_team_member_layout2_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['mooseoom_use_title_typo']) && !empty($shortcode->atts['mooseoom_title_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography($shortcode->atts['mooseoom_title_typo']));
	}
	if (!empty($shortcode->atts['mooseoom_use_position_typo']) && !empty($shortcode->atts['mooseoom_position_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['mooseoom_position_typo']));
	}

	return $css;
}

add_filter('aheto_team_member_dynamic_css', 'mooseoom_team_member_layout2_dynamic_css', 10, 2);
