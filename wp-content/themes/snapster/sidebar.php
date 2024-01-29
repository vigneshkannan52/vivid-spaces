<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Snapster
 */

if ( ! is_active_sidebar( 'snapster-sidebar' ) ) {
	return;
}
?>

<div class="col-12 col-lg-4">
    <div class="snapster-blog--sidebar">
		<?php dynamic_sidebar( 'snapster-sidebar' ); ?>
    </div>
</div>

