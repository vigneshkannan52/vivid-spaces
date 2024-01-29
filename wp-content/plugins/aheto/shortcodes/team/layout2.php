<?php
/**
 * The Team Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     FOX-THEMES <info@foxthemes.me>
 */

use Aheto\Helper;

extract( $atts );

$teams = $this->parse_group( $teams );
if ( empty( $teams ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-team' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-team--modern' );
// Item.
$this->add_render_attribute( 'item', 'class', 'aheto-member' );
$this->add_render_attribute( 'item', 'class', 'aheto-member--modern' );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'    => 1000,
	'autoplay' => false,
	'spaces'   => 30,
	'slides'   => 3,
	'arrows'   => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, '', $carousel_default_params );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/team/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'team-style-2', $sc_dir . 'assets/css/layout2.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="swiper">
        <div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr( $carousel_params ); ?>>

            <div class="swiper-wrapper">

				<?php foreach ( $teams as $index => $item ) : ?>

                    <div class="swiper-slide">

                        <div <?php $this->render_attribute_string( 'item' ); ?>>

							<?php if ( $item['member_image'] ) {
								$background_image = Helper::get_background_attachment( $item['member_image'], $image_size, $atts ); ?>
                                <div class="aheto-member__img-holder">
                                    <div class="aheto-member__img" <?php echo esc_attr( $background_image ); ?>></div>
                                </div>
							<?php } ?>

                            <div class="aheto-member__text">
								<?php
								// Name.
								if ( $item['member_name'] ) {
									echo '<h5 class="aheto-member__name">' . wp_kses_post( $item['member_name'] ) . '</h5>';
								}

								// Designation.
								if ( $item['member_designation'] ) {
									echo '<p class="aheto-member__position">' . esc_html( $item['member_designation'] ) . '</p>';
								}

								// Description.
								if ( $item['member_description'] ) {
									echo '<p class="aheto-member__desc">' . wp_kses_post( $item['member_description'] ) . '</p>';
								}

								// Field Values Decode.
								if ( $item['member_social'] ) { ?>
                                    <div class="aheto-member__contact">
										<?php
										echo Helper::get_social_networks_list( '<a class="aheto-member__link" href="%1$s"><i class="ion-social-%2$s"></i></a>', '', $item );
										?>
                                    </div>
								<?php } ?>
                            </div>

                        </div>

                    </div>

				<?php endforeach; ?>

            </div>

			<?php $this->swiper_pagination(); ?>

        </div>

		<?php $this->swiper_arrow(); ?>
    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $sc_dir . 'assets/css/layout2.css'?>" rel="stylesheet">
	<?php
endif;