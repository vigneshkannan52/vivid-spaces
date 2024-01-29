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
$atts['layout'] = 'slider';

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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--karma-education-slider' );
$this->add_render_attribute( 'wrapper', 'class', $skin ? 'js-popup-gallery' : '' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'     => 500,
	'slides'    => 3,
	'slides_md' => 2,
	'slides_xs' => 1,
	'spaces'    => 30
]; // will use when not chosen option 'Change slider params'



$carousel_params = Helper::get_carousel_params( $atts, 'karma_education_swiper_', $carousel_default_params );


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/custom-post-types/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('karma_education-custom-post-types--layout1', $shortcode_dir . 'assets/css/karma_education_layout1.css', null, null);
}



?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">

        <div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr( $carousel_params ); ?>>

            <div class="swiper-wrapper">

				<?php
				$this->add_excerpt_filter();

				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					?>
                    <div class="swiper-slide">
						<?php $this->get_skin_part( $skin, $atts ); ?>
                    </div>
				<?php
				endwhile;

				$this->remove_excerpt_filter();

				wp_reset_query();
				?>

            </div>

			<?php $this->swiper_pagination( 'karma_education_swiper_' ); ?>

        </div>

		<?php $this->swiper_arrow( 'karma_education_swiper_' ); ?>

    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/karma_education_layout1.css'?>" rel="stylesheet">
	<?php
endif;