<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'acacio_features_single_layout4' );

/**
 * Features Single
 */

function acacio_features_single_layout4( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/features-single/previews/';

	$shortcode->add_layout( 'acacio_layout4', [
		'title' => esc_html__( 'Acacio Modern with hover', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout4.jpg',
	] );

	aheto_addon_add_dependency( ['s_heading', 'use_heading', 't_heading', 's_description', 's_image', 'use_description', 't_description'], [ 'acacio_layout4'], $shortcode );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix' => 'acacio_main_',
        'dependency' => ['template', ['acacio_layout4'] ]
    ]);
}