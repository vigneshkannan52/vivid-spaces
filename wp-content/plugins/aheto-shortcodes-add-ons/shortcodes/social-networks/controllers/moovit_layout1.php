<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_social-networks_register', 'moovit_social_networks_layout1' );

/**
 * Social Networks
 */

function moovit_social_networks_layout1( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/social-networks/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Moovit Modern', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );

	aheto_addon_add_dependency( ['networks', 'size', 'socials_align_mob', 'socials_align'], [ 'moovit_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'moovit_light_version', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_use_link_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_link_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_link_typo', 'moovit_use_link_typo', 'true' );

	$shortcode->add_params( [
		'moovit_light_version' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable light version?', 'moovit' ),
			'grid'    => 3,
		],
		'moovit_use_link_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for link?', 'moovit' ),
			'grid'    => 3,
		],
		'moovit_link_typo' => [
			'type'     => 'typography',
			'group'    => 'Moovit Link Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-socials__link',
		],

	] );
}