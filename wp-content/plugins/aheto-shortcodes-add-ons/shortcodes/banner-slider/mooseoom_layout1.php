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

$banners = $this->parse_group($mooseoom_modern_banners);

if ( empty($banners) ) {
	return '';
}

if ( !$mooseoom_swiper_custom_options ) {
	$speed  = 1000;
	$effect = 'fade';
	$loop   = false;
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--mooseoom-modern');

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed' => 1000,
]; 

$carousel_params = Helper::get_carousel_params($atts, 'mooseoom_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/banner-slider/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
	wp_enqueue_style('mooseoom-banner-slider-layout1', $shortcode_dir . 'assets/css/mooseoom_layout1.css', null, null);
}
wp_enqueue_script( 'mooseoom-banner-slider-layout1-js', $shortcode_dir . 'assets/js/mooseoom_layout1.min.js', array( 'jquery' ), null );

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper <?php echo esc_attr($mooseoom_banner_theme); ?>">
		<div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args($banner, [
						'mooseoom_image'         => '',
						'mooseoom_add_image'         => '',
						'mooseoom_title'         => '',
						'mooseoom_desc'          => '',
						'mooseoom_align'         => '',
						'mooseoom_banner_theme'          => '',
					]);
					extract($banner);

					if ( !$mooseoom_image ) {
						continue;
					} ?>
					<div class="swiper-slide">
						<div class="aheto-banner-slider-wrap mooseoom-full-min-height-js <?php echo esc_attr($mooseoom_align); ?>">
							<?php if ( !empty($mooseoom_image )) :
								if ($mooseoom_swiper_lazy) :

									echo Helper::get_attachment_for_swiper($mooseoom_image, ['class' => 'js-bg-swiper swiper-lazy']);

								else :

									echo Helper::get_attachment($mooseoom_image, ['class' => 'js-bg']);

								endif;
							endif; ?>

							<div class="aheto-banner-slider__content">
								<?php if ( !empty($mooseoom_add_image )) { ?>
									<?php echo Helper::get_attachment( $mooseoom_add_image,  ['class' => 'aheto-banner-slider__add-image'] ); ?>
								<?php }

								if ( !empty($mooseoom_sub_title )) { ?>
									<p class="aheto-banner-slider__sub-title"><?php echo wp_kses_post($mooseoom_sub_title); ?></p>
								<?php }

								if ( !empty($mooseoom_title )) { ?>
									<h2 class="aheto-banner__title"><?php echo wp_kses_post($mooseoom_title); ?></h2>
								<?php }

								if ( !empty($mooseoom_desc )) { ?>
									<p class="aheto-banner-slider__desc"><?php echo wp_kses_post($mooseoom_desc); ?></p>
								<?php }

								if ( $mooseoom_main_add_button || $mooseoom_add_add_button ) { ?>
									<div class="aheto-banner-slider__links">
										<?php
										echo Helper::get_button($this, $banner, 'mooseoom_main_');
										
										echo Helper::get_button($this, $banner, 'mooseoom_add_'); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="swiper-button-prev"><span><?php esc_html_e('Prev', 'mooseoom');?></span></div>
		<div class="swiper-button-next"><span><?php esc_html_e('Next', 'mooseoom');?></span></div>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
<link href="<?php echo $shortcode_dir . 'assets/css/mooseoom_layout1.css'?>" rel="stylesheet">
<script>
;(function ($, window, document, undefined) {
    'use strict';

    function banner_slider_height(){
        if($('.mooseoom-full-min-height-js').length){
            const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
            let adminBarH = $('body.admin-bar').length ? 32 : 0;
            let headerH = header.length ? header.outerHeight() : 0;
            $('.mooseoom-full-min-height-js').css('min-height', $(window).innerHeight() - headerH - adminBarH );
        }
    }

    //Add dark arrows to slider
    function darkArrowsSlider() {
        $('.aheto-banner-slider--mooseoom-modern').each(function () {
            if ($(this).hasClass('banner-dark')) {
                $(this).find('div.swiper-button-prev').addClass('dark');
                $(this).find('div.swiper-button-next').addClass('dark');
            }
        });
    }


    $(window).on('load', function () {
        darkArrowsSlider();
    });

    $(window).on('load resize orientationchange', function () {
        banner_slider_height();
    });

})(jQuery, window, document);
</script>  
	<?php
endif;