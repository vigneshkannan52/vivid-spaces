<?php

use Aheto\Helper;

$ID = get_the_ID();


$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $atts['layout'] === 'grid' ? 'aheto-cpt-article--static' : '';
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
wp_enqueue_style('acacio-skin-3', $shortcode_dir . 'assets/css/acacio_skin-3.css', null, null);
?>


<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="aheto-cpt-article__inner">
        <?php if ( has_post_thumbnail() ) :
            $post_image = Helper::get_background_attachment( get_post_thumbnail_id() );
        endif;

        ?>
        <div class="aheto-cpt-article__img" <?php echo esc_attr($post_image); ?>>

            <div class="aheto-cpt-article__content">
                <?php $this->getTitle(); ?>
            </div>
        </div>
    </div>
</article>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/acacio_skin-3.css'?>" rel="stylesheet">
	<?php
endif;