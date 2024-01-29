<?php
/**
 * Category Template
 */
$count = isset( $posts->found_posts ) && ! empty( $posts->found_posts ) ? $posts->found_posts : '0';
$count_text = $count == '1' ? esc_html__( 'result found', 'snapster' ) : esc_html__( 'results found', 'snapster' );

$snapster_img = '';
$snapster_background_image = '';

if (function_exists('aheto')) {
    $snapster_shop_image = Aheto\Helper::get_settings('theme-options.snapster_blog_image');
    $snapster_background_image = isset($snapster_shop_image) && !empty($snapster_shop_image) ? "style=background-image:url(" . $snapster_shop_image . ")" : '';
    $snapster_img = isset($snapster_shop_image) && !empty($snapster_shop_image) ? 'with-image' : '';
}

get_header(); ?>
    <div class="snapster-blog--banner <?php echo esc_attr($snapster_img); ?>" <?php echo esc_attr($snapster_background_image); ?>>
		<?php if ( is_search() ) { ?>
            <div class="snapster-blog--banner__title-wrap">
                <h1 class="snapster-blog--banner__title"><?php esc_html_e( 'Showing results for ', 'snapster' ); ?>
                    <span>"<?php echo esc_html( $term ); ?>"</span></h1>
                <div class="snapster-blog--banner__count-results"><?php echo esc_html( $count . ' ' . $count_text ); ?></div>
            </div>
		<?php } else { ?>
            <div class="snapster-blog--banner__title-wrap">
                <h1 class="snapster-blog--banner__title"><?php esc_html_e( 'Blog', 'snapster' ); ?></h1>
            </div>
		<?php } ?>
    </div>

<?php

if ( have_posts() ) :
	get_template_part( 'template-parts/blog', 'list-category' );
	wp_enqueue_style( 'snapster-blog-list', SNAPSTER_T_URI . '/assets/css/blog/blog-list.css' );

else : ?>
    <div class="snapster-blog--search-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="snapster-blog--search-page__title"><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'snapster' ); ?></h3>
                    <div class="snapster-blog--search-page__search-form">
						<?php get_search_form( true ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;

get_footer();