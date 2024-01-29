<?php
use Aheto\Helper;
add_action( 'aheto_before_aheto_contact-forms_register', 'mooseoom_contact_forms_layout3' );
/**
 * Contact forms
 */
function mooseoom_contact_forms_layout3( $shortcode ) {
	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contact-forms/previews/';

	$shortcode->add_layout( 'mooseoom_layout3', [
		'title' => esc_html__( 'Mooseoom form allfield', 'mooseoom' ),
		'image' => $preview_dir . 'mooseoom_layout3.jpg',
	] );

	$shortcode->add_dependecy( 'mooseoom_use_text_typo', 'template', 'mooseoom_layout3' );
	$shortcode->add_dependecy( 'mooseoom_text_typo', 'template', 'mooseoom_layout3' );
	$shortcode->add_dependecy( 'mooseoom_text_typo', 'mooseoom_use_text_typo', 'true' );
	
	$shortcode->add_dependecy( 'mooseoom_use_submit_typo', 'template','mooseoom_layout3');
	$shortcode->add_dependecy( 'mooseoom_submit_typo', 'template', 'mooseoom_layout3' );
	$shortcode->add_dependecy( 'mooseoom_submit_typo', 'mooseoom_use_submit_typo', 'true' );
	
	$shortcode->add_dependecy( 'mooseoom_use_validtip_typo', 'template', 'mooseoom_layout3' );
	$shortcode->add_dependecy( 'mooseoom_validtip_typo', 'template', 'mooseoom_layout3' );
	$shortcode->add_dependecy( 'mooseoom_validtip_typo', 'mooseoom_use_validtip_typo', 'true' );

	$shortcode->add_params([
	
		'mooseoom_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Text?', 'mooseoom' ),
			'grid'    => 3,
		],

		'mooseoom_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__form .wpcf7 input, {{WRAPPER}} .widget_aheto__form .wpcf7 textarea',
		],
		
		'mooseoom_use_submit_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Submit?', 'mooseoom' ),
			'grid'    => 3,
		],

		'mooseoom_submit_typo' => [
			'type'     => 'typography',
			'group'    => 'Submit Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__form .wpcf7 .wpcf7-submit',
		],
		
		'mooseoom_use_validtip_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for valid-tip?', 'mooseoom' ),
			'grid'    => 3,
		],

		'mooseoom_validtip_typo' => [
			'type'     => 'typography',
			'group'    => 'Valid-tip Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__form .wpcf7 span .wpcf7-not-valid-tip',
		],

	]);

}
function mooseoom_contact_forms_layout3_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['mooseoom_use_text_typo'] ) && ! empty( $shortcode->atts['mooseoom_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .widget_aheto__form .wpcf7 textarea, %1$s .widget_aheto__form .wpcf7 input'], $shortcode->parse_typography( $shortcode->atts['mooseoom_text_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['mooseoom_use_submit_typo'] ) && ! empty( $shortcode->atts['mooseoom_submit_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .widget_aheto__form .wpcf7 .wpcf7-submit'], $shortcode->parse_typography( $shortcode->atts['mooseoom_submit_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['mooseoom_use_validtip_typo'] ) && ! empty( $shortcode->atts['mooseoom_validtip_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .widget_aheto__form .wpcf7 span .wpcf7-not-valid-tip'], $shortcode->parse_typography( $shortcode->atts['mooseoom_validtip_typo'] ) );
	}
	
	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'mooseoom_contact_forms_layout3_dynamic_css', 10, 2 );

function mooseoom_contact_forms_layout3_button($form_button)
{

	$form_button['dependency'][1][] = 'mooseoom_layout3';

	return $form_button;
}

add_filter('aheto_button_contact-forms', 'mooseoom_contact_forms_layout3_button', 10, 2);