<?php

/**
 * Ewo Skin 1.
 */

$ID = get_the_ID();
$ewo_dark_mod = isset($atts['ewo_dark_mod']) && $atts['ewo_dark_mod'] ? 'bb' : '';

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = 'aheto-cpt-article--' . $ewo_dark_mod;
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';


$terms_list = get_the_terms ( get_the_ID (), $atts['terms'] );
if ( !empty( $terms_list )) {
    foreach ($terms_list as $term) {
        $classes[] = 'filter-' . $term -> slug;
    }
}


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/custom-post-types/';
wp_enqueue_style('ewo-skin-1', $shortcode_dir . 'assets/css/ewo_skin-1.css', null, null);

$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
  <div class="aheto-cpt-article__inner">
    <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_'); ?>
    <div class="aheto-cpt-article__content">
      <?php
      $this->getTitle();
      ?>
      <div class="aheto-cpt-article__date">
        <?php the_time(get_option('date_format')); ?>
        <span>in</span>
        <?php $this->getTerms($atts['terms']) ?>
      </div>
    </div>
  </div>
</article>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/ewo_skin-1.css'?>" rel="stylesheet">
	<?php
endif;