<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navbar_register', 'ninedok_navbar_layout1' );


/**
 * Navbar
 */

function ninedok_navbar_layout1( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/navbar/previews/';

	$shortcode->add_layout( 'ninedok_layout1', [
		'title' => esc_html__( 'Ninedok Modern', 'ninedok' ),
		'image' => $preview_dir . 'ninedok_layout1.jpg',
	] );


	aheto_addon_add_dependency( ['remove_borders', 'columns', 'right_hide_mobile', 'right_links', 'left_links', 'left_hide_mobile', 'use_links_typo', 'links_typo', 'use_socials_typo', 'socials_typo'], [ 'ninedok_layout1' ], $shortcode );

}