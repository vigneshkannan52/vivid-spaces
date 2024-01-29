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

$banners = $this->parse_group($snapster_modern_banners);

if (empty($banners)) {
    return '';
}

$dark_arrows = isset($snapster_dark_arrows) && $snapster_dark_arrows ? 'dark_arrows' : '';
$wider_buttons = isset($snapster_wider_buttons) && $snapster_wider_buttons ? 'wider_buttons' : '';

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', $dark_arrows);
$this->add_render_attribute('wrapper', 'class', $wider_buttons);
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--snapster-modern');

$snapster_prev_button = isset($snapster_prev_button) && !empty($snapster_prev_button) ? $snapster_prev_button : '';
$snapster_next_button = isset($snapster_next_button) && !empty($snapster_next_button) ? $snapster_next_button : '';
$snapster_slider_pagination = isset($snapster_slider_pagination) && $snapster_slider_pagination ? 'hidden' : '';
$snapster_slider_animation = isset($snapster_slider_animation) && $snapster_slider_animation ? 'disable' : '';
$snapster_slider_loop = isset($snapster_slider_loop) && $snapster_slider_loop ? '1' : '0';
$snapster_slider_autoplay = isset($snapster_slider_autoplay) && $snapster_slider_autoplay ? '1' : '0';
$snapster_slider_autoplay_speed = isset($snapster_slider_autoplay_speed) && !empty($snapster_slider_autoplay_speed) ? $snapster_slider_autoplay_speed : '0';
$snapster_slider_buttons = isset($snapster_slider_buttons) && $snapster_slider_buttons ? 'hidden' : '';
/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/banner-slider/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if (empty($custom_css) || ($custom_css == "disabled")) {
    wp_enqueue_style('snapster-banner-slider-layout3', $shortcode_dir . 'assets/css/snapster_layout3.css', null, null);
}

if( ! is_admin() ) {
	wp_enqueue_script('snapster-banner-slider-layout3-js', $shortcode_dir . 'assets/js/snapster_layout3.min.js', array('jquery'), null);
}



?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <?php
    $slice_images = '';
    $slide_content = '';
    $slide_pagination = '';
    $slide_button = '';
    $items_id = 'aheto-bs--snapster-modern-' . rand(1, 99);


    foreach ($banners as $index => $banner) :
        $banner = wp_parse_args($banner, [
            'snapster_image' => '',
            'snapster_ban_title' => '',
            'snapster_subtitle' => ''
        ]);
        extract($banner);

        $checked = $index === 0 ? 'checked' : '';
        $active = $index === 0 ? 'active' : '';
        $count = $index + 1;

        if (!$snapster_image) {
            continue;
        }

        $background_image = '';

        $slice_images .= '<span class="slice-item ' . esc_attr($active) . '"' . esc_attr($background_image) . '>' . Helper::get_attachment($snapster_image, [], $snapster_image_size, $atts, 'snapster_') . '</span>';

        $slide_content .= '<div class="aheto-banner-slider__text ' . esc_attr($active) . '">';

        $slide_content .= !empty($snapster_subtitle) ? '<p class="subtitle">' . esc_html($snapster_subtitle) . '</p>' : '';

        if ($index === 0) {
            $slide_content .= !empty($snapster_ban_title) ? '<h1 class="title ' . esc_attr($snapster_slider_animation) . '">' . esc_html($snapster_ban_title) . '</h1>' : '';
        } else {
            $slide_content .= !empty($snapster_ban_title) ? '<div class="title ' . esc_attr($snapster_slider_animation) . '">' . esc_html($snapster_ban_title) . '</div>' : '';
        }

        $slide_content .= $snapster_main_add_button ? '<div class="links">' . Helper::get_button($this, $banner, 'snapster_main_') . '</div>' : '';
        $slide_content .= '</div>';

        $slide_pagination .= '<input id="' . esc_attr($items_id) . '-img-' . esc_attr($count) . '" name="' . esc_attr($items_id) . '" type="radio" ' . $checked . ' data-count="' . esc_attr($count) . '"/>
        <label for="' . esc_attr($items_id) . '-img-' . esc_attr($count) . '" class="aheto-banner-slider__label-img-' . esc_attr($count) . ' ' . esc_attr($active) . '"></label>';

    endforeach; ?>

    <section class="aheto-banner-slider__container snapster-full-min-height-js"
             data-loop="<?php echo esc_attr($snapster_slider_loop); ?>"
             data-autoplay="<?php echo esc_attr($snapster_slider_autoplay); ?>"
             data-autoplay-speed="<?php echo esc_attr($snapster_slider_autoplay_speed); ?>">
        <div class="slice-overlay"></div>

        <div class="aheto-banner-slider__bgimg">
            <div>
                <?php echo $slice_images; ?>
            </div>
            <div>
                <?php echo $slice_images; ?>
            </div>
            <div>
                <?php echo $slice_images; ?>
            </div>
        </div>
        <div class="aheto-banner-slider__content">
            <?php echo $slide_content; ?>
        </div>

        <div class="aheto-banner-slider__pagination <?php echo esc_attr($snapster_slider_pagination); ?>">
            <div class="aheto-banner-slider__pagination--counters">
                <?php echo $slide_pagination; ?>
            </div>
        </div>

        <div class="aheto-banner-slider__buttons <?php echo esc_attr($snapster_slider_buttons); ?>">
            <div class="aheto-banner-slider__buttons-prev">
                <span data-text="<?php echo esc_attr($snapster_prev_button); ?>"></span>
            </div>
            <div class="aheto-banner-slider__buttons-next">
                <span data-text="<?php echo esc_attr($snapster_next_button); ?>"></span>
            </div>
        </div>


    </section>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
