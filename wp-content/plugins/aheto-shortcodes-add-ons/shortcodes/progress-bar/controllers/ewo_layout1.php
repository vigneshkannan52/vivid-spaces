<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_progress-bar_register', 'ewo_progress_bar_layout1' );
/**
 * Progress Bar Shortcode
 */

function ewo_progress_bar_layout1( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/progress-bar/previews/';

	$shortcode->add_layout( 'ewo_layout1', [
		'title' => esc_html__( 'Ewo progress-bar', 'ewo' ),
		'image' => $preview_dir . 'ewo_layout1.jpg',
  ] );
  
	aheto_addon_add_dependency( ['percentage', 'description'], [ 'ewo_layout1' ], $shortcode );
}
