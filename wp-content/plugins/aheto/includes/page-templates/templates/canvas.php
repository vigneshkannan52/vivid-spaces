<?php
/**
 * The canvas template.
 *
 * @package Aheto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Aheto\Helper;

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_dequeue_style( 'twentyseventeen-style' );
		wp_dequeue_style( 'twentyseventeen-block-style' );
		wp_dequeue_style( 'twentyseventeen-colors-dark' );
		wp_dequeue_style( 'twentyseventeen-ie9' );
		wp_dequeue_style( 'twentyseventeen-ie8' );
	},
	20
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
        <title><?php echo wp_get_document_title(); ?></title>
	<?php endif; ?>
	<?php wp_head(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php


/**
 * Before canvas page template content.
 *
 * @since 1.0.0
 */


do_action( 'aheto_preloader' );

do_action( 'aheto_header' );

echo '<div class="container">';
while ( have_posts() ) :
	the_post();
	remove_filter( 'the_content', 'wpautop' );
	the_content();
	add_filter( 'the_content', 'wpautop' );
endwhile;
echo '</div>';

/**
 * Footer.
 */
do_action( 'aheto_footer' );

wp_footer();
?>
</body>
</html>
