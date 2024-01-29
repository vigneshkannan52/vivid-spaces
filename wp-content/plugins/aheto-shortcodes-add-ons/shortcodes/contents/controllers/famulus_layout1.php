<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'famulus_contents_layout1');


/**
 * Contents
 */

function famulus_contents_layout1($shortcode) {
	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contents/previews/';
	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Famulus Accordion', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);

	aheto_addon_add_dependency(['faqs', 'first_is_opened', 'multi_active', 'title_typo', 'text_typo'], ['famulus_layout1'], $shortcode);

}
