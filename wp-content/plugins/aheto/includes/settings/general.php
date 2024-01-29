<?php
/**
 * General settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     FOX-THEMES <info@foxthemes.me>
 */

use Aheto\Helper;
use Aheto\Admin;

$cmb->add_field([
	'id'      => 'builder',
	'type'    => 'select',
	'name'    => __( '<i class="fas fa-grip-horizontal"></i> <span>Default Builder</span>', 'aheto' ),
	'options' => [
		'elementor'       => esc_html__( 'Elementor', 'aheto' ),
		'visual-composer' => esc_html__( 'Visual Composer', 'aheto' ),
	],
	'desc'    => esc_html__( 'Please, choose  Page Builder for your theme.', 'aheto' ),
]);

$cmb->add_field( [
	'id'      => 'multiply_skins',
	'type'    => 'switch',
	'name'    => __( '<i class="fas fa-magic"></i> <span>Disable multiply skins</span>', 'aheto' ),
	'desc'    => esc_html__( 'Turn on if you want to use only one skin ', 'aheto' ),
	'default' => 'off',
] );


$cmb->add_field([
	'id'      => 'skin',
	'type'    => 'search_select',
	'name'    => __( '<i class="fas fa-paint-brush"></i> <span>Skins</span>', 'aheto' ),
	'options' => Helper::skins(),
	'desc'    => esc_html__( 'Please, choose main skin for your theme.', 'aheto' ),
	'attributes'    => array(
		'data-conditional-id'     => 'multiply_skins',
		'data-conditional-value'  => 'off',
	),
]);

$cmb->add_field([
	'id'      => 'header',
	'type'    => 'image_select',
	'name'    => __( '<i class="fas fa-equals"></i> <span>Global Header</span>', 'aheto' ),
	'options' => Helper::choices_posts_images_by_type( 'aheto-header', esc_html__( 'Select header', 'aheto' ) ),
	'desc'    => esc_html__( 'Please, choose main header for your theme.', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'footer',
	'type'    => 'image_select',
	'name'    => __( '<i class="fas fa-money-check"></i> <span>Global Footer</span>', 'aheto' ),
	'options' => Helper::choices_posts_images_by_type( 'aheto-footer', esc_html__( 'Select footer', 'aheto' ) ),
	'desc'    => esc_html__( 'Please, choose main footer for your theme.', 'aheto' ),
]);


$cmb->add_field([
	'id'      => 'font-icons',
	'type'    => 'multicheck',
	'name'    => __( '<i class="fas fa-list-alt"></i> <span>Additional Icon Font sets</span>', 'aheto' ),
	'desc'    => esc_html__( 'Select icon font sets you want to enable', 'aheto' ),
	'options' => [
		'elegant'          => esc_html__( 'Elegant', 'aheto' ),
		'font-awesome'     => esc_html__( 'Font Awesome', 'aheto' ),
		'ionicons'         => esc_html__( 'Ion Icons', 'aheto' ),
		'pe-icon-7-stroke' => esc_html__( 'Stroke Icon 7', 'aheto' ),
		'themify'          => esc_html__( 'Themify Icons', 'aheto' ),
	],
	'default' => 'ionicons',
]);

$cmb->add_field([
	'id'      => '404_redirect',
	'type'    => 'select',
	'name'    => __( '<i class="fas fa-exclamation-triangle"></i> <span>404 redirect page</span>', 'aheto' ),
	'options' => Helper::choices_pages( 'page', esc_html__( 'Select page', 'aheto' )),
	'default' => '0',
	'desc'    => esc_html__( 'If you don\'t use custom 404 redirect page, it\'ll be default 404 page from your theme.', 'aheto' ),
]);

$cmb->add_field([
	'id'      => '404_redirect_slug',
	'type'    => 'switch',
	'name'    => __( '<i class="fas fa-exclamation-triangle"></i> <span>404 redirect slug</span>', 'aheto' ),
	'desc'    => esc_html__( 'Turn on to change your 404 page slug for default "404".', 'aheto' ),
	'default' => 'off',
]);

$aheto_addon  = WP_PLUGIN_DIR . '/aheto-shortcodes-add-ons/index.php';

if(file_exists( $aheto_addon ) ){

	$cmb->add_field( [
		'id'      => 'use_real_images',
		'type'    => 'switch',
		'name'    => __( '<i class="fas fa-list-alt"></i> <span>Use real Images on Template Kits</span>', 'aheto' ),
		'desc'    => esc_html__( 'Turn on to import with real images ', 'aheto' ),
		'default' => 'off',
	] );

	$cmb->add_field( [
		'id'      => 'replace_shortcode_name',
		'type'    => 'switch',
		'name'    => __( '<i class="fas fa-exclamation-triangle"></i> <span>Turn on to replace Template kits with new names</span>', 'aheto' ),
		'desc'    => esc_html__( 'Turn on to import with real images ', 'aheto' ),
		'default' => 'on',
	] );


}

