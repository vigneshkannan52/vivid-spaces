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

$banners = $this->parse_group($moovit_modern_banners);

if (empty($banners)) {
    return '';
}

$moovit_arrows = isset($moovit_arrows) && !empty($moovit_arrows) ? $moovit_arrows : 'bottom_modern';

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--moovit-modern');
$this->add_render_attribute('wrapper', 'class', 'arrows-' . $moovit_arrows);

/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'moovit_swiper_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/banner-slider/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if (empty($custom_css) || ($custom_css == "disabled")) {
    wp_enqueue_style('moovit-banner-slider-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null);
}
wp_enqueue_script('moovit-banner-slider-layout1-js', $shortcode_dir . 'assets/js/moovit_layout1.min.js', array('jquery'), null); ?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="swiper">
        <div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr($carousel_params); ?>>
            <div class="swiper-wrapper">
                <?php foreach ($banners

                as $banner) :
                $banner = wp_parse_args($banner, [
                    'moovit_image' => '',
                    'moovit_add_image' => '',
                    'moovit_title' => '',
                    'moovit_desc' => '',
                    'align' => '',
                    'moovit_btn_direction' => ''
                ]);

                extract($banner);

                $swiper_lazy_class = $moovit_swiper_lazy ? ' swiper-lazy' : '';
                $background_image = !empty($moovit_image) ? Helper::get_background_attachment($moovit_image, 'full', $atts, '', $moovit_swiper_lazy) : ''; ?>

                <div class="swiper-slide">


                    <div class="aheto-banner-slider-wrap moovit-full-min-height-js <?php echo esc_attr($align . $swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>>

                        <div class="aheto-banner-slider__content">
                            <?php if ($moovit_add_image) { ?>
                                <?php echo Helper::get_attachment($moovit_add_image, ['class' => 'aheto-banner-slider__add-image'], $moovit_image_size, $atts, 'moovit_'); ?>
                            <?php }

                            if (!empty($moovit_title)) {
                            $moovit_title_tag = isset($moovit_title_tag) && !empty($moovit_title_tag) ? $moovit_title_tag : 'h1'; ?>
                            <<?php echo esc_attr($moovit_title_tag); ?>
                            class="aheto-banner__title"><?php echo wp_kses($moovit_title, 'post'); ?></<?php echo esc_attr($moovit_title_tag); ?>
                        >
                        <?php }

                        if (!empty($moovit_desc)) { ?>
                            <h5 class="aheto-banner-slider__desc"><?php echo wp_kses($moovit_desc, 'post'); ?></h5>
                        <?php }

                        if ($moovit_main_add_button || $moovit_add_add_button) { ?>
                            <div class="aheto-banner-slider__links">
                                <?php echo Helper::get_button($this, $banner, 'moovit_main_');

                                if ($moovit_btn_direction) { ?>
                                    <br>
                                <?php }

                                echo Helper::get_button($this, $banner, 'moovit_add_'); ?>

                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php $this->swiper_pagination('moovit_swiper_'); ?>
    </div>
    <h6 class="moovit-swiper-arrows-wrap">
        <?php if (!empty($this->atts['moovit_swiper_arrows']) && isset($this->atts['moovit_swiper_arrows_style']) && $this->atts['moovit_swiper_arrows_style'] === 'number') {
            $span_prev = '<span class="swiper-slides-prev"></span> ';
            $span_total = '<span class="swiper-slides-total"></span>';
            $span_next = '<span class="swiper-slides-next"></span> ';

            echo '<span class="swiper-button-prev swiper-button-prev--number">' . $span_prev . $span_total . '</span><span class="swiper-button-next swiper-button-next--number">' . $span_next . $span_total . '</span>';
        } elseif (!empty($this->atts['moovit_swiper_arrows']) && isset($this->atts['moovit_swiper_arrows_style']) && $this->atts['moovit_swiper_arrows_style'] === 'number_zero') {
            $span_prev = '<span class="swiper-slides-prev"></span> ';
            $span_total = '<span class="swiper-slides-total"></span>';
            $span_next = '<span class="swiper-slides-next"></span> ';

            echo '<span class="swiper-button-prev swiper-button-prev--number-zero">' . $span_prev . $span_total . '</span><span class="swiper-button-next swiper-button-next--number-zero">' . $span_next . $span_total . '</span>';

        } elseif (!empty($this->atts['moovit_swiper_arrows'])) {
            echo '<span class="swiper-button-prev"></span><span class="swiper-button-next"></span>';
        } ?>
    </h6>
</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
<link href="<?php echo $shortcode_dir . 'assets/css/moovit_layout1.css'?>" rel="stylesheet">
<script>
;(function ($, window, document, undefined) {
    'use strict';

    function moovit_banner_slider_height(){

        if($('.moovit-full-min-height-js').length){

            const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
            let adminBarH = $('body.admin-bar').length ? 32 : 0;
            let headerH = header.length ? header.outerHeight() : 0;

            $('.moovit-full-min-height-js').css('min-height', $(window).innerHeight() - headerH - adminBarH );
        }
    }

    $(window).on('load resize orientationchange', function () {

        moovit_banner_slider_height();

    });

    if ( window.elementorFrontend ) {
        moovit_banner_slider_height();
    }


})(jQuery, window, document);
</script>  
	<?php
endif;