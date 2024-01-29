<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

return array(
	# Hidden fields
	'settings_saved_once' => '0',
	# General
	'enable_whizzy_style' => true,
	'enable_archive_zip_download' => true,
	'zip_archive_generation' => 'manual',
	# "Post Types" fields
	'gallery_position_in_content' => 'before',
	'whizzy_single_item_label' => esc_html__( 'Whizzy', 'whizzy' ),
	'whizzy_multiple_items_label' => esc_html__( 'Whizzy', 'whizzy' ),
	'whizzy_change_single_item_slug' => false,
	'whizzy_proof_gallery_new_single_item_slug' => 'whizzy_proof_gallery',
	'enable_whizzy_proof_gallery_global_style' => false,
	'gallery_thumbnail_sizes' => 'medium',
	'gallery_grid_sizes' => 3,
); # config
