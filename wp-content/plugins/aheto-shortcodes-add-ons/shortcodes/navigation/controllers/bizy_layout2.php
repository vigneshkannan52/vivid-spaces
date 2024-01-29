<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navigation_register', 'bizy_navigation_layout2' );


/**
 * Navigation Shortcode
 */

function bizy_navigation_layout2( $shortcode ) {

    $preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/navigation/previews/';

    $shortcode->add_layout( 'bizy_layout2', [
        'title' => esc_html__( 'Bizy Simple', 'bizy' ),
        'image' => $preview_dir . 'bizy_layout2.jpg',
    ] );


    aheto_addon_add_dependency( ['max_width', 'type_logo', 'mob_logo', 'transparent', 'add_scroll_logo', 'add_mob_scroll_logo', 'use_mob_menu_title_typo', 'mob_menu_title_typo', 'use_mega_menu_title_typo', 'mega_menu_title_typo', 'use_menu_link_typo', 'menu_link_typo', 'use_logo_typo', 'logo_typo', 'logo', 'text_logo', 'scroll_logo', 'scroll_mob_logo', 'mobile_menu_width'], [ 'bizy_layout2' ], $shortcode );

//    $shortcode->add_dependecy( 'bizy_use_logo_typo', 'template', 'bizy_layout2' );
//    $shortcode->add_dependecy( 'bizy_logo_typo', 'template', 'bizy_layout2' );
//    $shortcode->add_dependecy( 'bizy_logo_typo', 'bizy_use_logo_typo', 'true' );
//    $shortcode->add_dependecy( 'bizy_use_menu_typo', 'template', 'bizy_layout2' );
//    $shortcode->add_dependecy( 'bizy_menu_typo', 'template', 'bizy_layout2' );
//    $shortcode->add_dependecy( 'bizy_menu_typo', 'bizy_use_menu_typo', 'true' );
//    $shortcode->add_dependecy( 'bizy_use_megamenu_title_typo', 'template', 'bizy_layout2' );
//    $shortcode->add_dependecy( 'bizy_megamenu_title_typo', 'template', 'bizy_layout2' );
//    $shortcode->add_dependecy( 'bizy_megamenu_title_typo', 'bizy_use_megamenu_title_typo', 'true' );

    $shortcode->add_params( [
//        'bizy_use_logo_typo' => [
//            'type'    => 'switch',
//            'heading' => esc_html__( 'Use custom font for logo?', 'bizy' ),
//            'grid'    => 6,
//        ],
//
//        'bizy_logo_typo' => [
//            'type'     => 'typography',
//            'group'    => 'Bizy Logo Typography',
//            'settings' => [
//                'tag'        => false,
//            ],
//            'selector' => '{{WRAPPER}} .main-header__logo span',
//        ],
//        'bizy_use_menu_typo' => [
//            'type'    => 'switch',
//            'heading' => esc_html__( 'Use custom font for menu items?', 'bizy' ),
//            'grid'    => 6,
//        ],
//
//        'bizy_menu_typo' => [
//            'type'     => 'typography',
//            'group'    => 'Bizy Menu Items Typography',
//            'settings' => [
//                'tag'        => false,
//            ],
//            'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu>li>a, {{WRAPPER}} .main-header__menu-box>ul>li>a, {{WRAPPER}} .main-header__menu-box-title, {{WRAPPER}} .main-header__menu-box .btn-close, {{WRAPPER}} .main-header__menu-box .menu-item--mega-menu .mega-menu__col',
//        ],
//        'bizy_use_megamenu_title_typo' => [
//            'type'    => 'switch',
//            'heading' => esc_html__( 'Use custom font for Mega menu title?', 'bizy' ),
//            'grid'    => 6,
//        ],
//
//        'bizy_megamenu_title_typo' => [
//            'type'     => 'typography',
//            'group'    => 'Bizy Mega Menu Title Typography',
//            'settings' => [
//                'tag'        => false,
//            ],
//            'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu .menu-item--mega-menu .mega-menu__title, {{WRAPPER}} .main-header__menu-box>ul .menu-item--mega-menu .mega-menu__title',
//        ],
    ] );


    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'bizy_',
        'group'      => 'Bizy Desktop button',
        'icons'      => true,
        'add_button' => true,
        'dependency' => [ 'template', [ 'bizy_layout2' ] ]
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'bizy_scroll_',
        'group'      => 'Bizy Scroll button',
        'icons'      => true,
        'add_button' => true,
        'dependency' => [ 'template', [ 'bizy_layout2' ] ]
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'bizy_mob_',
        'group'      => 'Bizy Mobile button',
        'icons'      => true,
        'add_button' => true,
        'dependency' => [ 'template', [ 'bizy_layout2' ] ]
    ] );
}



function bizy_navigation_layout2_shortcode_dynamic_css( $css, $shortcode ) {

//    if ( ! empty( $shortcode->atts['bizy_use_logo_typo'] ) && ! empty( $shortcode->atts['bizy_logo_typo'] ) ) {
//        \aheto_add_props( $css['global']['%1$s .main-header__logo span'], $shortcode->parse_typography( $shortcode->atts['bizy_logo_typo'] ) );
//    }
//
//    if ( ! empty( $shortcode->atts['bizy_use_menu_typo'] ) && ! empty( $shortcode->atts['bizy_menu_typo'] ) ) {
//        \aheto_add_props( $css['global']['%1$s .main-header__menu-box .main-menu>li>a, %1$s .main-header__menu-box>ul>li>a, %1$s .main-header__menu-box-title, %1$s .main-header__menu-box .btn-close, %1$s .main-header__menu-box .menu-item--mega-menu .mega-menu__col'], $shortcode->parse_typography( $shortcode->atts['bizy_menu_typo'] ) );
//    }
//
//    if ( ! empty( $shortcode->atts['bizy_use_megamenu_title_typo'] ) && ! empty( $shortcode->atts['bizy_megamenu_title_typo'] ) ) {
//        \aheto_add_props( $css['global']['%1$s .main-header__menu-box .main-menu .menu-item--mega-menu .mega-menu__title, %1$s .main-header__menu-box>ul .menu-item--mega-menu .mega-menu__title'], $shortcode->parse_typography( $shortcode->atts['bizy_megamenu_title_typo'] ) );
//    }


    return $css;
}

add_filter( 'aheto_navigation_dynamic_css', 'bizy_navigation_layout2_shortcode_dynamic_css', 10, 2 );