<?php

use Aheto\Helper;

add_action('aheto_before_aheto_clients_register', 'ewo_clients_layout1');

/**
 *  Banner Slider
 */

function ewo_clients_layout1($shortcode)
{

  $preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/clients/previews/';

  $shortcode->add_layout('ewo_layout1', [
    'title' => esc_html__('Ewo Clients', 'ewo'),
    'image' => $preview_dir . 'ewo_layout1.jpg',
  ]);

  aheto_addon_add_dependency( ['hover_style', 'clients', 'item_per_row'], [ 'ewo_layout1' ], $shortcode );
}