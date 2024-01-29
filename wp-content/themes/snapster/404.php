<?php
/**
 * 404 Page
 */

get_header(); ?>

    <div class="snapster-error--wrap">

        <div class="snapster-error--big-title"><?php esc_html_e( 'OOPS!', 'snapster' ); ?></div>

        <div class="snapster-error--small-title"><?php esc_html_e( '404', 'snapster' ); ?></div>

        <h1 class="snapster-error--title"><?php esc_html_e( 'Page not found', 'snapster' ); ?></h1>

        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="snapster-error--button"><?php esc_html_e( 'Go home', 'snapster' ); ?></a>

    </div>


<?php get_footer();
