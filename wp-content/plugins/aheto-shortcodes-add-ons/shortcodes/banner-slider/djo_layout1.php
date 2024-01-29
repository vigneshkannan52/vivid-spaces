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

$banners = $this->parse_group($djo_djo_modern_banners);

if (empty($banners)) {
    return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-slider--djo-modern');


/**
 * Set carousel params
 */
$carousel_params = Helper::get_carousel_params($atts, 'djo_swiper_');

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/banner-slider/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style('djo-banner-slider-layout1', $shortcode_dir . 'assets/css/djo_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper');?>>
	<div class="swiper">
		<div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr($carousel_params); ?>>
			<div class="swiper-wrapper">
				<?php foreach ($banners as $banner):
					$banner = wp_parse_args($banner, [
						'djo_image' 			=> '',
						'djo_overlay' 		=> '',
						'djo_overlay_color'	=> '',
						'djo_title' 			=> '',
						'djo_desc' 			=> '',
						'djo_align' 			=> '',
						'djo_title_tag' 		=> ''
					]);
  					extract($banner);

					$djo_overlay = isset($djo_overlay) && $djo_overlay == true ? 'overlay-on' : '';
					$djo_title_tag = isset( $djo_title_tag ) && !empty( $djo_title_tag ) ? $djo_title_tag : 'h1';
					if (empty($djo_image)) {
						continue;
					}

					$swiper_lazy_class = $djo_swiper_lazy ? ' swiper-lazy' : '';
					$background_image = Helper::get_background_attachment($djo_image, 'full', $atts, '', $djo_swiper_lazy); ?>

					<div class="swiper-slide">
						<div class="aheto-banner-slider-wrap djo-full-min-height-js s-back-switch <?php echo esc_attr($djo_align . $swiper_lazy_class); ?>" <?php echo esc_attr($background_image); ?>>

						<?php if ($djo_overlay == true && !empty($djo_overlay_color)): ?>
							<span class="aheto-banner-slider__overlay"
									style="background-color: <?php echo esc_attr($djo_overlay_color); ?>;"></span>
						<?php endif;?>

						<div class="aheto-banner-slider__content">

							<?php if ( ! empty( $djo_desc )) {?>
								<p class="aheto-banner-slider__desc aheto-subhead"><?php echo wp_kses_post($djo_desc); ?></p>
							<?php }

							if ( ! empty ( $djo_title )) {?>
								<<?php echo esc_attr( $djo_title_tag ); ?> class="aheto-banner__title"><?php echo wp_kses_post($djo_title); ?></<?php echo esc_attr( $djo_title_tag ); ?>>
							<?php }

							if ($djo_main_add_button == true) {?>
								<div class="aheto-banner-slider__links">
									<?php echo Helper::get_button($this, $banner, 'djo_main_'); ?>
								</div>
							<?php }?>

							</div>
						</div>
					</div>
				<?php endforeach;?>
			</div>
			<?php $this->swiper_pagination('djo_swiper_');?>
		</div>
		<?php if ( ! empty( $this->atts[ 'djo_swiper_arrows' ] ) ) {
			 $num = rand(5, 55);  ?>
			<div class="swiper-button-prev">
				<svg xmlns="http://www.w3.org/2000/svg" width="34" height="37" viewBox="0 0 34 37">
					<defs>
						<mask id="lbn0b<?php echo esc_attr($num);?>" width="2.05" height="2.04" x="-1.02" y="-1.02">
							<path fill="var(--c-light)" d="M3.4 3.4h26.2v30.2H3.4z" />
							<path d="M4 18.5l25 14.503V3.996z" />
						</mask>
						<filter id="lbn0a<?php echo esc_attr($num);?>" width="57" height="61" x="-12" y="-12" filterUnits="userSpaceOnUse">
							<feOffset in="SourceGraphic" result="FeOffset1023Out" />
							<feGaussianBlur in="FeOffset1023Out" result="FeGaussianBlur1024Out" stdDeviation="2.16 2.16" />
						</filter>
						<clipPath id="lbn0c<?php echo esc_attr($num);?>">
							<path fill="var(--c-light)" d="M4 18.5l25 14.503V3.996z" />
						</clipPath>
					</defs>
					<g>
						<g>
							<g filter="url(#lbn0a<?php echo esc_attr($num);?>)">
								<path fill="none" stroke="var(--c-active)" stroke-opacity=".25" stroke-width="1.2" d="M4 18.5v0l25 14.503v0V3.996v0z" mask="url(&quot;#lbn0b<?php echo esc_attr($num);?>&quot;)" />
								<path fill="var(--c-active)" fill-opacity=".25" d="M4 18.5l25 14.503V3.996z" />
							</g>
							<path class="path" fill="none" stroke="var(--c-active)" stroke-miterlimit="50" stroke-width="4" d="M4 18.5v0l25 14.503v0V3.996v0z" clip-path="url(&quot;#lbn0c<?php echo esc_attr($num);?>&quot;)" />
						</g>
					</g>
				</svg>
			</div>
			<div class="swiper-button-next">
				<svg xmlns="http://www.w3.org/2000/svg" width="35" height="38" viewBox="0 0 35 38">
					<defs>
						<mask id="uok9b<?php echo esc_attr($num);?>" width="2.05" height="2.04" x="-1.02" y="-1.02">
							<path fill="var(--c-light)" d="M4.4 3.4h27.2v31.2H4.4z" />
							<path d="M31 19L5.5 33.722V4.277z" />
						</mask>
						<filter id="uok9a<?php echo esc_attr($num);?>" width="58" height="62" x="-11" y="-12" filterUnits="userSpaceOnUse">
							<feOffset in="SourceGraphic" result="FeOffset1051Out" />
							<feGaussianBlur in="FeOffset1051Out" result="FeGaussianBlur1052Out" stdDeviation="2.16 2.16" />
						</filter>
						<clipPath id="uok9c<?php echo esc_attr($num);?>">
							<path fill="var(--c-light)" d="M31 19L5.5 33.722V4.277z" />
						</clipPath>
					</defs>
					<g>
						<g>
							<g filter="url(#uok9a<?php echo esc_attr($num);?>)">
								<path fill="none" stroke="var(--c-active)" stroke-opacity=".25" stroke-width="1.2" d="M31 19v0L5.5 33.722v0V4.277v0z" mask="url(&quot;#uok9b<?php echo esc_attr($num);?>&quot;)" />
								<path fill="var(--c-active)" fill-opacity=".25" d="M31 19L5.5 33.722V4.277z" />
							</g>
							<g filter="url(#uok9a<?php echo esc_attr($num);?>)">
								<path fill="none" stroke="var(--c-active)" stroke-opacity=".25" stroke-width="1.2" d="M31 19v0L5.5 33.722v0V4.277v0z" mask="url(&quot;#uok9b<?php echo esc_attr($num);?>&quot;)" />
								<path fill="var(--c-active)" fill-opacity=".25" d="M31 19L5.5 33.722V4.277z" />
							</g>
							<path class="path" fill="none" stroke="var(--c-active)" stroke-miterlimit="50" stroke-width="4" d="M31 19v0L5.5 33.722v0V4.277v0z" clip-path="url(&quot;#uok9c<?php echo esc_attr($num);?>&quot;)" />
						</g>
					</g>
				</svg>
			</div>
		<?php } ?>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
<link href="<?php echo $shortcode_dir . 'assets/css/djo_layout1.css'?>" rel="stylesheet">
	<?php
endif;