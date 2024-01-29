<?php

/**
 * Get Whizzy Categories for select in VC
 *
 * @return array
 */
function whizzy_get_categories_for_vc() {
	$categories = array();
	$terms = get_terms( array( 'hide_empty' => false, 'taxonomy' => 'whizzy-category' ) );

	if ( ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$categories[ $term->name ] = $term->slug;
		}
	}

	return $categories;
}

/**
 * Get Whizzy Galleries for select in VC
 *
 * @return array
 */
function whizzy_get_galleries_for_vc() {
	$galleries = array();
	$query = new WP_Query( array(
		'post_type' => 'whizzy_proof_gallery',
		'post_per_page' => 1000,
	) );

	if ( ! empty( $query->posts ) ) {
		foreach ( $query->posts as $post ) {
			$galleries[ $post->post_title ] = $post->ID;
		}
	}

	return $galleries;
}

if ( function_exists( 'vc_add_shortcode_param' ) && ! function_exists( 'vc_efa_chosen' ) ) {
	/**
	 * @param array $settings
	 * @param string $value
	 * @return string
	 */
	function vc_efa_chosen( $settings, $value ) {
		$css_option = vc_get_dropdown_option( $settings, $value );
		$value = explode( ',', $value );

		$output  = '<select name="'. $settings['param_name'] .'" data-placeholder="'. $settings['placeholder'] .'" multiple="multiple" class="wpb_vc_param_value wpb_chosen chosen wpb-input wpb-efa-select '. $settings['param_name'] .' '. $settings['type'] .' '. $css_option .'" data-option="'. $css_option .'">';

		foreach ( $settings['value'] as $values => $option ) {
			$selected = ( in_array( $option, $value ) ) ? ' selected="selected"' : '';
			$output .= '<option value="'. $option .'" '. $selected . '>'. htmlspecialchars( $values ) .'</option>';
		}

		$output .= '</select>' . "\n";

		return $output;
	}

	vc_add_shortcode_param('vc_efa_chosen', 'vc_efa_chosen' );
}
