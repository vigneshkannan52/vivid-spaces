<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'vestry_navigation_layout3');

/**
 * Navigation
 */
function vestry_navigation_layout3($shortcode)
{

  $preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/navigation/previews/';

  $shortcode->add_layout('vestry_layout3', [
    'title' => esc_html__('Vestry Footer', 'vestry'),
    'image' => $preview_dir . 'vestry_layout3.jpg',
  ]);

  $shortcode->add_dependecy('vestry_use_links_typo', 'template', 'vestry_layout3');
  $shortcode->add_dependecy('vestry_links_typo', 'template', 'vestry_layout3');
  $shortcode->add_dependecy('vestry_links_typo', 'vestry_use_links_typo', 'true');
}
