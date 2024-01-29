<?php
/**
 * Author Dashboard Page
 */

get_header();

if ( is_user_logged_in() ) {
    $whizzy_settings = get_option( 'whizzy_settings' );
    $terms = get_terms( array(
	    'fields' => 'ids',
	    'taxonomy' => 'whizzy-client',
	    'hide_empty' => false,
	    'meta_value' => get_current_user_id(),
	    'meta_key' => 'whizzy_user_id',
    ) );
    $galleries = new WP_Query( array(
        'post_type' => $whizzy_settings['whizzy_proof_gallery_new_single_item_slug'],
        'posts_per_page' => 100,
        'tax_query' => array(
            array(
                'taxonomy' => 'whizzy-client',
                'terms' => $terms,
            ),
        ),
    ) );
}
?>

	<div class="wrap">
		<header class="entry-header">
			<h2 class="entry-title">
				<?php the_title(); ?>
			</h2>
		</header>
		<div class="entry-content">
			<?php the_content(); ?>

            <?php if ( is_user_logged_in() ): ?>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="user-info-wrap">
                                <div class="user-img-wrap">
                                    <?php echo get_avatar( get_current_user_id() ); ?>
                                </div>
                                <div class="user-content">
                                    <h3 class="title">
                                        <?php the_author_meta( 'display_name', get_current_user_id() ); ?>
                                    </h3>
                                    <div class="description">
                                        <?php the_author_meta( 'description', get_current_user_id() ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ( $galleries->have_posts() ): ?>
                        <div class="whizzy-portfolio-wrapper">
                            <?php while ( $galleries->have_posts() ): $galleries->the_post(); ?>
                                <div class="portfolio-item">
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="item-img">
                                            <?php the_post_thumbnail(); ?>
                                        </div>
                                        <div class="item-overlay">
                                            <h5 class="portfolio-title">
                                                <?php the_title(); ?>
                                            </h5>
                                        </div>
                                    </a>
                                </div>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <form id="whizzy-pro--login" method="post">
                    <input type="hidden" name="page_id" value="<?php the_ID(); ?>">
                    <input type="hidden" name="action" value="whizzy-login">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'WhizzyAdvanced' ); ?>">

                    <div class="form-group">
                        <label for="login-email"><?php _e( 'Email or username', 'whizzy' ); ?></label>
                        <input type="text" name="email" class="form-control" id="login-email" placeholder="<?php _e( 'Enter your email address...', 'whizzy' ); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password"><?php _e( 'Password', 'whizzy' ); ?></label>
                        <input type="password" name="password" class="form-control" id="login-password" placeholder="<?php _e( 'Enter your password...', 'whizzy' ); ?>" required>
                    </div>
                    <div class="errors-list bg-danger hidden"></div>
                    <button type="submit" class="btn btn-default"><?php _e( 'Login', 'whizzy' ); ?></button>
                </form>
            <?php endif; ?>
        </div>
    </div>

<?php
get_footer();
