<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version     1.6.4
 */


use Aheto\Helper;

if ( !defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

get_header('shop'); ?>

<?php
/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action('woocommerce_before_main_content'); ?>

	<div class="woocommerce-product-single__banner-wrap">
		<div class="woocommerce-product-single__banner">
			<h1 class="woocommerce-product-single__title"><?php echo esc_html(get_the_title()); ?></h1>
			<nav class="woocommerce-product-single__breadcrumb">
				<a href="<?php echo esc_url(get_home_url()); ?>"><?php esc_html_e('Home', 'snapster'); ?></a>
				<a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>"><?php esc_html_e('Shop', 'snapster'); ?></a>
				<span><?php echo esc_html(get_the_title()); ?></span>
			</nav>
		</div>
	</div>
<?php while ( have_posts() ) : the_post(); ?>

	<?php wc_get_template_part('content', 'single-product'); ?>

<?php endwhile; // end of the loop. ?>

<?php
/**
 * woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');
?>

<?php
/**
 * woocommerce_sidebar hook.
 *
 * @hooked woocommerce_get_sidebar - 10
 */

?>
<?php
if(function_exists( 'aheto' ) == true) {

	$snapster_shop_subtitle   = Aheto\Helper::get_settings('theme-options.snapster_shop_subtitle');
	$snapster_shop_title      = Aheto\Helper::get_settings('theme-options.snapster_shop_title');
	$snapster_shop_img_left   = Aheto\Helper::get_settings('theme-options.snapster_shop_img_left');
	$snapster_shop_img_right  = Aheto\Helper::get_settings('theme-options.snapster_shop_img_right');
	$snapster_shop_link_title = Aheto\Helper::get_settings('theme-options.snapster_shop_link_title');
	$snapster_shop_link_url   = Aheto\Helper::get_settings('theme-options.snapster_shop_link_url');
}
if ((function_exists( 'aheto' ) == true &&  !empty($snapster_shop_title)) || (function_exists( 'aheto' ) == true && !empty($snapster_shop_subtitle) )) {

	?>
	<div class="woocommerce-product-single__banner-bottom">

		<?php
		// Heading.
		if ( !empty($snapster_shop_subtitle) ) {
			$image_left  = '';
			$image_right = '';
			if ( !empty($snapster_shop_img_left) ) {
				$image_left = '<img src="'.$snapster_shop_img_left.'" class="woocommerce-product-single__image" alt="subtitle_image"/>';
			}
			if ( !empty($snapster_shop_img_right) ) {
				$image_right = '<img src="'.$snapster_shop_img_right.'" class="woocommerce-product-single__image" alt="subtitle_image"/>';
			}
			echo '<h6 class="woocommerce-product-single__subtitle">' . $image_left . wp_kses($snapster_shop_subtitle, 'post') . $image_right . '</h6>';
		}
		if ( !empty($snapster_shop_link_url) &&  !empty($snapster_shop_link_title)  ) {
			echo '<a href="'.esc_url($snapster_shop_link_url).'" 
					 class="woocommerce-product-single__link aheto-btn aheto-btn--primary   ">'
				      . esc_html($snapster_shop_link_title) . '</a>';
		} ?>
	</div>
<?php } ?>
<?php get_footer('shop');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
