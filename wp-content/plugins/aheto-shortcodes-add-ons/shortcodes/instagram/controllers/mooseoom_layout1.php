<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_instagram_register', 'mooseoom_instagram_layout1' );


/**
 * Heading
 */
function mooseoom_instagram_layout1( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/instagram/previews/';

	$shortcode->add_layout( 'mooseoom_layout1', [
		'title' => esc_html__( 'Mooseoom Instagram', 'mooseoom' ),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	] );

    aheto_addon_add_dependency( ['limit', 'size'], ['mooseoom_layout1' ], $shortcode );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'         => 'mooseoom_',
		'dependency' => ['template',  ['mooseoom_layout1']]
	]);

}


