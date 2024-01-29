<?php
/*
 * Single post
 */


$protected = '';

if ( post_password_required() ) {
	$protected = 'protected-page';
}

$get_id    = get_the_ID();
$author_id = get_the_author_meta( 'ID' );

$content_size_class = is_active_sidebar( 'snapster-sidebar' ) ? 'col-12 col-lg-8' : 'col-12'; ?>

<div class="snapster-blog--single-wrapper <?php echo esc_attr( $protected ); ?>">
    <div class="snapster-blog--single__top-content">

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="snapster-blog--single__columns">
                        <div class="snapster-blog--single__top-content-left">

                            <div class="snapster-blog--single__categories">
								<?php the_category( ' ' ); ?>
                            </div>

							<?php the_title( '<h1 class="snapster-blog--single__title">', '</h1>' ); ?>

                            <div class="snapster-blog--single__date"><?php the_time( get_option( 'date_format' ) ); ?></div>

                        </div>

                        <div class="snapster-blog--single__top-content-right">

                            <div class="snapster-blog--single__author">

								<?php echo get_avatar( $author_id, 50 );
								echo esc_html( get_the_author() ); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="container snapster-blog--single__post-content">
        <div class="row">
            <div class="col-12 <?php echo esc_attr( $content_size_class ); ?>">

                <div class="snapster-blog--single__content-wrapper">

					<?php the_content();
					wp_link_pages( 'link_before=<span class="snapster-blog--single__pages">&link_after=</span>&before=<div class="snapster-blog--single__post-nav"> <span>' . esc_html__( "Page:", 'snapster' ) . ' </span> &after=</div>' ); ?>

					<?php the_tags(
						'<div class="snapster-blog--single__tags">
                        <i class="ion-ios-pricetags-outline"></i>',
						' / ',
						'</div>' ); ?>

                </div>

				<?php if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) { ?>
                    <div class="snapster-blog--single__comments">
						<?php comments_template( '', true ); ?>
                    </div>
				<?php } ?>

                <div class="snapster-blog--single__pagination">
                    <div class="snapster-blog--single__pagination-prev">
						<?php $prev_post     = get_previous_post();
                            if ( ! empty( $prev_post ) ) :
                                $prev_thumbnail = get_the_post_thumbnail_url( $prev_post->ID, 'thumbnail' );
                                $prev_post_title = ! empty( get_the_title( $prev_post ) ) ? get_the_title( $prev_post ) : esc_html__( 'No title', 'snapster' );
                                $prev_link       = get_permalink( $prev_post ); ?>


                                <?php if ( ! empty( $prev_thumbnail ) ) { ?>
                                <a href="<?php echo esc_url( $prev_link ); ?>" class="img-wrap">
                                    <img src="<?php echo esc_url( $prev_thumbnail ); ?>"
                                         alt="<?php echo esc_attr( $prev_post_title ); ?>">
                                </a>
                            <?php } ?>
                            <span>
                                <a href="<?php echo esc_url( $prev_link ); ?>" class="content">
                                        <?php echo wp_kses( $prev_post_title, 'post' ); ?>
                                </a>
								<?php esc_html_e( 'Prev post', 'snapster' ); ?>
                            </span>

						<?php endif; ?>
                    </div>

					<?php $next_post = get_next_post(); ?>
                    <div class="snapster-blog--single__pagination-next">
						<?php if ( ! empty( $next_post ) ) :
							$next_thumbnail = get_the_post_thumbnail_url( $next_post->ID, 'thumbnail' );
							$next_post_title = ! empty( get_the_title( $next_post ) ) ? get_the_title( $next_post ) : esc_html__( 'No title', 'snapster' );
							$next_link = get_permalink( $next_post ); ?>


                            <span>
                                <a href="<?php echo esc_url( $next_link ); ?>" class="content">
                                    <?php echo wp_kses( $next_post_title, 'post' ); ?>
                                </a>
								<?php esc_html_e( 'Next post', 'snapster' ); ?>
                            </span>
							<?php if ( ! empty( $next_thumbnail ) ) { ?>
                            <a href="<?php echo esc_url( $next_link ); ?>" class="img-wrap">
                                <img src="<?php echo esc_url( $next_thumbnail ); ?>"
                                     alt="<?php echo esc_attr( $next_post_title ); ?>">
                            </a>
						<?php } ?>

						<?php endif; ?>
                    </div>
                </div>

            </div>
			<?php if ( is_active_sidebar( 'snapster-sidebar' ) ) {

				wp_enqueue_style( 'snapster-sidebar', SNAPSTER_T_URI . '/assets/css/blog/sidebar.css' );

				get_sidebar( 'snapster-sidebar' );

			} ?>
        </div>
    </div>
</div>