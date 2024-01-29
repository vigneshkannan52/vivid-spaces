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

$banners = $this -> parse_group ( $snapster_creative_banners );

if (empty( $banners )) {
    return '';
}


$this -> generate_css ();
$this -> add_render_attribute ( 'wrapper', 'id', $element_id );
$this -> add_render_attribute ( 'wrapper', 'class', $this -> the_custom_classes () );
$this -> add_render_attribute ( 'wrapper', 'class', 'aheto-banner-slider--snapster-creative' );

/**
 * Set carousel params
 */
$carousel_default_params = [
    'speed' => 1000,
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper ::get_carousel_params ( $atts, 'snapster_swiper_creative_', $carousel_default_params );

/**
 * Set dependent style
 */
$sc_dir = SNAPSTER_T_URI . '/aheto/banner-slider/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if (empty($custom_css) || ($custom_css == "disabled")) {
    wp_enqueue_style('snapster-banner-slider-layout4', $sc_dir . 'assets/css/snapster_layout4.css', null, null);
}
wp_enqueue_script('lettering', $sc_dir . 'assets/js/jquery.lettering.min.js', array('jquery'), null);
wp_enqueue_script('tweenMax', $sc_dir . 'assets/js/tweenMax.min.js', array('jquery'), null);
wp_enqueue_script('snapster-banner-slider-layout4-js', $sc_dir . 'assets/js/snapster_layout4.js', array('jquery'), null);

?>
<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>
    <div class="swiper">
        <div class="swiper-container wiper-pagination--numeric swiper_aheto_diff_slider" data-pagination-type="fraction" <?php echo esc_attr ( $carousel_params ); ?>>
            <div class="swiper-wrapper">
                <?php foreach ($banners as $banner) :
                    $banner = wp_parse_args ( $banner, [
                        'snapster_image' => '',
                        'snapster_title' => '',
                        'snapster_desc' => '',
                        'align' => '',
                        'snapster_text_tag' => 'div'
                    ] );
                    extract ( $banner );

                    if ( !$snapster_image) {
                        continue;
                    }
                    $background_image = Helper ::get_background_attachment ( $snapster_image, $image_size, $atts, '' ); ?>

                    <div class="swiper-slide">
                        <div class="aheto-banner-slider-wrap snapster-full-min-height-js <?php echo esc_attr ( $align ); ?>" <?php echo esc_attr ( $background_image ); ?>>

                            <div class="aheto-banner-slider__overlay"></div>
                            <div class="aheto-banner-slider__content">
                                <?php
                                if (!empty($snapster_title)) {
                                    echo '<' . $snapster_text_tag . ' class="aheto-banner__title">' .  wp_kses($snapster_title, 'post') . '</' . $snapster_text_tag . '>';
                                }

                                if ( $snapster_main_add_button || $snapster_add_add_button ) { ?>
                                    <div class="aheto-banner-slider__links">
                                        <?php echo Helper::get_button( $this, $banner, 'snapster_main_' );

                                        if ( $snapster_btn_direction ) { ?>
                                            <br>
                                        <?php }

                                        echo Helper::get_button( $this, $banner, 'snapster_add_' ); ?>

                                    </div>
                                <?php }
                                ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php $this->swiper_pagination('snapster_swiper_creative_'); ?>
        </div>
        <?php $this -> swiper_arrow ('snapster_swiper_creative_'); ?>
    </div>
</div>