<link href="<?php echo $shortcode_dir . 'assets/css/snapster_layout3.css'?>" rel="stylesheet">
<script>
;(function ($, window, document, undefined) {

    'use strict';
    
    let autoplayInterval;

    function snapster_banner_slider_height() {

        if ($('.aheto-banner-slider--snapster-modern').length) {

            $('.aheto-banner-slider--snapster-modern').each(function () {

                let imageH = 0;
                let imageW = 0;

                $(this).find('.aheto-banner-slider__bgimg > div:first-of-type span').each(function () {

                    imageH = $(this).find('img').innerHeight() > imageH ? $(this).find('img').innerHeight() : imageH;
                    imageW = $(this).find('img').outerWidth() > imageW ? $(this).find('img').outerWidth() : imageW;

                });

                $(this).find('.snapster-full-min-height-js').css('height', imageH);

            });

        }
    }

    $(window).on('load resize orientationchange', function () {
        setTimeout(snapster_banner_slider_height, 100);

    });
    
    
    function snapster_slider_autoplay(banner_slider, elem) {
        banner_slider.find('label').removeClass('active');
        elem.addClass('active');

        const count = elem.prev().data('count');
        let styles = banner_slider.find('.aheto-banner-slider__bgimg div span:nth-child(' + count + ')').attr('style');
        banner_slider.find('.aheto-banner-slider__bgimg').attr('style', styles);

        setTimeout(function () {
            banner_slider.find('.aheto-banner-slider__text').removeClass('active');
            banner_slider.find('.aheto-banner-slider__text:nth-child(' + count + ')').addClass('active');

            banner_slider.find('.aheto-banner-slider__bgimg div span').removeClass('active');
            banner_slider.find('.aheto-banner-slider__bgimg div span:nth-child(' + count + ')').addClass('active');
        }, 100);
    }


    function snapster_banner_slider_pagination() {

        $('.aheto-banner-slider--snapster-modern').each(function () {
            const banner_slider = $(this);
            let banner_loop = $(this).find('.aheto-banner-slider__container').data('loop');
            let banner_autoplay = $(this).find('.aheto-banner-slider__container').data('autoplay');
            let banner_autoplay_speed = $(this).find('.aheto-banner-slider__container').data('autoplay-speed');

            banner_slider.find('.aheto-banner-slider__buttons-prev').on('click', function () {

                if (banner_slider.find('label.active').prev().prev().length) {
                    banner_slider.find('.aheto-banner-slider__buttons-next').removeClass('disabled');
                    banner_slider.find('label.active').prev().prev().click();
                    snapster_banner_slider_disable_button();
                } else if (banner_loop === 1) {
                    banner_slider.find('label:last-of-type').click();
                }

            });

            banner_slider.find('.aheto-banner-slider__buttons-next').on('click', function () {

                if (banner_slider.find('label.active').next().next().length) {
                    banner_slider.find('.aheto-banner-slider__buttons-prev').removeClass('disabled');
                    banner_slider.find('label.active').next().next().click();
                    snapster_banner_slider_disable_button();
                } else if (banner_loop === 1) {
                    banner_slider.find('label:first-of-type').click();
                }

            });

            banner_slider.find('label').on('click', function () {

                snapster_slider_autoplay(banner_slider, $(this));

            });

            let label_next;
            let label_first = banner_slider.find('label:first-of-type');

            if ( banner_autoplay === 1 && banner_autoplay_speed !== '' && banner_autoplay_speed !== 0 ) {

                banner_autoplay_speed = banner_autoplay_speed*1000;

                autoplayInterval = setInterval(function () {
                    if (banner_slider.find('label.active').next().next().length) {
                        banner_slider.find('.aheto-banner-slider__buttons-prev').removeClass('disabled');
                        label_next = banner_slider.find('label.active').next().next();

                        snapster_slider_autoplay(banner_slider, label_next);
                        snapster_banner_slider_disable_button();
                    } else if (banner_loop === 1) {
                        snapster_slider_autoplay(banner_slider, label_first);
                    }else{
                        clearInterval(autoplayInterval);
                    }

                }, banner_autoplay_speed );

            }


        });

    }


    function snapster_banner_slider_disable_button() {
        $('.aheto-banner-slider--snapster-modern').each(function () {
            const banner_slider = $(this);
            const banner_loop = $(this).find('.aheto-banner-slider__container').data('loop');

            if (banner_slider.find('label:first-of-type').hasClass('active') && banner_loop === 0) {
                banner_slider.find('.aheto-banner-slider__buttons-prev').addClass('disabled');
            }

            if (banner_slider.find('label:last-of-type').hasClass('active') && banner_loop === 0) {
                banner_slider.find('.aheto-banner-slider__buttons-next').addClass('disabled');
            }

        });
    }



    $(window).on('load', function () {
        clearInterval(autoplayInterval);
        snapster_banner_slider_pagination();
        snapster_banner_slider_disable_button();
    });


    if (window.elementorFrontend) {
        clearInterval(autoplayInterval);
        setTimeout(snapster_banner_slider_height, 100);
        snapster_banner_slider_pagination();
        snapster_banner_slider_disable_button();
    }

})(jQuery, window, document);
</script>  
	<?php
endif;