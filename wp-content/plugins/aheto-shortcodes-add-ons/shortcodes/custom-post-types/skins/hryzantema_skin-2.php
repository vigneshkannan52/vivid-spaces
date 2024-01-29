<?php

use Aheto\Helper;

$ID = get_the_ID();


$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);

if(isset($terms_list) && !empty($terms_list)){
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/custom-post-types/';
wp_enqueue_style('hryzantema-custom-post-types-skin-2', $shortcode_dir . 'assets/css/hryzantema_skin-2.css', null, null);
wp_enqueue_script( 'hryzantema-custom-post-types-skin2-js', $shortcode_dir . 'assets/js/hryzantema_skin-2.js', array( 'jquery' ), null );

?>


<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<div class="aheto-cpt-article__inner">
        <?php $post_image =  has_post_thumbnail() ?  Helper::get_background_attachment( get_post_thumbnail_id() ) : '';?>
		<div class="aheto-cpt-article__img" <?php echo esc_attr($post_image); ?>></div>

		<a href="<?php the_permalink(); ?>" class="aheto-cpt-article__link"></a>

		<div class="aheto-cpt-article__content">

            <?php if ( !empty($terms_list[0]->name) ) : ?>

                <p class="aheto-cpt-article__term"><?php echo esc_html($terms_list[0]->name); ?></p>
            <?php endif; ?>

			<?php $this->getTitle(); ?>
		</div>
	</div>
</article>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/hryzantema_skin-2.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
	"use strict";

		$(window).on('load', function () {
			const $isotope = $('.aheto-cpt--hr-metro ');

			/* ISOTOPE INIT */

			if ($isotope.length) {
				$isotope.each(function () {
					$(this).isotope({
						itemSelector: '.aheto-cpt-article--hryzantema_skin-2',
						percentPosition: true,
						layoutMode: 'masonry',
						masonry: {
							columnWidth: '.aheto-cpt--hr-metro-sizer',
						}
					})
				});
			}
		});

})(jQuery, window, document);
	</script>
	<?php
endif;