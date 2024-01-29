<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_clients_register', 'vestry_clients_layout1' );


/**
 * Clients Shortcode
 */

function vestry_clients_layout1( $shortcode ) {

	$preview_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/clients/previews/';

	$shortcode->add_layout( 'vestry_layout1', [
		'title' => esc_html__( 'Vestry Modern', 'vestry' ),
		'image' => $preview_dir . 'vestry_layout1.jpg',
	] );

	aheto_addon_add_dependency( ['hover_style', 'clients', 'item_per_row'], [ 'vestry_layout1' ], $shortcode );
}