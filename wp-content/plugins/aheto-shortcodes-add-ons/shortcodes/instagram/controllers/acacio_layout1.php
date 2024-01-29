<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_instagram_register', 'acacio_instagram_layout1' );


/**
 * Heading
 */
function acacio_instagram_layout1( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/instagram/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Acacio Instagram', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

    aheto_addon_add_dependency( ['limit', 'size'], ['acacio_layout1' ], $shortcode );
}


