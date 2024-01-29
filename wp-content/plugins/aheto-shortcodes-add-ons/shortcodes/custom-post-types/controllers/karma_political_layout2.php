<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'karma_political_custom_post_types_layout2' );

/**
 * Custom Post Type
 */

function karma_political_custom_post_types_layout2( $shortcode ) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/custom-post-types/previews/';

	$shortcode->add_layout( 'karma_political_layout2', [
        'title' => esc_html__( 'Karma Political Simple', 'karma' ),
        'image' => $preview_dir . 'karma_political_layout2.jpg',
    ] );

	$shortcode->add_dependecy( 'karma_political_row', 'template', 'karma_political_layout2' );
    $shortcode->add_dependecy( 'karma_political_align_btn', 'template', 'karma_political_layout2' );

	aheto_addon_add_dependency( [ 'skin', 'use_heading', 't_heading', 'title_tag' ], [ 'karma_political_layout2' ], $shortcode );

	$shortcode->add_params( [

        'karma_political_align_btn'         => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align Load Button', 'karma' ),
            'grid'    => 6,
            'options' => \Aheto\Helper::choices_alignment(),
        ],
        'karma_political_row'     => [
            'type'    => 'select',
            'heading' => esc_html__( 'Column Row', 'karma' ),
            'options' => [
                '2' => esc_html__( '2', 'karma' ),
                '3' => esc_html__( '3', 'karma' ),
                '4' => esc_html__( '4', 'karma' ),
            ],
            'default' => '3',
        ],

    ] );

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'karma_political_load_'
    ] );

}

add_filter( 'aheto_cpt_dynamic_css', 'karma_political_cpt_layout2_dynamic_css', 10, 2 );