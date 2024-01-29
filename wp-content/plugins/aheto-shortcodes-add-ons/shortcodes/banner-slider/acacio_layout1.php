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

	extract($atts);

	$banners = $this->parse_group($acacio_modern_banners);

	if ( empty($banners) ) {
		return '';
	}

	$acacio_hide_pagination = isset($acacio_hide_pagination) && $acacio_hide_pagination ? 'hide-pagination' : '';
	$this->generate_css();
	$this->add_render_attribute('wrapper', 'id', $element_id);
	$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
	$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--acacio-modern');
	$this->add_render_attribute( 'wrapper', 'class', $acacio_hide_pagination );

	/**
	 * Set carousel params
	 */
	$carousel_default_params = [
		'speed' => 1000,
		'arrows' => true,
		'effect' => 'slide',
	]; // will use when not chosen option 'Change slider params'

	$carousel_params = Helper::get_carousel_params($atts, 'acacio_swiper_banner_', $carousel_default_params);

	/**
	 * Set dependent style
	 */
	$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/banner-slider/';

	$custom_css    = Helper::get_settings( 'general.custom_css_including' );
	$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
	if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
		wp_enqueue_style('acacio-banner-slider-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null);
	}


	wp_enqueue_script( 'acacio-banner-slider-layout1-js', $shortcode_dir . 'assets/js/acacio_layout1.js', array( 'jquery' ), null );

	;?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="swiper">
        <div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr($carousel_params); ?>>
            <div class="swiper-wrapper">
				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args($banner, [
						'acacio_image'         => '',
						'acacio_title'         => '',
						'acacio_desc'          => '',
						'align'         => '',
						'acacio_btn_direction' => '',
						'acacio_heading_tag'=> '',
					]);
					extract($banner);

					$swiper_lazy_class = $lazy ? 'swiper-lazy': '';
					$background_image = Helper::get_background_attachment($acacio_image, 'full', $atts, '', $swiper_lazy_class);

					if ( !isset($acacio_image) && empty($acacio_image) ) {
						continue;
					} ?>
                <div class="swiper-slide">
                    <div class="aheto-banner-slider-wrap acacio-full-min-height-js <?php echo esc_attr($align . $swiper_lazy_class); ?>" <?php echo esc_attr($background_image );?>>


                        <div class="aheto-banner-slider__content">
							<?php
								if ( isset($acacio_title) && !empty($acacio_title) ) { ?>
                            <<?php echo esc_attr($acacio_heading_tag); ?> class="aheto-banner__title">
							<?php

								$acacio_title = str_replace( ']]', '</span>', $acacio_title );
								$acacio_title = str_replace( '[[', '<span>', $acacio_title );

								echo ($acacio_title) ?>
                        </<?php echo esc_attr($acacio_heading_tag); ?>>

						<?php }

							if ( isset($acacio_desc) && !empty($acacio_desc) ) { ?>
                                <h5 class="aheto-banner-slider__desc"><?php echo wp_kses_post($acacio_desc); ?></h5>
							<?php }

							if ( $acacio_main_add_button || $acacio_add_add_button ) { ?>
                                <div class="aheto-banner-slider__links">
									<?php
										echo Helper::get_button($this, $banner, 'acacio_main_');
										echo wp_kses_post($acacio_btn_direction ? '<br>' : '');
										echo Helper::get_button($this, $banner, 'acacio_add_'); ?>
                                </div>
							<?php } ?>

                    </div>
                </div>
            </div>
			<?php endforeach; ?>
        </div>
		<?php $this->swiper_pagination('acacio_swiper_banner_'); ?>
    </div>
	<?php $this->swiper_arrow('acacio_swiper_banner_'); ?>
</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
<link href="<?php echo $shortcode_dir . 'assets/css/acacio_layout1.css'?>" rel="stylesheet">
<script>
;(function ($, window, document, undefined) {
    'use strict';

    function acacio_banner_slider_height(){

        if($('.acacio-full-min-height-js').length){

            const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
            let headerH = header.length ? header.outerHeight() : 0;

            $('.acacio-full-min-height-js').css('min-height', $(window).outerHeight() - headerH );
        }
    }

    $(window).on('load resize orientationchange', function () {
        if ($(window).width() > 768) {
            acacio_banner_slider_height();
        }
    });

})(jQuery, window, document);
</script>  
	<?php
endif;