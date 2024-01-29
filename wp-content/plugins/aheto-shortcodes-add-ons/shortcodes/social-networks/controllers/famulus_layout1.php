<?php

use Aheto\Helper;

add_action('aheto_before_aheto_social-networks_register', 'famulus_social_networks_layout1');

/**
 * Social Networks
 */

function famulus_social_networks_layout1($shortcode) {

	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/social-networks/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Famulus Modern', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);

	aheto_addon_add_dependency(['networks', 'socials_align_mob', 'socials_align'], ['famulus_layout1'], $shortcode);

	$shortcode->add_dependecy('famulus_light_version', 'template', 'famulus_layout1');

	$shortcode->add_params([
		'famulus_light_version' => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable dark version?', 'famulus'),
			'grid'    => 3,
		]
	]);
}