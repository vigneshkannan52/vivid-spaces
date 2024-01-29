<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'noize_contents_layout2' );

/**
 * Contents Shortcode
 */
function noize_contents_layout2( $shortcode ) {
    $preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contents/previews/'; 

    $shortcode->add_layout( 'noize_layout2', [
        'title' => esc_html__( 'Noize Simple Text', 'noize' ),
        'image' => $preview_dir . 'noize_layout2.jpg',
    ] );

    $shortcode->add_dependecy( 'noize_simple_text', 'template', 'noize_layout2' );

    $shortcode->add_dependecy( 'noize_use_typo_simple_text', 'template', 'noize_layout2' );
    $shortcode->add_dependecy( 'noize_text_typo_simple_text', 'template', 'noize_layout2' );
    $shortcode->add_dependecy( 'noize_text_typo_simple_text', 'noize_use_typo_simple_text', 'true' );

    $shortcode->add_params( [
        'noize_simple_text'    => [
            'type'    => 'wysiwyg',
            'heading' => esc_html__( 'Text Simple', 'noize' ),
            'default' => esc_html__( 'Put your text...', 'noize' ),
        ],
        'noize_use_typo_simple_text'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for simple text?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_simple_text'   => [
            'type'     => 'typography',
            'group'    => 'Noize Simple Text Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents--noize-lay2 > p, .aheto-contents--noize-lay2 > p > a',
        ],
    ] );
}

function noize_contents_layout2_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_typo_simple_text'] ) && ! empty( $shortcode->atts['noize_text_typo_simple_text'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contents--noize-lay2 > p, .aheto-contents--noize-lay2 > p > a'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_simple_text'] ) );
    }

    return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'noize_contents_layout2_dynamic_css', 10, 2 );