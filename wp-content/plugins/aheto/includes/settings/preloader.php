<?php
/**
 * Preloader Settings.
 *
 * @since      1.0.8
 * @package    Aheto
 * @subpackage Aheto
 * @author     FOX-THEMES <info@foxthemes.me>
 */

use Aheto\Helper;
use Aheto\Admin;


$cmb->add_field([
	'id'      => 'preloader',
	'type'    => 'select',
	'name'    => __( '<i class="fas fa-spinner"></i> <span>Preloader</span>', 'aheto' ),
	'options' => [
		'none'       => esc_html__( 'None', 'aheto' ),
		'simple' => esc_html__( 'Simple', 'aheto' ),
		'spinner' => esc_html__( 'Spinner', 'aheto' ),
		'with_text' => esc_html__( 'With text', 'aheto' ),
		'with_image' => esc_html__( 'With image', 'aheto' ),
		'custom' => esc_html__( 'Custom', 'aheto' ),
	],
	'default' => 'none',
	'desc'    => esc_html__( 'Please, choose Preloader style.', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'preloader_text',
	'type'    => 'text',
	'name'    => __( '<i class="fas fa-pen"></i> <span>Text for Preloader</span>', 'aheto' ),
	'desc'    => esc_html__( 'This options only for preloader style "With text"', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'preloader_image',
	'type'    => 'file',
	'name'    => __( '<i class="fas fa-image "></i> <span>Image for Preloader</span>', 'aheto' ),
	'desc'    => esc_html__( 'This options only for preloader style "With image"', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'preloader_html',
	'type'    => 'textarea_code',
	'name'    => __( '<i class="fas fa-pen"></i> <span>Custom Html for preloader</span>', 'aheto' ),
	'desc'    => esc_html__( 'This options only for preloader style "Custom". Also you can add your CSS and JS in General Settings -> Custom Code.', 'aheto' ),
]);


