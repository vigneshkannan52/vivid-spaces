<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$settings = get_option('whizzy_settings');

$single_label = esc_html_x( 'Whizzy', 'Post Type Singular Name', 'whizzy' );
if ( isset( $settings['whizzy_single_item_label'] ) && ! empty( $settings['whizzy_single_item_label'] ) ) {
	$single_label = $settings['whizzy_single_item_label'];
}

$name = esc_html_x( 'Whizzy', 'Post Type General Name', 'whizzy' );
$menu_name = esc_html__( 'Whizzy', 'whizzy' );
if ( isset( $settings['whizzy_multiple_items_label'] ) && !empty( $settings['whizzy_multiple_items_label'] ) ) {
	$name = $menu_name = $settings['whizzy_multiple_items_label'];
}

$slug = 'whizzy_proof_gallery';
if ( isset( $settings['whizzy_change_single_item_slug'] ) && ( $settings['whizzy_change_single_item_slug'] ) && ! empty( $settings['whizzy_proof_gallery_new_single_item_slug'] ) ) {
	$slug = $settings['whizzy_proof_gallery_new_single_item_slug'];
}

$rewrite = array( 'slug' => esc_html( $slug ) );

$labels = array(
	'name'                => esc_html( $name ),
	'singular_name'       => esc_html( $single_label ),
	'menu_name'           => esc_html( $menu_name ),
	'parent_item_colon'   => esc_html__( 'Parent Item:', 'whizzy' ),
	'all_items'           => esc_html__( 'All Items', 'whizzy' ),
	'view_item'           => esc_html__( 'View Item', 'whizzy' ),
	'add_new_item'        => esc_html__( 'Add New Whizzy', 'whizzy' ),
	'add_new'             => esc_html__( 'Add New', 'whizzy' ),
	'edit_item'           => esc_html__( 'Edit Whizzy', 'whizzy' ),
	'update_item'         => esc_html__( 'Update Whizzy', 'whizzy' ),
	'search_items'        => esc_html__( 'Search Whizzy', 'whizzy' ),
	'not_found'           => esc_html__( 'Not found', 'whizzy' ),
	'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'whizzy' ),
);

$args = array(
	'label'               => esc_html( $single_label ),
	'description'         => esc_html( $menu_name ),
	'labels'              => $labels,
	'supports'            => array( 'title', 'thumbnail', 'editor', 'comments', 'revisions', 'page-attributes', ),
	'hierarchical'        => true,
	'public'              => true,
	'show_ui'             => true,
	'show_in_menu'        => true,
	'show_in_nav_menus'   => true,
	'show_in_admin_bar'   => true,
	'menu_position'       => NULL,
	'menu_icon'           => 'dashicons-images-alt2',
	'can_export'          => true,
	'has_archive'         => false,
	'exclude_from_search' => true,
	'publicly_queryable'  => true,
	'query_var'           => esc_html( $slug ),
	'rewrite'             => $rewrite,
	'capability_type'     => 'page',
	'yarpp_support' => false,
);
register_post_type( 'whizzy_proof_gallery', $args );

$taxonomy_labels = array(
	'name'                       => esc_html__( 'Category','whizzy' ),
	'singular_name'              => esc_html__( 'Category','whizzy' ),
	'menu_name'                  => esc_html__( 'Categories','whizzy' ),
	'all_items'                  => esc_html__( 'All Categories','whizzy' ),
	'parent_item'                => esc_html__( 'Parent Category','whizzy' ),
	'parent_item_colon'          => esc_html__( 'Parent Category:','whizzy' ),
	'new_item_name'              => esc_html__( 'New Category Name','whizzy' ),
	'add_new_item'               => esc_html__( 'Add New Category','whizzy' ),
	'edit_item'                  => esc_html__( 'Edit Category','whizzy' ),
	'update_item'                => esc_html__( 'Update Category','whizzy' ),
	'separate_items_with_commas' => esc_html__( 'Separate categories with commas','whizzy' ),
	'search_items'               => esc_html__( 'Search categories','whizzy' ),
	'add_or_remove_items'        => esc_html__( 'Add or remove categories','whizzy' ),
	'choose_from_most_used'      => esc_html__( 'Choose from the most used categories','whizzy' )
);

$taxonomy_rewrite = array(
	'slug'         => 'whizzy-category',
	'with_front'   => true,
	'hierarchical' => true,
);

