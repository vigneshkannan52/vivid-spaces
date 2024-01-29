<?php

use Aheto\Helper;

add_action('aheto_before_aheto_video-btn_register', 'rela_video_btn_layout1');

/**
 * Video Button
 */
function rela_video_btn_layout1($shortcode)
{

    $shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/video-btn/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Rela Style', 'rela'),
        'image' => $shortcode_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_text', 'template', 'rela_layout1');

    $shortcode->add_dependecy('rela_use_text_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_text_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_text_typo', 'rela_use_text_typo', 'true');

    $shortcode->add_params([
        'rela_text' => [
            'type' => 'text',
            'heading' => esc_html__('Text for video button', 'rela'),
        ],
        'rela_use_text_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for text?', 'rela'),
            'grid' => 3,
        ],
        'rela_text_typo' => [
            'type' => 'typography',
            'group' => 'Text Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-btn-video__text',
        ],
    ]);
}

function rela_video_btn_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_text_typo']) && !empty($shortcode->atts['rela_text_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-btn-video__text'], $shortcode->parse_typography($shortcode->atts['rela_text_typo']));
    }

    return $css;
}

add_filter('aheto_video_btn_dynamic_css', 'rela_video_btn_layout1_dynamic_css', 10, 2);

