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

$banners = $this->parse_group($hr_modern_banners);

if ( empty($banners) ) {
	return '';
}

if ( !$custom_options ) {
	$speed  = 1000;
	$effect = 'fade';
	$loop   = true;
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--hr-modern');

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'  => 1000,
	'arrows' => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'hryzantema_swiper_banner_', $carousel_default_params);

/**
 * Highlight Text
 *
 * @param  string $text Text to highlight.
 * @param  boolean $type TYpe.
 * @return string
 */
function hryzantema_highlight_slider_text($text, $type = false) {
	$text = str_replace(']]', '</span>', $text);
	$text = str_replace('[[', $type ? '<span class="js-typed">' : '<span>', $text);

	return wp_kses_post($text);
}

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/banner-slider/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('hryzantema-banner-slider-layout1', $shortcode_dir . 'assets/css/hryzantema_layout1.css', null, null);
}
wp_enqueue_script('hryzantema-banner-slider-layout1-js', $shortcode_dir . 'assets/js/hryzantema_layout1.js', array('jquery'), null);

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ( $banners as $banner ) :
					$banner = wp_parse_args($banner, [
						'hryzantema_image'         => '',
						'hryzantema_title'         => '',
						'hryzantema_desc'          => '',
						'hryzantema_align'         => '',
						'hryzantema_btn_direction' => '',
						'hryzantema_heading_tag'   => '',
					]);
					extract($banner);

					$swiper_lazy_class = $lazy ? 'swiper-lazy' : '';
					$background_image  = Helper::get_background_attachment($hryzantema_image, 'full', $atts, '', $swiper_lazy_class);

					if ( empty($hryzantema_image) ) {
						continue;
					} ?>
					<div class="swiper-slide">
						<div class="aheto-banner-slider-wrap <?php echo esc_attr($hryzantema_align . $swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>>

							<div class="aheto-banner-slider__content">
								<?php

								if (  !empty($hryzantema_subtitle) ) { ?>
									<p class="aheto-banner-slider__subtitle">
										<?php echo wp_kses_post($hryzantema_subtitle); ?>
									</p>
								<?php }

								if ( !empty($hryzantema_title) ) { ?>
									<h1 class="aheto-banner__title">
										<?php echo hryzantema_highlight_slider_text($hryzantema_title) ?>
									</h1>
								<?php }

								if (  !empty($hryzantema_desc) ) { ?>
									<h5 class="aheto-banner-slider__desc"><?php echo wp_kses_post($hryzantema_desc); ?></h5>
								<?php }

								if ( $hryzantema_main_add_button == true || $hryzantema_add_add_button == true ) { ?>
									<div class="aheto-banner-slider__links">
										<?php
										echo Helper::get_button($this, $banner, 'hryzantema_main_');
										echo wp_kses_post($hryzantema_btn_direction ? '<br>' : '');
										echo Helper::get_button($this, $banner, 'hryzantema_add_'); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_pagination('hryzantema_swiper_banner_'); ?>
		</div>
		<?php $this->swiper_arrow('hryzantema_swiper_banner_'); ?>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
<link href="<?php echo $shortcode_dir . 'assets/css/hryzantema_layout1.css'?>" rel="stylesheet">
<script>
;(function ($, window, document, undefined) {
    'use strict';

    function hryzantema_banner_slider_height(){

        if($('.hryzantema-full-min-height-js').length){

            const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
            let adminBarH = $('body.admin-bar').length ? 32 : 0;
            if($(window).width() < 768) {
                adminBarH = $('body.admin-bar').length ? 46 : 0;
            }
            let headerH = header.length ? header.outerHeight() : 0;

            $('.hryzantema-full-min-height-js').css('min-height', $(window).outerHeight() - headerH );

        }
    }

    $(window).on('load resize orientationchange', function () {
        if ($(this).width() > 768) {
            hryzantema_banner_slider_height();
        }
    });


})(jQuery, window, document);
</script>  
	<?php
endif;