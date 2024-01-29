<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'moovit_contents_layout3' );


/**
 * Contents
 */

function moovit_contents_layout3( $shortcode ) {

	$preview_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/contents/previews/';


	$shortcode->add_layout( 'moovit_layout3', [
		'title' => esc_html__( 'Moovit Faq', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout3.jpg',
	] );

	aheto_addon_add_dependency( ['faqs', 'first_is_opened', 'multi_active', 'title_typo', 'text_typo'], [ 'moovit_layout3' ], $shortcode );

	$shortcode->add_dependecy( 'moovit_icon_size', 'template', 'moovit_layout3' );


	$shortcode->add_params( [

		'moovit_icon_size' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Icon font size', 'moovit' ),
		]
	] );

}


