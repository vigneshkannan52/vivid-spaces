<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $_wp_additional_image_sizes;

$sizes = get_intermediate_image_sizes();
$size_options = array(
	'thumbnail' => sprintf( __( 'Thumbnail ( %s x %s cropped )', 'whizzy' ), get_option( 'thumbnail_size_w' ), get_option( 'thumbnail_size_h ') ),
	'medium' => sprintf( __( 'Medium ( %s x %s cropped )', 'whizzy' ), get_option( 'medium_size_w' ), get_option( 'medium_size_h' ) ),
	'large' => sprintf( __( 'Large ( %s x %s cropped )', 'whizzy' ), get_option( 'large_size_w' ), get_option( 'large_size_h' ) ),
	'full' => esc_html__( 'Full size', 'whizzy' )
);

if ( is_array( $_wp_additional_image_sizes ) ) {
	foreach ( $_wp_additional_image_sizes as $key => $size ) {
		$size_options[ $key ] = ucfirst( $key );

		if ( isset( $size['width'] ) && isset( $size['height'] ) ) {
			$size_options[ $key ] .= ' ( ' .$size['width']. ' x ' . $size['height'];

			if ( isset( $size['crop'] ) && $size['crop']) {
				$size_options[ $key ] .= ' cropped';
			}

			$size_options[ $key ] .= ' )';
		}
	}
}

return array(
	'type'    => 'postbox',
	'label'   => esc_html__( 'Whizzy Settings', 'whizzy' ),
	// Custom field settings
	// ---------------------

	'options' => array(
		'enable_whizzy_proof_gallery_group' => array(
			'type'    => 'group',
			'options' => array(
				'whizzy_single_item_label'             => array(
					'label'   => esc_html__( 'Single Item Label', 'whizzy' ),
					'desc'    => esc_html__( 'Here you can change the singular label.The default is "Whizzy"', 'whizzy' ),
					'default' => esc_html__( 'Whizzy', 'whizzy' ),
					'type'    => 'text',
				),
				'whizzy_multiple_items_label'          => array(
					'label'   => esc_html__( 'Multiple Items Label (plural)', 'whizzy' ),
					'desc'    => esc_html__( 'Here you can change the plural label.The default is "Whizzy"', 'whizzy' ),
					'default' => esc_html__( 'Whizzy', 'whizzy' ),
					'type'    => 'text',
				),
				'whizzy_change_single_item_slug'       => array(
					'label'      => esc_html__( 'Change Gallery Slug', 'whizzy' ),
					'desc'       => esc_html__( 'Do you want to rewrite the single gallery item slug?', 'whizzy' ),
					'default'    => false,
					'type'       => 'switch',
					'show_group' => 'whizzy_change_single_item_slug_group',
				),
				'whizzy_change_single_item_slug_group' => array(
					'type'    => 'group',
					'options' => array(
						'whizzy_proof_gallery_new_single_item_slug' => array(
							'label'   => esc_html__( 'New Single Item Slug', 'whizzy' ),
							'desc'    => esc_html__( 'Change the single gallery slug as you need it.', 'whizzy' ),
							'default' => 'whizzy_proof_gallery',
							'type'    => 'text',
						),
					),
				),
                'whizzy_change_buttons_download'       => array(
                    'label'      => esc_html__( 'Change Text for ZIP/PDF download button', 'whizzy' ),
                    'desc'       => esc_html__( 'Do you want to change text for ZIP/PDF download button?', 'whizzy' ),
                    'default'    => false,
                    'type'       => 'switch',
                    'show_group' => 'whizzy_change_buttons_download_text',
                ),
                'whizzy_change_buttons_download_text' => array(
                    'type'    => 'group',
                    'options' => array(
                        'whizzy_change_zip_button_text' => array(
                            'label'   => esc_html__( 'Text for ZIP download button', 'whizzy' ),
                            'desc'    => esc_html__( 'Change the text for ZIP download button as you need it.', 'whizzy' ),
                            'default' => 'Download ZIP',
                            'type'    => 'text',
                        ),
                        'whizzy_change_pdf_button_text' => array(
                            'label'   => esc_html__( 'Text for PDF download button', 'whizzy' ),
                            'desc'    => esc_html__( 'Change the text for PDF download button as you need it.', 'whizzy' ),
                            'default' => 'Download PDF',
                            'type'    => 'text',
                        ),
                    ),
                ),
			),
		),
	)
); # config
