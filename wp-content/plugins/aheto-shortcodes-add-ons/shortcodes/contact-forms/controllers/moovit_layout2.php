<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'moovit_contact_forms_layout2' );


/**
 * Contact forms
 */

function moovit_contact_forms_layout2( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contact-forms/previews/';

	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'Moovit Classic', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout2.jpg',
	] );

	aheto_addon_add_dependency( ['bg_color_fields', 'title', 'use_title_typo', 'title_typo', 'count_input', 'button_align', 'border_radius_button', 'border_radius_input', 'full_width_button'], [ 'moovit_layout2' ], $shortcode );

	$shortcode->add_dependecy( 'moovit_title_tag', 'template', 'moovit_layout2' );

	$shortcode->add_params( [

		'moovit_title_tag' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for Title', 'moovit' ),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'h5',
			'grid'    => 5,
		],

	] );


}

function moovit_contact_forms_layout2_button( $form_button ) {

	$form_button['dependency'][1][] = 'moovit_layout2';

	return $form_button;

}

add_filter( 'aheto_button_contact-forms', 'moovit_contact_forms_layout2_button', 10, 2 );

