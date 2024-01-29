<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'soapy_contents_layout1');


/**
 * Contents
 */

function soapy_contents_layout1($shortcode) {
	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/contents/previews/';
	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Soapy Accordion', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	aheto_addon_add_dependency(['faqs', 'first_is_opened', 'multi_active', 'title_typo', 'text_typo'], ['soapy_layout1'], $shortcode);

}
