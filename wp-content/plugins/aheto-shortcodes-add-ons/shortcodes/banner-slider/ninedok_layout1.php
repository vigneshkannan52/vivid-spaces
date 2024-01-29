<?php
	/**
	 * The Banner Slider Shortcode.
	 *
	 * @since      1.0.0
	 * @package    Aheto
	 * @subpackage Aheto\Shortcodes
	 * @author     Upqode <info@upqode.com>
	 */

	use Aheto\Helper;

	extract ( $atts );

	$banners = $this -> parse_group ( $ninedok_modern_banners );

	if (empty( $banners )) {
		return '';
	}


	$this -> generate_css ();
	$this -> add_render_attribute ( 'wrapper', 'id', $element_id );
	$this -> add_render_attribute ( 'wrapper', 'class', $this -> the_custom_classes () );
	$this -> add_render_attribute ( 'wrapper', 'class', 'aheto-banner-slider--ninedok-modern' );

	/**
	 * Set carousel params
	 */
	$carousel_default_params = [
		'speed' => 1000,
	]; // will use when not chosen option 'Change slider params'

	$carousel_params = Helper ::get_carousel_params ( $atts, 'ninedok_swiper_', $carousel_default_params );

	/**
	 * Set dependent style
	 */
	$shortcode_dir = plugins_url ( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/banner-slider/';
	$custom_css = Helper ::get_settings ( 'general.custom_css_including' );
	$custom_css = ( isset( $custom_css ) && !empty( $custom_css ) ) ? $custom_css : false;
	if (empty( $custom_css ) || ( $custom_css == "disabled" )) {
		wp_enqueue_style ( 'ninedok-banner-slider-layout1', $shortcode_dir . 'assets/css/ninedok_layout1.css', null, null );
	}
	wp_enqueue_script ( 'ninedok-banner-slider-layout1-js', $shortcode_dir . 'assets/js/ninedok_layout1.min.js', array ( 'jquery' ), null );

?>
<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>
    <div class="swiper">
        <div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr ( $carousel_params ); ?> data-progress-move="1">
            <div class="swiper-wrapper">
				<?php foreach ($banners as $banner) :
					$banner = wp_parse_args ( $banner, [
						'ninedok_image' => '',
						'ninedok_add_image' => '',
						'ninedok_title' => '',
						'ninedok_desc' => '',
						'ninedok_align' => '',
						'ninedok_text_tag' => 'div'
					] );
					extract ( $banner );

					if ( !$ninedok_image) {
						continue;
					}
					$background_image = Helper ::get_background_attachment ( $ninedok_image, $image_size, $atts, '' ); ?>

                    <div class="swiper-slide">
                        <div class="aheto-banner-slider-wrap ninedok-full-min-height-js <?php echo esc_attr ( $ninedok_align ); ?>" <?php echo esc_attr ( $background_image ); ?>>

                            <div class="aheto-banner-slider__overlay"></div>
                            <div class="aheto-banner-slider__content">
								<?php if ($ninedok_add_image) { ?>
									<?php echo Helper ::get_attachment ( $ninedok_add_image, [ 'class' => 'aheto-banner-slider__add-image' ], $ninedok_image_size, $atts, 'ninedok_' ); ?>
								<?php }
									if ( !empty( $ninedok_subtitle )) { ?>
                                        <p class="aheto-banner__subtitle"><?php echo wp_kses ( $ninedok_subtitle, 'post' ); ?></p>
									<?php }
									if (!empty($ninedok_title)) {
										echo '<' . $ninedok_text_tag . ' class="aheto-banner__title">' .  wp_kses($ninedok_title, 'post') . '</' . $ninedok_text_tag . '>';
									}

									if ( !empty( $ninedok_desc )) { ?>
                                        <h5 class="aheto-banner-slider__desc"><?php echo wp_kses ( $ninedok_desc, 'post' ); ?></h5>
									<?php } ?>

                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
		<?php $this -> swiper_arrow ( 'ninedok_swiper_' ); ?>
    </div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
<link href="<?php echo $shortcode_dir . 'assets/css/ninedok_layout1.css'?>" rel="stylesheet">
<script>
;(function ($, window, document, undefined) {
    'use strict';

    function ninedok_banner_slider_height() {

        if ($('.ninedok-full-min-height-js').length) {

            const headerAbsolute = $('.aheto-header.aheto-header--absolute');
            const headerFixed = $('.aheto-header.aheto-header--fixed');


            if (headerAbsolute.length) {
                setTimeout(() => {
                    $('.aheto-banner-slider--ninedok-modern .swiper > div').addClass('active');
                }, 100);
            }
            if (headerFixed.length) {
                setTimeout(() => {
                    $('.aheto-banner-slider--ninedok-modern .swiper > div').addClass('active');
                }, 100);
            }

        }


    }

    $(window).on('load resize orientationchange', function () {

        ninedok_banner_slider_height();

    });


})(jQuery, window, document);
</script>  
	<?php
endif;