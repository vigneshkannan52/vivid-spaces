<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_media_register', 'noize_media_layout1' );

/**
 * Simple media
 */
function noize_media_layout1($shortcode) {
    $preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/media/previews/'; 

    $shortcode->add_layout( 'noize_layout1', [
        'title' => esc_html__( 'Noize Media Single', 'noize' ),
        'image' => $preview_dir . 'noize_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'noize_image', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_align', 'template', 'noize_layout1' );

    $shortcode->add_params([
        'noize_image'     => [
            'type'    => 'attach_images',
            'heading' => esc_html__('Add image', 'noize' ),
        ],
        'noize_align' => [
            'type'    => 'select',
            'heading' => esc_html__('Align button', 'noize'),
            'options' => \Aheto\Helper::choices_alignment(),
        ],
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'noize_',
        'dependency' => ['template', ['noize_layout1']]
    ] );

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'noize_load_',
        'dependency' => ['template', ['noize_layout1']]
    ] );
}