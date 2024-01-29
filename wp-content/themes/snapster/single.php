<?php
/**
 * Single post
 */

get_header();

while ( have_posts() ) :
	the_post();

	$post_id = get_the_ID();

    if ( get_post_type( $post_id ) == 'whizzy_proof_gallery' ) {
        get_template_part( 'template-parts/post', 'whizzy' );
    }else{
        get_template_part( 'template-parts/blog', 'single' );
    }

	wp_enqueue_style('snapster-blog-single', SNAPSTER_T_URI . '/assets/css/blog/blog-single.css');

endwhile;

wp_reset_postdata();

get_footer();


