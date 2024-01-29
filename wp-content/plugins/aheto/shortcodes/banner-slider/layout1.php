<?php
/**
 * The Banner Slider Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     FOX-THEMES <info@foxthemes.me>
 */

use Aheto\Helper;

extract( $atts );

$banners = $this->parse_group( $banners );

if ( empty( $banners ) ) {
	return '';
}

if ( ! $custom_options ) {
	$speed  = 1000;
	$effect = 'fade';
	$loop   = false;
}

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-banner-wrap' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-banner-wrap--style-1' );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'effect'   => 'slide',
	'loop'     => 0,
	'autoplay' => 0,
	'arrows'   => true,
	'lazy'     => 0,
	'speed'    => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, '', $carousel_default_params );
$custom_css      = Helper::get_settings( 'general.custom_css_including' );
$custom_css      = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

$sc_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';


if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'banner-slider-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}


wp_enqueue_script( 'banner-slider-style-1-js', $sc_dir . 'assets/js/layout1.min.js', array( 'jquery' ), null );

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="swiper">
        <div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr( $carousel_params ); ?>>
            <div class="swiper-wrapper">

				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args( $banner, [
						'image'         => '',
						'video_class'   => 'aheto-banner__video-btn',
						'title'         => '',
						'desc'          => '',
						'align'         => '',
						'btn_direction' => ''
					] );
					extract( $banner );

					$lazy_class       = $lazy ? ' swiper-lazy' : '';
					$background_image = Helper::get_background_attachment( $image, $image_size, $atts, '', $lazy ); ?>

                    <div class="swiper-slide">
                        <div class="aheto-banner aheto-banner--style-1 full-min-height-js <?php echo esc_attr( $align . $lazy_class ); ?>" <?php echo esc_attr( $background_image ); ?>>

                            <div class="aheto-banner__content">
								<?php 
								global $add_video_button;
								if ( $add_video_button ) { ?>
									<?php echo Helper::get_video_button( $banner ); ?>
								<?php }

								if ( ! empty( $title ) ) { ?>
                                    <h2 class="aheto-banner__title"><?php echo wp_kses_post( $title ); ?></h2>
								<?php }

								if ( ! empty( $desc ) ) { ?>
                                    <h5 class="aheto-banner__desc"><?php echo wp_kses_post( $desc ); ?></h5>
								<?php }

								if ( $main_add_button || $add_add_button ) { ?>
                                    <div class="aheto-banner__links">
										<?php
										echo Helper::get_button( $this, $banner, 'main_' );
										echo $btn_direction ? '<br>' : '';
										echo Helper::get_button( $this, $banner, 'add_' ); ?>
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
	<link href="<?php echo $sc_dir . 'assets/css/layout1.css'?>" rel="stylesheet">
	<script>
;(function ($, window, document, undefined) {
    'use strict';

    function banner_slider_height(){

        if($('.full-min-height-js').length){

            const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
            let adminBarH = $('body.admin-bar').length ? 32 : 0;
            let headerH = header.length ? header.outerHeight() : 0;

            $('.full-min-height-js').css('min-height', $(window).innerHeight() - headerH - adminBarH );
        }
    }

    $(window).on('load resize orientationchange', function () {
        banner_slider_height();
    });

    if ( window.elementorFrontend ) {
        banner_slider_height();
    }

})(jQuery, window, document);
	</script>
	<?php
endif;