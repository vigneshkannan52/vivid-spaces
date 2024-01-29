<?php

use Aheto\Helper;

extract( $atts );

$ID = get_the_ID();
$use_shadow = $acacio_use_shadow ? 'box-shadow': '';
$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = $use_shadow;
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
foreach ( $terms_list as $term ) {
    $classes[] = 'filter-' . $term->slug;
}

$format = $this->get_post_format();
$format = isset($format) && !empty($format) ? $format : 'image';

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/custom-post-types/';
wp_enqueue_style('acacio-skin-8', $shortcode_dir . 'assets/css/acacio_skin-8.css', null, null);
wp_enqueue_script( 'acacio-skin-8-js', $shortcode_dir . 'assets/js/acacio_skin-8.js', array( 'jquery' ), null );
?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

    <div class="aheto-cpt-article__inner">

        <?php

        switch ( $format ) {
            case 'quote':
                $this->getTerms($atts['terms'], '-hover-light');
                $this->getQuote('aheto-quote aheto-quote--icon-right');

                break;

            case 'slider':
                $this->getSlider('', true, false, $atts['cpt_image_size'], true, false, $atts, 'cpt_');
                $this->getTerms($atts['terms']); ?>

                <div class="aheto-cpt-article__content">
                    <?php $this->getDate(); ?>
                    <?php $this->getTitle(); ?>
                    <?php $this->getExcerpt(); ?>
                    <?php $this->getLink('aheto-link aheto-btn--large aheto-btn--dark'); ?>
                </div>
                <?php
                break;

            case 'gallery':
                $this->getGallery('', $atts['cpt_image_size'], true, false, $atts, 'cpt_'); ?>

                <div class="aheto-cpt-article__content">
                    <?php

                    $this->getTerms($atts['terms'], 'aheto-cpt-article__terms--static');
                    $this->getDate();
                    $this->getTitle();
                    $this->getExcerpt();
                    $this->getLink('aheto-link aheto-btn--large aheto-btn--dark');
                    ?>
                </div>
                <?php

                break;

            case 'video':
                $video_btn_params = [
                    'video_style' => 'aheto-btn--light',
                    'video_size'  => 'aheto-btn-video--small',
                ];

                $this->getVideo('aheto-cpt-article__img', $video_btn_params, $img_class, $atts['cpt_image_size'], true, false, $atts, 'cpt_');
                $this->getTerms($atts['terms']); ?>

                <div class="aheto-cpt-article__content">
                    <?php $this->getDate(); ?>
                    <?php $this->getTitle(); ?>
                    <?php $this->getExcerpt(); ?>
                    <?php $this->getLink('aheto-link aheto-btn--large aheto-btn--dark'); ?>
                </div>
                <?php

                break;

            case 'audio': ?>

                <div class="aheto-cpt-article__content">
                    <?php

                    $this->getTerms($atts['terms'], 'aheto-cpt-article__terms--static');
                    $this->getAudio();
                    $this->getDate();
                    $this->getTitle();
                    $this->getExcerpt();
                    $this->getLink('aheto-link aheto-btn--large aheto-btn--dark');

                    ?>
                </div>
                <?php
                break;

            case 'image':
            default:
            $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_'); ?>

                <div class="aheto-cpt-article__content">
                    <?php
                    $terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';
                    $this->getTerms($atts['terms'], $terms_class);
                    $this->getDate();
                    $this->getTitle();
                    $this->getExcerpt();
                    $this->getLink('aheto-link aheto-btn--large aheto-btn--dark'); ?>
                </div>

                <?php break;

        } ?>

    </div>

</article>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/acacio_skin-8.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    'use strict';

    $(window).on('load', function () {
        const titles = $('.aheto-cpt__list .aheto-cpt-article--acacio_skin-8 .aheto-cpt-article__title > a');

        $(titles).each(function(index, element) {
            let heading = $(element), word_array, last_word, first_part;

            word_array = heading.html().split(/\s+/); // split on spaces
            last_word = word_array.pop();             // pop the last word
            first_part = word_array.join(' ');        // rejoin the first words together

            heading.html([first_part, ' <span>', last_word, '</span>'].join(''));
        });
    });

})(jQuery, window, document);
	</script>
	<?php
endif;