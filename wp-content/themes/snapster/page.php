<?php
/**
 * Custom Page Template
 */

get_header();

$protected = '';

if ( post_password_required() ) {
	$protected = 'protected-page';
}

while ( have_posts() ) : the_post();

	wp_enqueue_style( 'snapster-blog-single', SNAPSTER_T_URI . '/assets/css/blog/blog-single.css' ); ?>

    <div class="snapster-blog--single-wrapper <?php echo esc_attr( $protected ); ?>">
        <div class="snapster-blog--single__top-content">

            <div class="container">
                <div class="row">
                    <div class="col-12">

						<?php the_title( '<h1 class="snapster-blog--single__title text-center">', '</h1>' ); ?>

                    </div>
                </div>
            </div>

        </div>
        <div class="container snapster-blog--single__post-content">
            <div class="row">
                <div class="col-12">

                    <div class="snapster-blog--single__content-wrapper page">

						<?php the_content();
						wp_link_pages( 'link_before=<span class="snapster-blog--single__pages">&link_after=</span>&before=<div class="snapster-blog--single__post-nav"> <span>' . esc_html__( "Page:", 'snapster' ) . ' </span> &after=</div>' ); ?>

                    </div>

					<?php if ( comments_open() || '0' != get_comments_number() && wp_count_comments( $get_id ) ) { ?>
                        <div class="snapster-blog--single__comments page">
							<?php comments_template( '', true ); ?>
                        </div>
					<?php } ?>

                </div>
            </div>
        </div>
    </div>


<?php
endwhile;

get_footer();
