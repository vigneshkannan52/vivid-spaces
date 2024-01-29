<?php
/**
 * The Progress Bar Shortcode.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-counter--hr-classic-2');


/**
 * Highlight Text
 *
 * @param  string $text Text to highlight.
 * @param  boolean $type TYpe.
 * @return string
 */
$description = str_replace(']]', '</span>', $description);
$description = str_replace('[[', '<span>', $description);

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/progress-bar/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
	wp_enqueue_style('hryzantema-progress-bar-layout2', $shortcode_dir . 'assets/css/hryzantema_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php
	// Icon.
	$this->the_icon('aheto-counter__icon');

	// Percentage.
	if ( !empty($percentage) ) {
		echo '<h2 class="aheto-counter__number js-counter">' . absint($percentage) . '</h2>';
	}

	// Description.
	if ( !empty($description) ) { ?>
		<p class="aheto-counter__desc">
			<?php echo wp_kses_post($description) ?>
		</p>
	<?php } ?>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/hryzantema_layout2.css'?>" rel="stylesheet">
	<?php
endif;