<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_progress-bar_register', 'outsourceo_progress_bar_layout2' );


/**
 * Progress Bar
 */

function outsourceo_progress_bar_layout2( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/progress-bar/previews/';

	$shortcode->add_layout( 'outsourceo_layout2', [
		'title' => esc_html__( 'Outsourceo Modern', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout2.jpg',
	] );

	aheto_addon_add_dependency( ['percentage', 'heading'], [ 'outsourceo_layout2' ], $shortcode );
}