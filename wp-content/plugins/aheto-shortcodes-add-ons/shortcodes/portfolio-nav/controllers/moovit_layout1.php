<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_portfolio-nav_register', 'moovit_portfolio_nav_layout1' );


/**
 * Portfolio Nav Shortcode
 */

function moovit_portfolio_nav_layout1( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/portfolio-nav/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Moovit Modern', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );

}