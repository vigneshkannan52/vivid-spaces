<?php

	use Aheto\Helper;

	add_action('aheto_before_aheto_team-member_register', 'snapster_team_member_layout1');
	/**
	 * Team Member
	 */

	function snapster_team_member_layout1($shortcode)
	{
		$dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/team-member/previews/';

		$shortcode->add_layout('snapster_layout1', [
			'title' => esc_html__('Snapster Simple', 'snapster'),
			'image' => $dir . 'snapster_layout1.jpg',
		]);


		snapster_add_dependency(['image', 'name', 'designation', 'networks'], ['snapster_layout1'], $shortcode);

		$shortcode->add_dependecy('snapster_link_color', 'template', 'snapster_layout1');
		$shortcode->add_dependecy('snapster_link_size', 'template', 'snapster_layout1');
		$shortcode->add_dependecy('snapster_link_hover_color', 'template', 'snapster_layout1');
		$shortcode->add_dependecy('snapster_use_title_typo', 'template', 'snapster_layout1');
		$shortcode->add_dependecy('snapster_title_typo', 'template', 'snapster_layout1');
		$shortcode->add_dependecy('snapster_title_typo', 'snapster_use_title_typo', 'true');
		$shortcode->add_dependecy('snapster_use_position_typo', 'template', 'snapster_layout1');
		$shortcode->add_dependecy('snapster_position_typo', 'template', 'snapster_layout1');
		$shortcode->add_dependecy('snapster_position_typo', 'snapster_use_position_typo', 'true');



		$shortcode->add_params([
			'snapster_use_title_typo' => [
				'type' => 'switch',
				'heading' => esc_html__('Use custom font for name?', 'snapster'),
				'grid' => 3,
			],
			'snapster_title_typo' => [
				'type' => 'typography',
				'group' => 'Name Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-team-member__name',
			],
			'snapster_use_position_typo' => [
				'type' => 'switch',
				'heading' => esc_html__('Use custom font for Designation?', 'snapster'),
				'grid' => 3,
			],
			'snapster_position_typo' => [
				'type' => 'typography',
				'group' => 'Designation Typography',
				'settings' => [
					'tag' => false,
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .aheto-team-member__position',
			],
			'snapster_paddings'    => [
				'type'      => 'responsive_spacing',
				'heading'   => esc_html__( 'Block padding', 'snapster' ),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aheto-team-member__text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			],
			'snapster_link_paddings'    => [
				'type'      => 'responsive_spacing',
				'group' => 'Link Typography',
				'heading'   => esc_html__( 'Link padding', 'snapster' ),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aheto-team-member__link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			],
			'snapster_link_color' => [
				'type'      => 'colorpicker',
				'group' => 'Link Typography',
				'heading'   => esc_html__( 'Color link', 'snapster' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .aheto-team-member__link' => 'color: {{VALUE}}' ],
			],
			'snapster_link_hover_color' => [
				'type'      => 'colorpicker',
				'group' => 'Link Typography',
				'heading'   => esc_html__( 'Color link on hover', 'snapster' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .aheto-team-member__link:hover' => 'color: {{VALUE}}' ],
			],
			'snapster_link_size'     => [
				'type'      => 'text',
				'group' => 'Link Typography',
				'heading'   => esc_html__( 'Link font-size', 'snapster' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .aheto-team-member__link i' => 'font-size: {{VALUE}}px' ],
				'description' => esc_html__( 'Set font size for icons. (Just write the number)', 'snapster' ),
			],

		]);

		\Aheto\Params::add_image_sizer_params($shortcode, [
			'prefix' => 'snapster_',
			'dependency' => ['template', ['snapster_layout1']]
		]);

	}

	function snapster_team_member_layout1_dynamic_css($css, $shortcode)
	{
		if (!empty($shortcode->atts['snapster_use_title_typo']) && !empty($shortcode->atts['snapster_title_typo'])) {
			\aheto_add_props($css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography($shortcode->atts['snapster_title_typo']));
		}
		if (!empty($shortcode->atts['snapster_use_position_typo']) && !empty($shortcode->atts['snapster_position_typo'])) {
			\aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['snapster_position_typo']));
		}
		if ( isset( $shortcode->atts['snapster_link_color'] ) && !empty($shortcode->atts['snapster_link_color'] ) ) {
			$css['global']['%1$s .aheto-team-member__link:hover']['color'] = \Aheto\Sanitize::color( $shortcode->atts['snapster_link_color'] );
		}
		if ( isset( $shortcode->atts['snapster_link_hover_color'] ) && !empty($shortcode->atts['snapster_link_hover_color'] ) ) {
			$css['global']['%1$s .aheto-team-member__link:hover']['color'] = \Aheto\Sanitize::color( $shortcode->atts['snapster_link_hover_color'] );
		}
		if ( ! empty( $this->atts['snapster_link_size'] ) ) {
			$css['global']['%1$s .aheto-team-member__link i']['font-size'] = Sanitize::size( $this->atts['snapster_link_size'] );
		}
		return $css;
	}

	add_filter('aheto_team_member_dynamic_css', 'snapster_team_member_layout1_dynamic_css', 10, 2);