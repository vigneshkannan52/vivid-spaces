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


$cmb->add_field( [
	'id'      => 'lazyload',
	'type'    => 'select',
	'name'    => __( '<i class="fas fa-images"></i> <span>Lazy Load</span>', 'aheto' ),
	'options' => [
		'disable' => esc_html__( 'Disable', 'aheto' ),
		'enable'  => esc_html__( 'Enable', 'aheto' ),
	],
	'default' => 'disable',
	'desc'    => esc_html__( 'This option enable/disable lazy load for images on your site.', 'aheto' ),
] );

$cmb->add_field( [
	'id'      => 'custom_css_including',
	'type'    => 'select',
	'name'    => __( '<i class="fas fa-file-alt "></i> <span>Custom Css Including</span>', 'aheto' ),
	'options' => [
		'disabled' => esc_html__( 'Disable', 'aheto' ),
		'enabled'  => esc_html__( 'Enable', 'aheto' ),
	],
	'default' => 'disable',
	'desc'    => esc_html__( 'This option enable/disable custom css styles ( from theme and plugin ) on your site.', 'aheto' ),
] );


$cmb->add_field( [
	'id'      => 'preload_css',
	'type'    => 'select',
	'name'    => __( '<i class="fas fa-file-code"></i> <span>Enable preload attribute for CSS </span>', 'aheto' ),
	'options' => [
		'disabled' => esc_html__( 'Disable', 'aheto' ),
		'enabled'  => esc_html__( 'Enable', 'aheto' ),
	],
	'default' => 'disable',
	'desc'    => __( 'This option enable/disable preload attribute for &#60;link&#62; tag in &#60;head&#62; on your site.', 'aheto' ),
] );


$cmb->add_field( [
	'id'      => 'defer_js',
	'type'    => 'select',
	'name'    => __( '<i class="far fa-file-code"></i> <span>Enable defer attribute for JS </span>', 'aheto' ),
	'options' => [
		'disabled' => esc_html__( 'Disable', 'aheto' ),
		'enabled'  => esc_html__( 'Enable', 'aheto' ),
	],
	'default' => 'disable',
	'desc'    => __( 'This option enable/disable defer attribute for &#60;script&#62; tag on your site.', 'aheto' ),
] );