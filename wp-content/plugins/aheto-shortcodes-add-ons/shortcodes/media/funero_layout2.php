<?php
/**
 * The Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$funero_gallery = $this->parse_group($funero_gallery);

if ( empty($funero_gallery) ) {

	return '';
}
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-funero-gallery-slider');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$carousel_params = Helper::get_carousel_params($atts, 'funero_swiper_gallery_');

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/media/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
wp_enqueue_style('funero-media-layout2', $shortcode_dir . 'assets/css/funero_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="swiper">
		<div class="swiper-container swiper_aheto_diff_slider" <?php echo esc_attr($carousel_params); ?> >
			<div class="swiper-wrapper">
				<?php foreach ( $funero_gallery as $index => $item ) :
					if ( !empty($item['funero_image']) ) :
						$background_image = \Aheto\Helper::get_background_attachment($item['funero_image'], $atts['funero_media_image_size'], $atts, 'funero_media_');
					?>
						<div class="swiper-slide">
							<div class="aheto-funero-gallery__image" <?php echo esc_attr($background_image); ?>>
								<?php
								if ( !empty($item['funero_link']['url']) ):
										$target = !empty($item['funero_link']['is_external']) ? 'target="_blank"' : 'target="_self"';
									if ( !empty($item['funero_name']) ): ?>
										<a href="<?php echo esc_attr($item['funero_link']['url']); ?>" <?php echo esc_attr($target); ?>
										   class="aheto-funero-gallery__name-wrap">
											<h5 class="aheto-funero-gallery__name"><?php echo esc_html($item['funero_name']); ?></h5>
										</a>
									<?php endif;
								else: ?>
									<?php if ( !empty($item['funero_name']) ): ?>
										<h5 class="aheto-funero-gallery__name"><?php echo esc_html($item['funero_name']); ?></h5>
									<?php endif; endif; ?>
								<?php if ( !empty($item['funero_date']) ): ?>
									<p class="aheto-funero-gallery__date"><?php echo esc_html($item['funero_date']); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<?php $this->swiper_arrow('funero_swiper_gallery_'); ?>
		</div>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/funero_layout2.css'?>" rel="stylesheet">
	<?php
endif;