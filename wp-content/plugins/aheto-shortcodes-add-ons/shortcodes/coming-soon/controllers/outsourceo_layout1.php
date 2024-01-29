<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_coming-soon_register', 'outsourceo_coming_soon_layout1' );


/**
 * Coming Soon Shortcode
 */

function outsourceo_coming_soon_layout1( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/coming-soon/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Outsourceo Creative', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );

    aheto_addon_add_dependency( ['light', 'time', 'days_desktop', 'days_mobile', 'hours_desktop', 'hours_mobile', 'mins_desktop', 'mins_mobile', 'secs_desktop', 'secs_mobile', 'use_typo_caption', 'typo_caption', 'use_typo_numbers', 'typo_numbers'], [ 'outsourceo_layout1' ], $shortcode );

}