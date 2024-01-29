<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'ninedok_features_single_layout1');

/**
 * Features Single
 */

function ninedok_features_single_layout1($shortcode)
{

    $preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/features-single/previews/';

    $shortcode->add_layout('ninedok_layout1', [
        'title' => esc_html__('Ninedok Minimal', 'ninedok'),
        'image' => $preview_dir . 'ninedok_layout1.jpg',
    ]);

    aheto_addon_add_dependency(['s_image', 's_heading', 'use_heading', 't_heading', 's_description', 'use_description', 't_description' ], ['ninedok_layout1'], $shortcode);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'ninedok_',
        'dependency' => ['template', ['ninedok_layout1']]
    ]);
}