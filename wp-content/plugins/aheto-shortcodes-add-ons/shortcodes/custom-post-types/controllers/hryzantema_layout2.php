<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'hryzantema_custom_post_types_layout2');

/**
 * Custom post type Shortcode
 */

function hryzantema_custom_post_types_layout2($shortcode) {
	$preview_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/custom-post-types/previews/';

	$shortcode->add_layout( 'hryzantema_layout2', [
		'title' => esc_html__( 'HR Consult Metro', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout2.jpg',
	] );

	aheto_addon_add_dependency(['skin','use_heading','t_heading','image_height'], ['hryzantema_layout2' ], $shortcode);

}
function hryzantema_cpt_image_sizer_layout2( $image_sizer_layouts ) {

	$image_sizer_layouts[] = 'hryzantema_layout2';

	return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'hryzantema_cpt_image_sizer_layout2', 10, 2 );
