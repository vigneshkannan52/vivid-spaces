<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_instagram_register', 'snapster_instagram_layout1' );


/**
 * Instagram
 */
function snapster_instagram_layout1( $shortcode ) {

	$preview_dir  = SNAPSTER_T_URI . '/aheto/banner-slider/previews/';

	$shortcode->add_layout( 'snapster_layout1', [
		'title' => esc_html__( 'Snapster Instagram', 'snapster' ),
		'image' => $preview_dir . 'snapster_layout1.jpg',
	] );

    aheto_addon_add_dependency( ['title', 'use_typo', 'title_typo', 'limit', 'size'], ['snapster_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'snapster_spaces', 'template', 'snapster_layout1' );

	$shortcode->add_params([
		'snapster_spaces'          => [
			'type'      => 'slider',
			'heading'   => esc_html__('Space between images', 'snapster'),
			'grid'      => 6,
			'range'     => [
				'px' => [
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-instagram--snapster-list ul' => 'grid-gap: {{SIZE}}{{UNIT}};',
			],
		],
	]);
}
