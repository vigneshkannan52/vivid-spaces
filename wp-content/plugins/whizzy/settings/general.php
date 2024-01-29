<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//not used yet - moved them to a per gallery option
$params = array(
	'type'    => 'postbox',
	'label'   => esc_html__( 'General Settings', 'whizzy' ),
	'options' => array(
        'enable_whizzy_style'   => array(
            'label'          => esc_html__( 'Enable Whizzy Styles', 'whizzy' ),
            'default'        => true,
            'type'           => 'switch',
            'display_option' => true,
        ),
		'enable_archive_zip_download'   => array(
			'label'          => esc_html__( 'Enable Images Download', 'whizzy' ),
			'default'        => true,
			'type'           => 'switch',
			'show_group'     => 'enable_whizzy_proof_gallery_group',
			'display_option' => true,
		),
        /* ALL THESE PREFIXED WITH PORTFOLIO SHOULD BE KIDS!! **/
		'enable_whizzy_proof_gallery_group' => array(
			'type'    => 'group',
			'options' => array(
				'zip_archive_generation' => array(
					'name'    => 'zip_archive_generation',
					'label'   => esc_html__( 'The ZIP archive should be generated:', 'whizzy' ),
					'desc'    => esc_html__( 'How the archive file should be generated?', 'whizzy' ),
					'default' => 'manual',
					'type'    => 'select',
					'options' => array(
						'manual'    => esc_html__( 'Manually (uploaded by the gallery owner)', 'whizzy' ),
						'automatic' => esc_html__( 'Automatically (from the selected images)', 'whizzy' ),
					),
				),
			),
		),
	),
); # config

return apply_filters( 'whizzy_config_fields_general', $params );
