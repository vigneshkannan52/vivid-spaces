<?php

add_action( 'aheto_before_aheto_contents_register', 'snapster_contents_layout1_shortcode' );

/**
 * Contents Shortcode
 */

function snapster_contents_layout1_shortcode( $shortcode ) {

    $theme_dir = SNAPSTER_T_URI . '/aheto/contents/previews/';

    $shortcode->add_layout( 'snapster_layout1', [
        'title' => esc_html__( 'Snapster Faq', 'snapster' ),
        'image' => $theme_dir . 'snapster_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'snapster_use_title_typo', 'template', 'snapster_layout1' );
    $shortcode->add_dependecy( 'snapster_title_typo', 'snapster_use_title_typo', 'true' );
    $shortcode->add_dependecy( 'snapster_use_text_typo', 'template', 'snapster_layout1' );
    $shortcode->add_dependecy( 'snapster_text_typo', 'snapster_use_text_typo', 'true' );

    snapster_add_dependency( ['faqs', 'multi_active', 'first_is_opened'], [ 'snapster_layout1' ], $shortcode );

    $shortcode->add_params( [

        'snapster_use_title_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Title?', 'snapster' ),
            'grid'    => 12,
            'default' => '',
        ],
        'snapster_title_typo' => [
            'type' => 'typography',
            'group' => 'Snapster Title Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__title',
        ],
        'snapster_use_text_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Description?', 'snapster' ),
            'grid'    => 12,
            'default' => '',
        ],
        'snapster_text_typo' => [
            'type' => 'typography',
            'group' => 'Snapster Description Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__desc',
        ],
    ] );
}

function snapster_contents_layout1_shortcode_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['snapster_use_title_typo'] ) && ! empty( $shortcode->atts['snapster_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contents__title'], $shortcode->parse_typography( $shortcode->atts['snapster_title_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['snapster_use_text_typo'] ) && ! empty( $shortcode->atts['snapster_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contents__desc'], $shortcode->parse_typography( $shortcode->atts['snapster_text_typo'] ) );
    }
    return $css;
}
add_filter( 'aheto_contents_dynamic_css', 'snapster_contents_layout1_shortcode_dynamic_css', 10, 2 );