<?php

/**
 * Aheto dependency
 */

function aheto_addon_add_dependency ( $id='', $args = array(), $shortcode=''){

    if ( is_array( $id ) ) {

        foreach ( $id as $slug ) {
        	if(isset($shortcode->depedency[$slug]['template'])){
		        $param = (array)$shortcode->depedency[$slug]['template'];
		        $shortcode->depedency[$slug]['template'] = array_merge($args, $param );
	        }
        }

    } else {
        $param = (array)$shortcode->depedency[$id]['template'];
        $shortcode->depedency[$id]['template'] = array_merge($args, $param );
    }

    return;
}


//
//
//add_filter( 'aheto_import_page_content', function ( $content ) {
//
//
//	$data = get_data('/aheto/v1/getTemplates', false, false);
//
//	$content = str_replace( array('"cs_','demo-uploads'), array('"outsourceo_','uploads'), $content );
////	$content = str_replace('"cs_', '"outsourceo_', $content);
//
//	return $content;
//
//}, 10 );
//
//
//
//

add_filter('aheto_layout_sets', function () {

    $AhetoAddon_layouts = array(
        'moovit' => esc_html__('Moovit', 'aheto'),
//		'outsourceo' => esc_html__( 'Outsourceo', 'aheto' ),
    );

    return $AhetoAddon_layouts;

}, 10);

