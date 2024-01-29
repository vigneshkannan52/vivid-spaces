<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team_register', 'famulus_team_layout2');

/**
 * Social Networks
 */

function famulus_team_layout2($shortcode) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/team/previews/';

	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Famulus Classic', 'famulus'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);

	$shortcode->add_dependecy('teams_simple', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_use_typo_name', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_text_typo_name', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_text_typo_name', 'famulus_use_typo_name', 'true');
	$shortcode->add_dependecy('famulus_use_typo_position', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_text_typo_position', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_text_typo_position', 'famulus_use_typo_position', 'true');
	$shortcode->add_params([
		'teams_simple' => [
			'type'    => 'group',
			'heading' => esc_html__('Team', 'famulus'),
			'params'  => [
				'member_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'famulus'),
				],
				'member_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'famulus'),
				],
				'member_designation' => [
					'type'    => 'text',
					'heading' => esc_html__('Designation', 'famulus'),
				],
			],
		],
		'advanced'             => true,
		'famulus_use_typo_name' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for name?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_name'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-member__name',
		],
		'famulus_use_typo_position' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for position?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_position'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-member__position',
		],
	]);

}
function famulus_team_layout2_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_use_typo_name']) && $shortcode->atts['famulus_use_typo_name'] && isset($shortcode->atts['famulus_text_typo_name']) && !empty($shortcode->atts['famulus_text_typo_name']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-member__name'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_hightlight']));
	}
	if ( isset($shortcode->atts['famulus_use_typo_position']) && $shortcode->atts['famulus_use_typo_position'] && isset($shortcode->atts['famulus_text_typo_position']) && !empty($shortcode->atts['famulus_text_typo_position']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-member__position'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_position']));
	}
	return $css;
}

add_filter('aheto_team_dynamic_css', 'famulus_team_layout2_dynamic_css', 10, 2);