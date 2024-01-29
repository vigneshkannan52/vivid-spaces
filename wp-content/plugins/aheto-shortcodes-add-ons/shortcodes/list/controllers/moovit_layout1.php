<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'moovit_list_layout1' );

/**
 * List
 */

function moovit_list_layout1( $shortcode ) {
	$dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/list/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Moovit Number List', 'moovit' ),
		'image' => $dir . 'moovit_layout1.jpg',
	] );

	aheto_addon_add_dependency( 'lists', [ 'moovit_layout1' ], $shortcode );

}