<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'bizy_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function bizy_custom_post_types_skins( $shortcode ) {

    $aheto_skins  = $shortcode->params['skin']['options'];
    $aheto_addon_skins = array(
        'bizy_skin-1' => 'Bizy skin 1',
    );
    $all_skins = array_merge( $aheto_skins, $aheto_addon_skins );
    $shortcode->params['skin']['options'] = $all_skins;

    $shortcode->add_params([

    ]);
}
function bizy_cpt_skin1_dynamic_css($css, $shortcode) {
    return $css;
}

add_filter('aheto_cpt_skin_dynamic_css', 'bizy_cpt_skin1_dynamic_css', 10, 2);