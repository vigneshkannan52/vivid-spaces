<?php

	use Aheto\Helper;

	$ID = get_the_ID ();

	extract ( $atts );

	$classes = [];
	$classes[] = 'aheto-cpt-article';
	$classes[] = 'aheto-cpt-article--' . $atts['layout'];
	$classes[] = $atts['layout'] === 'grid' ? 'aheto-cpt-article--static' : '';
	$classes[] = 'aheto-cpt-article--' . $atts['skin'];
	$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

	/**
	 * Set dependent style
	 */
	$sc_dir = SNAPSTER_T_URI . '/aheto/custom-post-types/';
	wp_enqueue_style('snapster-skin-9', $sc_dir . 'assets/css/snapster_skin-9.css', null, null);
?>


<article class="aheto-cpt-article__post <?php echo esc_attr ( implode ( ' ', $classes ) ); ?>">
    <div class="aheto-cpt-article__inner">
		<?php $this -> getImage ( $img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_' ); ?>
        <div class="aheto-cpt-article__content">
	        <?php $this -> getTerms ( $atts['terms'] ); ?>

	        <?php $this->getTitle(); ?>

            <div class="aheto-cpt-article__excerpt">
				<?php the_excerpt (); ?>
            </div>

            <div class="aheto-cpt-article__link">
                <a class="aheto-link aheto-btn--main aheto-btn--no-underline" href="<?php the_permalink (); ?>">
                    <span>
                        <?php esc_html_e ( "READ MORE", 'snapster' ); ?>
                    </span>
                </a>
            </div>

        </div>
    </div>


</article>
