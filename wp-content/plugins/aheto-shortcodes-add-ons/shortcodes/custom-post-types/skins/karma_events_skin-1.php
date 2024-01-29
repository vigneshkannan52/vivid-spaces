<?php

use Aheto\Helper;

$ID = get_the_ID();

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);

if ( isset($terms_list) && !empty($terms_list) ) {
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

$tag = isset($atts['title_tag']) && !empty($atts['title_tag']) ? $atts['title_tag'] : 'h5';

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/custom-post-types/';

wp_enqueue_style('karma-events-skin-2', $shortcode_dir . 'assets/css/karma_events_skin-1.css', null, null);

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<div class="aheto-cpt-article__inner">
		<?php $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_'); ?>
		<div class="aheto-cpt-article__content">
			<?php $this->getDate(); ?>
			<?php echo '<' . $tag . ' class="aheto-cpt-article__title">'; ?>
			<a href="<?php the_permalink(); ?>">
				<?php $title = get_the_title();
				echo $title; ?>
			</a>
			<?php echo '</' . $tag . '>'; ?>
		</div>
		<div class="aheto-cpt-article__footer">

			<div class="aheto-cpt-article__author aheto-cpt-article__footer-item">
				<i class="icon ion-android-person"></i>
				<span><?php the_author(); ?></span>
			</div>

			<?php $likes = get_post_meta(get_the_ID(), 'aheto_post_likes', true); ?>
			<div class="aheto-cpt-article__likes aheto-cpt-article__footer-item">
				<i class="icon ion-heart"></i>
				<span><?php echo $likes ? $likes : 0; ?><?php esc_html_e('Likes', 'aheto'); ?></span>
			</div>
			<div class="aheto-cpt-article__comments aheto-cpt-article__footer-item">
				<i class="icon ion-eye"></i>
				<span><?php esc_html_e('Views', 'aheto'); ?></span>
			</div>

		</div>
	</div>
</article>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/karma_events_skin-1.css'?>" rel="stylesheet">
	<?php
endif;