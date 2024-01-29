<?php
/**
 * The Progress Bar Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

extract($atts);
use Aheto\Helper;

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/progress-bar/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
	wp_enqueue_style('soapy-progress-bar-layout1', $shortcode_dir . 'assets/css/soapy_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-progress t-center">
			<div class="aheto-progress__chart js-counter js-whole">
				<?php echo absint($soapy_number); ?>
			</div>
		<?php if ( !empty($heading) ) {
			echo '<h5 class="aheto-progress__title">' . wp_kses($heading, 'post') . '</h5>';
		} ?>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/soapy_layout1.css'?>" rel="stylesheet">
	<?php
endif;