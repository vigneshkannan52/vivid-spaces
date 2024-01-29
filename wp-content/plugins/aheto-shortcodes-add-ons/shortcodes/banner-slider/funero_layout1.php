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

$banners = $this->parse_group($funero_simple_banners);

if ( empty($banners) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--funero-simple');

if ( !$funero_swiper_simple_custom_options ) {
	$speed    = 1000;
	$effect   = 'slide';
	$loop     = true;
	$arrows   = true;
}

/**
 * Set carousel params
 */
$carousel_default_params = [
	'effect'   => 'slide',
	'loop'     => 1,
	'autoplay' => 0,
	'arrows'   => 1,
	'lazy'     => 0,
	'speed'    => 1000,
]; // will use when not chosen option 'Change slider params'
/**
 * Set carousel params
 */
$carousel_params = Helper::get_carousel_params($atts, 'funero_swiper_simple_', $carousel_default_params);

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/banner-slider/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
	wp_enqueue_style('funero-banner-slider-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ($banners

				as $banner):
				$banner = wp_parse_args($banner, [
					'funero_image_bg'        => '',
					'funero_image'           => '',
					'funero_title'           => '',
					'funero_desc'            => '',
					'funero_title_tag'       => '',
					'funero_subtitle'        => '',
					'funero_subtitle_spaces' => '',
					'funero_align'           => '',
					'funero_overlay'         => '',
				]);
				extract($banner);


				if ( !$funero_image_bg ) {
					continue;
				} ?>
				<?php
				$background_image = '';
				if ( $funero_image_bg ):
					$lazy_class       = $lazy ? ' swiper-lazy' : '';
					$background_image = Helper::get_background_attachment($funero_image_bg, 'full', $atts, '', $lazy);

				endif; ?>
				<div class="swiper-slide">
					<div class="aheto-banner-slider-wrap <?php echo esc_attr($funero_align); ?>" <?php echo esc_attr($background_image); ?>>
						<?php if ( $funero_overlay != '' ): ?>
							<div class="aheto-banner-slider__overlay aheto-banner-slider__overlay-<?php echo esc_attr($funero_overlay) ?>"></div>
						<?php endif; ?>
						<div class="aheto-banner-slider__content ">
							<?php if ( !empty($funero_image) ) { ?>
								<div class="aheto-banner-slider__image-wrap">
									<?php echo Helper::get_attachment($funero_image, ['class' => 'aheto-banner-slider__image']); ?>
								</div>
							<?php } ?>
							<?php if ( !empty($funero_subtitle) ) { ?>
								<?php !empty($funero_subtitle_spaces) ? $subtitle_space = 'style= margin-bottom:0px;' : $subtitle_space = ''; ?>
								<h6 class="aheto-banner-slider__subtitle " <?php echo esc_attr($subtitle_space); ?>>
									<?php echo wp_kses($funero_subtitle, 'post'); ?></h6>
							<?php }

							if (!empty($funero_title)) { ?>
							<<?php echo esc_attr($funero_title_tag); ?>
							class="aheto-banner-slider__title"><?php echo wp_kses($funero_title, 'post'); ?>
						</<?php echo esc_attr($funero_title_tag); ?>>
					<?php }
					if ( !empty($funero_desc )) { ?>
						<p class="aheto-banner-slider__desc"><?php echo wp_kses($funero_desc, 'post'); ?></p>
					<?php }

					if ( $main_add_button == true ) { ?>
						<?php $btn_space = !empty($funero_smaller_space_before_btn) ?  'style= margin-top:50px;' : ''; ?>
						<div class="aheto-banner-slider__links" <?php echo esc_attr($btn_space); ?>>
							<?php echo Helper::get_button($this, $banner, 'main_'); ?>
						</div>
					<?php } ?>

					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php $this->swiper_arrow('funero_swiper_simple_'); ?>
	</div>
</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
<link href="<?php echo $shortcode_dir . 'assets/css/funero_layout1.css'?>" rel="stylesheet">
	<?php
endif;
