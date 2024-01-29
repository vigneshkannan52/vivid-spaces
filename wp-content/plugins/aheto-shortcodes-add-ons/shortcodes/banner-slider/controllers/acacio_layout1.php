<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_banner-slider_register', 'acacio_banner_slider_layout1' );

/**
 *  Banner Slider
 */

function acacio_banner_slider_layout1( $shortcode ) {

    $preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/banner-slider/previews/';

    $shortcode->add_layout( 'acacio_layout1', [
        'title' => esc_html__( 'Acacio Modern', 'acacio' ),
        'image' => $preview_dir . 'acacio_layout1.jpg',
    ] );

    aheto_addon_add_dependency( ['use_heading', 't_heading'], [ 'acacio_layout1' ], $shortcode );
    

    $shortcode->add_dependecy( 'acacio_hide_pagination', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_modern_banners', 'template', 'acacio_layout1' );

    $shortcode->add_dependecy( 'acacio_use_bullets_color', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_bullet_color', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_bullet_color', 'acacio_use_bullets_color', 'true' );

    $shortcode->add_dependecy( 'acacio_use_bullets_color', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_bullet_color_active', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_bullet_color_active', 'acacio_use_bullets_color', 'true' );

    $shortcode->add_params( [
        'acacio_modern_banners' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Banners', 'acacio' ),
            'params'  => [
                'acacio_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Background Image', 'acacio' ),
                ],
                'acacio_heading_tag'      => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Element tag for title', 'acacio' ),
                    'options' => [
                        'h1'  => 'h1',
                        'h2'  => 'h2',
                        'h3'  => 'h3',
                        'h4'  => 'h4',
                        'h5'  => 'h5',
                        'h6'  => 'h6',
                        'p'   => 'p',
                        'div' => 'div',
                    ],
                    'default' => 'h2',
                ],
                'acacio_title'         => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Title', 'acacio' ),
                    'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]', 'acacio' ),
                    'admin_label' => true,
                    'default'     => esc_html__( 'Heading with [[ hightlight ]] text. For set some words for repeat animation separate them by coma : [[London,New York,Paris]]', 'acacio' ),
                ],
                'acacio_desc'          => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Description', 'acacio' ),
                ],
                'align' => [
                    'type'    => 'select',
                    'heading' => esc_html__('Align', 'acacio'),
                    'options' => \Aheto\Helper::choices_alignment(),
                ],
                'acacio_btn_direction' => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Buttons Direction', 'acacio' ),
                    'options' => [
                        ''            => esc_html__( 'Horizontal', 'acacio' ),
                        'is-vertical' => esc_html__( 'Vertical', 'acacio' ),
                    ],
                ],

            ]
        ],
        'acacio_use_bullets_color'    => [
            'type'      => 'switch',
            'heading'   => esc_html__('Add your colors for swiper bullets?', 'acacio'),
            'grid'      => 4,
        ],
        'acacio_bullet_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Swiper bullet color', 'acacio' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}}' ],
        ],
        'acacio_bullet_color_active' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Swiper bullet active color', 'acacio' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}}' ],
        ],

    ] );


    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'acacio_swiper_banner_',
        'include'        => [ 'effect', 'speed', 'loop', 'slides', 'autoplay','lazy', 'arrows', 'pagination', 'simulate_touch' ],
        'dependency'     => [ 'template', [ 'acacio_layout1' ] ]
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix' => 'acacio_main_',
    ], 'acacio_modern_banners' );

    \Aheto\Params::add_button_params( $shortcode, [
        'add_label' => esc_html__( 'Add additional button?', 'acacio' ),
        'prefix'    => 'acacio_add_',
    ], 'acacio_modern_banners' );

}


function acacio_banner_slider_layout1_dynamic_css( $css, $shortcode ) {

    if ( $shortcode->atts['acacio_use_bullet_color'] && ! empty( $shortcode->atts['acacio_bullet_color'] )  ) {
        $css['global']['%1$s .swiper-pagination-bullet']['background'] = \Aheto\Sanitize::color( $shortcode->atts['acacio_bullet_color'] );
    }

    if (! empty( $shortcode->atts['acacio_bullet_color_active'] )  ) {
        $css['global']['%1$s .swiper-pagination-bullet-active']['background'] = \Aheto\Sanitize::color( $shortcode->atts['acacio_bullet_color_active'] );
    }

    return $css;
}

add_filter( 'aheto_banner-slider_dynamic_css', 'acacio_banner_slider_layout1_dynamic_css', 10, 2 );
