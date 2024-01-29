<?php

add_action('aheto_before_aheto_features-single_register', 'snapster_features_single_layout2_shortcode');

/**
 * Features Single Shortcode
 */
function snapster_features_single_layout2_shortcode($shortcode){

    $theme_dir = SNAPSTER_T_URI . '/aheto/features-single/previews/';

    $shortcode->add_layout('snapster_layout2', [
        'title' => esc_html__('Snapster Minimal', 'snapster'),
        'image' => $theme_dir . 'snapster_layout2.jpg',
    ]);

    $shortcode->add_dependecy('snapster_heading', 'template', ['snapster_layout2']);
    $shortcode->add_dependecy('snapster_background-color', 'template', 'snapster_layout2');

    snapster_add_dependency(['use_heading', 't_heading', 's_image', 's_description', 'use_description', 't_description'], ['snapster_layout2'], $shortcode);

    $shortcode->add_params([
        'snapster_background-color' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Background color', 'snapster'),
            'grid' => 6,
            'selectors' => ['{{WRAPPER}} .aheto-features-block__image-wrap' => 'background-color: {{VALUE}}'],
            'default' => 'rgba(17, 17, 17, 0.07)',
        ],
        'snapster_heading' => [
            'type' => 'text',
            'heading' => esc_html__('Heading', 'snapster'),
            'grid' => 9,
            'admin_label' => true,
            'default' => esc_html__('Default heading', 'snapster'),
        ],
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Snapster Images size', 'snapster' ),
        'prefix' => 'snapster_',
        'dependency' => ['template', ['snapster_layout2']]
    ]);
}