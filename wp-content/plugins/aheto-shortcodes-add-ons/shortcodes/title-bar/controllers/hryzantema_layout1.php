<?php

use Aheto\Helper;

add_action('aheto_before_aheto_title-bar_register', 'hryzantema_title_bar_layout1');

/**
 * Title Bar Shortcode
 */

function hryzantema_title_bar_layout1($shortcode) {
	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/title-bar/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'HR Consult Seacrh Bar', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );

	aheto_addon_add_dependency(['source', 'title_tag', 'title', 'use_title_typo','title_typo', 'searchform'], ['hryzantema_layout1'], $shortcode);
}

