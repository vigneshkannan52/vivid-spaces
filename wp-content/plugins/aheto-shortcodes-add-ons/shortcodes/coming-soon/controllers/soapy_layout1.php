<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_coming-soon_register', 'soapy_coming_soon_layout1' );


/**
 * Coming Soon Shortcode
 */

function soapy_coming_soon_layout1( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/coming-soon/previews/';

	$shortcode->add_layout( 'soapy_layout1', [
		'title' => esc_html__( 'Soapy Simple', 'soapy' ),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	] );
	$shortcode->add_dependecy( 'soapy_remove_top_space', 'template', 'soapy_layout1' );

	aheto_addon_add_dependency( ['use_typo_numbers', 'typo_numbers'], [ 'soapy_layout1' ], $shortcode );
	$shortcode->add_params( [
		'soapy_remove_top_space' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Remove top space?', 'djo' ),
			'grid'    => 6,
		],
	] );

}