<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'outsourceo_list_layout1' );

/**
 * List Shortcode
 */

function outsourceo_list_layout1( $shortcode ) {
	$dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/list/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Outsourceo Number List', 'outsourceo' ),
		'image' => $dir . 'outsourceo_layout1.jpg',
	] );

	aheto_addon_add_dependency( 'lists', [ 'outsourceo_layout1' ], $shortcode );
}