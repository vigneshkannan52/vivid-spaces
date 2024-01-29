<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Include and setup custom metaboxes and fields.
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 *
 * @return array
 */

function whizzy_sample_metaboxes( array $meta_boxes ) {
	// Start with an underscore to hide fields from custom fields list
	$plugin_config = get_option( 'whizzy_settings' );

	$prefix = '_whizzy_';

	$meta_boxes[ 'test_metabox' ] = array(
		'id'         => 'whizzy',
		'title'      => esc_html__( 'Whizzy', 'whizzy' ),
		'pages'      => array( 'whizzy_proof_gallery', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'whizzy_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			'tab_one' => array(
				array(
					'name'       => esc_html__( 'Gallery', 'whizzy' ),
					'id'         => $prefix . 'main_gallery',
					'type'       => 'gallery',
					'show_names' => false,
				),
			),
			'tab_two' => array(
				array(
					'name'    => esc_html__( 'Choose Client', 'whizzy' ),
					'id'      => $prefix . 'client_select',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'From taxonomy', 'whizzy' ),
							'value' => 'tax'
						),
						array(
							'name'  => esc_html__( 'Custom', 'whizzy' ),
							'value' => 'cust'
						),
					),
					'std'     => 'fullwidth',
				),

				array(
					'name' => esc_html__( 'Taxonomy client', 'whizzy' ),
					'id' => $prefix . 'clients_list',
					'taxonomy' => 'whizzy-client', //Enter Taxonomy Slug
					'type' => 'taxonomy_select',
				),
				array(
					'name' => esc_html__( 'Custom client name', 'whizzy' ),
					//				'desc' => esc_html__( 'field description (optional)', 'whizzy' ),
					'id'   => $prefix . 'client_name',
					'type' => 'text',
				),
				array(
					'name' => esc_html__( 'Date', 'whizzy' ),
					'id'   => $prefix . 'event_date',
					'type' => 'text_date',
				),
				array(
					'name'    => esc_html__( 'Photos Display Name', 'whizzy' ),
					'desc'    => esc_html__( 'How would you like to identify each photo?', 'whizzy' ),
					'id'      => $prefix . 'photo_display_name',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Unique IDs', 'whizzy' ),
							'value' => 'unique_ids'
						),
						array(
							'name'  => esc_html__( 'Consecutive IDs', 'whizzy' ),
							'value' => 'consecutive_ids'
						),
						array(
							'name'  => esc_html__( 'File Name', 'whizzy' ),
							'value' => 'file_name'
						),
						array(
							'name'  => esc_html__( 'Unique IDs and Photo Title', 'whizzy' ),
							'value' => 'unique_ids_photo_title'
						),
						array(
							'name'  => esc_html__( 'Consecutive IDs and Photo Title', 'whizzy' ),
							'value' => 'consecutive_ids_photo_title'
						),
					),
					'std'     => 'fullwidth',
				),
				array(
					'name' => esc_html__( 'Show button "Download zip"', 'whizzy' ),
					'desc' => esc_html__( 'Do you want to it?', 'whizzy' ),
					'id'   => $prefix . 'show_zip_button',
					'type' => 'checkbox',
				),
				array(
					'name' => esc_html__( 'Show button "Download pdf"', 'whizzy' ),
					'desc' => esc_html__( 'Do you want to it?', 'whizzy' ),
					'id'   => $prefix . 'show_pdf_button',
					'type' => 'checkbox',
				),
				array(
					'name'    => esc_html__( 'Gallery style', 'whizzy' ),
					'id'      => $prefix . 'style',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Grid', 'whizzy' ),
							'value' => 'grid'
						),
						array(
							'name'  => esc_html__( 'Masonry', 'whizzy' ),
							'value' => 'masonry'
						),
					),
					'std'     => 'fullwidth',
				),
				array(
					'name'    => esc_html__( 'Enable filters for gallery?', 'whizzy' ),
					'id'      => $prefix . 'filters',
					'type'    => 'select',
					'desc'    => esc_html__( 'Only for style Masonry', 'whizzy' ),
					'options' => array(
						array(
							'name'  => esc_html__( 'No', 'whizzy' ),
							'value' => 'no'
						),
						array(
							'name'  => esc_html__( 'Yes', 'whizzy' ),
							'value' => 'yes'
						),
					),
					'std'     => 'fullwidth',
				),
				array(
					'name'    => esc_html__( 'Gallery columns', 'whizzy' ),
					'id'      => $prefix . 'columns',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Four', 'whizzy' ),
							'value' => '3'
						),
						array(
							'name'  => esc_html__( 'Three', 'whizzy' ),
							'value' => '4'
						),
						array(
							'name'  => esc_html__( 'Two', 'whizzy' ),
							'value' => '6'
						),
					),
					'std'     => 'fullwidth',
				),
				array(
					'name' => esc_html__( 'Gallery space', 'whizzy' ),
					'id'   => $prefix . 'space',
					'type' => 'text',
					'desc' => esc_html__( 'Only number (in px). Default - 15px.', 'whizzy' ),
				),
				array(
					'name'    => esc_html__( 'Gallery popup', 'whizzy' ),
					'id'      => $prefix . 'popup',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Magnific Popup', 'whizzy' ),
							'value' => 'cla'
						),
						array(
							'name'  => esc_html__( 'LightGallery Popup', 'whizzy' ),
							'value' => 'mod'
						),
					),
					'std'     => 'fullwidth',
				),
				array (
					'name'    => esc_html__( 'Whizzy position in content', 'whizzy' ),
					'id'      => $prefix . 'position',
					'type'    => 'select',
					'options' => array(
						array(
							'name'  => esc_html__( 'Before the content', 'whizzy' ),
							'value' => 'before'
						),
						array(
							'name'  => esc_html__( 'After the content', 'whizzy' ),
							'value' => 'after'
						),
					),
					'std'     => 'fullwidth',
				),

			),

		),
	);

	if ( ( !empty($plugin_config[ 'enable_archive_zip_download' ]) ? $plugin_config[ 'enable_archive_zip_download' ] : '' ) && ( ! isset( $plugin_config[ 'zip_archive_generation' ] ) || $plugin_config[ 'zip_archive_generation' ] == 'manual' ) ) {
		array_push( $meta_boxes[ 'test_metabox' ][ 'fields' ]['tab_two'], array(
			'name' => esc_html__( 'Client .zip archive', 'whizzy' ),
			'desc' => esc_html__( 'Upload a .zip archive so the client can download it via the Download link. Leave it empty to hide the link.', 'whizzy' ),
			'id'   => $prefix . 'file',
			'type' => 'file',
		) );
	}

	if ( ( !empty($plugin_config[ 'enable_archive_zip_download' ]) ? $plugin_config[ 'enable_archive_zip_download' ] : '' ) && ( ! isset( $plugin_config[ 'zip_archive_generation' ] ) || $plugin_config[ 'zip_archive_generation' ] !== 'manual' ) ) {
		array_push( $meta_boxes[ 'test_metabox' ][ 'fields' ]['tab_two'], array(
			'name' => esc_html__( 'Disable Archive Download', 'whizzy' ),
			'desc' => esc_html__( 'You can remove the ability to download the zip archive for this gallery', 'whizzy' ),
			'id'   => $prefix . 'disable_archive_download',
			'type' => 'checkbox',
		) );
	}

	// Add other metaboxes as needed
	return apply_filters( 'whizzy_meta_boxes_settings', $meta_boxes );
}
add_filter( 'whizzy_meta_boxes', 'whizzy_sample_metaboxes' );

/**
 * Initialize the metabox class.
 */
function whizzy_initialize_whizzy_meta_boxes() {
	if ( ! class_exists( 'whizzy_Meta_Box' ) ) {
		require_once 'init.php';
	}
}
add_action( 'init', 'whizzy_initialize_whizzy_meta_boxes', 9999 );
