<?php
/**
 * About default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$atts['layout'] = 'masonry';

// Query.
$the_query = $this->get_wp_query();

if ( ! $the_query->have_posts() ) {
	return;
}

$skin = isset( $skin ) && ! empty( $skin ) ? $skin : 'skin-1';

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt__snapster-horizontal-simple' );
$this->add_render_attribute( 'wrapper', 'class', $skin ? 'js-popup-gallery' : '' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'    => 1500,
	'autoplay' => 0,
	'spaces'   => 0,
	'loop'     => 0,
];

$carousel_params = Helper::get_carousel_params( $atts, 'snapster_t_swiper_', $carousel_default_params );


/**
 * Set dependent style
 */
$shortcode_dir = SNAPSTER_T_URI . '/aheto/custom-post-types/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'snapster-custom-post-types-layout3', $shortcode_dir . 'assets/css/snapster_layout3.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">

        <div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr( $carousel_params ); ?>
             data-slides="auto" data-mousewheel="1">

            <div class="swiper-wrapper">

				<?php
				$this->add_excerpt_filter();

				while ( $the_query->have_posts() ) :
					$the_query->the_post(); ?>


                    <div class="swiper-slide">

							<?php $this->get_skin_part( $skin, $atts ); ?>

                    </div>

				<?php endwhile;

				$this->remove_excerpt_filter();

				wp_reset_query(); ?>

            </div>

        </div>

    </div>

</div>