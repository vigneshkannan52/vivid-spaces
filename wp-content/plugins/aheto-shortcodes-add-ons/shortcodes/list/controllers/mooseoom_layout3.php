<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'mooseoom_list_layout3');

/**
 * List
 */

function mooseoom_list_layout3($shortcode)
{
	$dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/list/previews/';

	$shortcode->add_layout('mooseoom_layout3', [
		'title' => esc_html__('Mooseoom Table List', 'mooseoom'),
		'image' => $dir . 'mooseoom_layout3.jpg',
	]);

	// Mooseoom Table List
	$shortcode->add_dependecy('mooseoom_first_column', 'template', ['mooseoom_layout3']);
	$shortcode->add_dependecy('mooseoom_second_column', 'template', ['mooseoom_layout3']);
	$shortcode->add_dependecy('mooseoom_third_column', 'template', ['mooseoom_layout3']);
	$shortcode->add_dependecy('mooseoom_table_lists', 'template', ['mooseoom_layout3']);
	$shortcode->add_dependecy('mooseoom_links_color', 'template', ['mooseoom_layout3']);
	$shortcode->add_dependecy('mooseoom_background', 'template', ['mooseoom_layout3']);
	$shortcode->add_dependecy('mooseoom_use_position_typo', 'template', 'mooseoom_layout3');
	$shortcode->add_dependecy('mooseoom_position_typo', 'template', 'mooseoom_layout3');
	$shortcode->add_dependecy('mooseoom_position_typo', 'mooseoom_use_position_typo', 'true');
	$shortcode->add_dependecy( 'mooseoom_use_location_typo', 'template', 'mooseoom_layout3' );
	$shortcode->add_dependecy( 'mooseoom_location_typo', 'template', 'mooseoom_layout3' );
	$shortcode->add_dependecy( 'mooseoom_location_typo', 'mooseoom_use_location_typo', 'true' );


	$shortcode->add_params([
		'mooseoom_use_location_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for location and type?', 'mooseoom'),
			'grid'    => 3,
		],

		'mooseoom_location_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Location And Type Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-list--row .aheto-list--column p',
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
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-list--column h5',
		],
		'mooseoom_first_column'  => [
			'type'    => 'text',
			'heading' => esc_html__('First Column Title', 'mooseoom'),
		],
		'mooseoom_second_column' => [
			'type'    => 'text',
			'heading' => esc_html__('Second Column Title', 'mooseoom'),
		],
		'mooseoom_third_column'  => [
			'type'    => 'text',
			'heading' => esc_html__('Third Column Title', 'mooseoom'),
		],
		'mooseoom_table_lists'   => [
			'type'    => 'group',
			'heading' => esc_html__('Table Lists', 'mooseoom'),
			'params'  => [
				'mooseoom_first_item'  => [
					'type'    => 'text',
					'heading' => esc_html__('First Item Text', 'mooseoom'),
				],
				'mooseoom_second_item' => [
					'type'    => 'text',
					'heading' => esc_html__('Second Item Text', 'mooseoom'),
				],
				'mooseoom_third_item'  => [
					'type'    => 'text',
					'heading' => esc_html__('Third Item Text', 'mooseoom'),
				],
			],
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'mooseoom_main_',
	], 'mooseoom_table_lists');
}
function mooseoom_list_layout3_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['mooseoom_use_location_typo'] ) && ! empty( $shortcode->atts['mooseoom_location_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-list--row .aheto-list--column p'], $shortcode->parse_typography( $shortcode->atts['mooseoom_location_typo'] ) );
	}
	if ( !empty($shortcode->atts['mooseoom_use_position_typo']) && !empty($shortcode->atts['mooseoom_position_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-list--column h5'], $shortcode->parse_typography($shortcode->atts['mooseoom_position_typo']));
	}
	
	

	return $css;
}

add_filter( 'aheto_list_dynamic_css', 'mooseoom_list_layout3_dynamic_css', 10, 2 );