$taxonomy_args = array(
	'labels'            => $taxonomy_labels,
	'hierarchical'      => true,
	'public'            => true,
	'show_ui'           => true,
	'show_admin_column' => true,
	'show_in_nav_menus' => true,
	'query_var'         => true,
	'show_tagcloud'     => true,
	'rewrite'           => $taxonomy_rewrite,
);
register_taxonomy( 'whizzy-category', array( 'whizzy_proof_gallery' ), $taxonomy_args );


$taxonomy_labels = array(
	'name'                       => esc_html__( 'Tag','whizzy' ),
	'singular_name'              => esc_html__( 'Tag','whizzy' ),
	'menu_name'                  => esc_html__( 'Tags','whizzy' ),
	'all_items'                  => esc_html__( 'All Tags','whizzy' ),
	'parent_item'                => esc_html__( 'Parent Tag','whizzy' ),
	'parent_item_colon'          => esc_html__( 'Parent Tag:','whizzy' ),
	'new_item_name'              => esc_html__( 'New Tag Name','whizzy' ),
	'add_new_item'               => esc_html__( 'Add New Tag','whizzy' ),
	'edit_item'                  => esc_html__( 'Edit Tag','whizzy' ),
	'update_item'                => esc_html__( 'Update Tag','whizzy' ),
	'separate_items_with_commas' => esc_html__( 'Separate categories with commas','whizzy' ),
	'search_items'               => esc_html__( 'Search categories','whizzy' ),
	'add_or_remove_items'        => esc_html__( 'Add or remove categories','whizzy' ),
	'choose_from_most_used'      => esc_html__( 'Choose from the most used categories','whizzy' )
);

$taxonomy_rewrite = array(
	'slug'         => 'whizzy-tag',
	'with_front'   => true,
	'hierarchical' => true,
);

$taxonomy_args = array(
	'labels'            => $taxonomy_labels,
	'hierarchical'      => true,
	'public'            => true,
	'show_ui'           => true,
	'show_admin_column' => true,
	'show_in_nav_menus' => true,
	'query_var'         => true,
	'show_tagcloud'     => true,
	'rewrite'           => $taxonomy_rewrite,
);
register_taxonomy( 'whizzy-tag', array( 'whizzy_proof_gallery' ), $taxonomy_args );



$taxonomy_labels = array(
	'name'                       => esc_html__( 'Client','whizzy' ),
	'singular_name'              => esc_html__( 'Client','whizzy' ),
	'menu_name'                  => esc_html__( 'Clients','whizzy' ),
	'all_items'                  => esc_html__( 'All Clients','whizzy' ),
	'parent_item'                => esc_html__( 'Parent Client','whizzy' ),
	'parent_item_colon'          => esc_html__( 'Parent Client:','whizzy' ),
	'new_item_name'              => esc_html__( 'New Client Name','whizzy' ),
	'add_new_item'               => esc_html__( 'Add New Client','whizzy' ),
	'edit_item'                  => esc_html__( 'Edit Client Info','whizzy' ),
	'update_item'                => esc_html__( 'Update Client','whizzy' ),
	'separate_items_with_commas' => esc_html__( 'Separate clients with commas','whizzy' ),
	'search_items'               => esc_html__( 'Search clients','whizzy' ),
	'add_or_remove_items'        => esc_html__( 'Add or remove clients','whizzy' ),
	'choose_from_most_used'      => esc_html__( 'Choose from the most used clients','whizzy' )
);

$taxonomy_rewrite = array(
	'slug'         => 'whizzy-client',
	'with_front'   => true,
	'hierarchical' => true,
);

$taxonomy_args = array(
	'labels'            => $taxonomy_labels,
	'hierarchical'      => true,
	'public'            => true,
	'show_ui'           => true,
	'show_admin_column' => true,
	'show_in_nav_menus' => true,
	'query_var'         => true,
	'show_tagcloud'     => true,
	'rewrite'           => $taxonomy_rewrite,
);
register_taxonomy( 'whizzy-client', array( 'whizzy_proof_gallery' ), $taxonomy_args );


// Remove action view for taxonomy whizzy-category
add_filter( 'whizzy-category_row_actions', 'whizzy_remove_category_action_view', 99 );

function whizzy_remove_category_action_view( $actions ) {
	unset( $actions['view'] );
    return $actions;
}

