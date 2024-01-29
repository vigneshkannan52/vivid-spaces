<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'acacio_contacts_layout1' );



/**
 * Contacts
 */

function acacio_contacts_layout1( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contacts/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Acacio Simple', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

	aheto_addon_add_dependency( ['s_heading', 'address', 'networks', 'email', 'phone'], [ 'acacio_layout1' ], $shortcode );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix' => 'acacio_main_',
        'dependency'     => [ 'template', [ 'acacio_layout1' ] ]
    ]);
    

}