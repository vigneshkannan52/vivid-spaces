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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content-block--soapy-img-year');
/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/features-single/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
	wp_enqueue_style('soapy-features-single-layout6', $shortcode_dir . 'assets/css/soapy_layout6.css', null, null);

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<span></span>
		<div class="aheto-content-block__img-wrap">
			<?php if ( !empty($soapy_image_bg) ) {
				echo Helper::get_attachment($soapy_image_bg, ['class' => 'aheto-content-block__image']);
			} ?>
		</div>
		<div class="aheto-content-block__info">
			<?php if ( !empty($soapy_title) ) : ?>
				<h4 class="aheto-content-block__title "><?php echo wp_kses($soapy_title, 'post'); ?></h4>
			<?php endif; ?>
			<?php if ( !empty($soapy_desc) ) : ?>
				<p class="aheto-content-block__info-text ">
					<?php echo wp_kses($soapy_desc, 'post'); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/soapy_layout6.css'?>" rel="stylesheet">
	<?php
endif;