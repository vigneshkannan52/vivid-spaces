<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'rela_list_layout1');

/**
 * List Shortcode
 */
function rela_list_layout1($shortcode)
{

    $shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/list/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Rela list', 'rela'),
        'image' => $shortcode_dir . 'rela_layout1.jpg',
    ]);

    aheto_addon_add_dependency(['lists', 'heading', 'text_tag', 'color'], ['rela_layout1'], $shortcode);
}
