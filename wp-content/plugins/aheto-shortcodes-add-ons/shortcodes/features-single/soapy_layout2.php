<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content-block--soapy-modern');
/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/features-single/';

wp_enqueue_style('soapy-features-single-layout2', $shortcode_dir . 'assets/css/soapy_layout2.css', null, null);

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>
			style="background:
			<?php if ( empty($soapy_color1) || empty($soapy_color2) ) { ?>
				<?php echo esc_attr($soapy_color1 . $soapy_color2); ?>
			<?php } else { ?>
					linear-gradient(155deg, <?php echo esc_attr($soapy_color1)?> 40%, <?php echo esc_attr($soapy_color2)?> )
			<?php } ?>">
		<?php if ( !empty($soapy_image_bg) ):
			$background_image = Helper::get_background_attachment($soapy_image_bg, $soapy_image_size, $atts, '');

		endif; ?>
		<div class="aheto-content-block__wrap" <?php echo esc_attr($background_image); ?>>
			<div class="aheto-content-block__text">
				<?php if ( !empty($soapy_title) ) : ?>
					<h4 class="aheto-content-block__title "><?php echo wp_kses($soapy_title, 'post'); ?></h4>
				<?php endif; ?>
				<div class="aheto-content-block__info">
					<?php if ( !empty($soapy_desc) ) : ?>
						<p class="aheto-content-block__info-text ">
							<?php echo wp_kses($soapy_desc, 'post'); ?>
						</p>
					<?php endif; ?>

					<?php if ( !empty($soapy_link_title) ) : ?>
						<div class="aheto-content-block__link-wrap <?php echo esc_attr($soapy_align); ?>">
							<a href="<?php echo esc_url($soapy_link_url['url']); ?>"
							   target="<?php if ( $soapy_link_url['is_external'] == 'on' ) {
								   echo '_blank';
							   } else {
								   echo '_self';
							   } ?>"
							   class="aheto-content-block__link ">
								<?php echo esc_html($soapy_link_title); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/soapy_layout2.css'?>" rel="stylesheet">
	<?php
endif;