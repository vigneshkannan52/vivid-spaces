<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_title-bar_register', 'outsourceo_title_bar_layout1' );

/**
 * Title Bar Shortcode
 */

function outsourceo_title_bar_layout1( $shortcode ) {

	$dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/title-bar/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Outsourceo Title With Search', 'outsourceo' ),
		'image' => $dir . 'outsourceo_layout1.jpg',
	] );

	aheto_addon_add_dependency( ['source', 'title', 'title_tag', 'use_title_typo', 'title_typo', 'searchform', 'sf_button', 'sf_placeholder'], [ 'outsourceo_layout1' ], $shortcode );

}

