<?php

use Aheto\Helper;

$ID = get_the_ID();

extract( $atts );

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms( get_the_ID(), $atts['terms'] );

if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

$tag = isset( $atts['title_tag'] ) && ! empty( $atts['title_tag'] ) ? $atts['title_tag'] : 'h4';

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/custom-post-types/';
wp_enqueue_style( 'mooseoom-skin-6', $shortcode_dir . 'assets/css/mooseoom_skin-6.css', null, null );
?>

<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<div class="aheto-cpt-article__inner">
		<?php $isHasThumb = $this->getImage( $img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_'); ?>

		<div class="aheto-cpt-article__content">
			<?php
			the_tags(
				'<div class="aheto-cpt-article__tags">',
				',',
				'</div>');
			?>
			<?php
			echo '<' . $tag . ' class="aheto-cpt-article__title">'; ?>
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
			<?php echo '</' . $tag . '>';

			?>
		</div>
	</div>

</article>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/mooseoom_skin-6.css'?>" rel="stylesheet">
	<?php
endif;