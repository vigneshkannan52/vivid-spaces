<?php
/**
 * Social network default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$networks = $this->parse_group($networks);
if ( empty($networks) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-socials-networks--soapy');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

//Container
$this->add_render_attribute('container', 'class', 'aheto-socials');


// Template.
$this->add_render_attribute('link', 'href', '%1$s');
$this->add_render_attribute('link', 'class', 'aheto-socials__link');


$social_template = '<a ' . $this->get_render_attribute_string('link') . ' target="_blank"><i class="aheto-socials__icon icon ion-social-%2$s"></i></a>';

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/social-networks/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
	wp_enqueue_style('soapy-social-networks-layout1', $shortcode_dir . 'assets/css/soapy_layout1.css', null, null);

?>


<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('container'); ?>>
		<?php if ( !empty($soapy_label)): ?>
			<span class="aheto-socials__label"> <?php echo esc_html($soapy_label) ?></span>
		<?php endif; ?>
		<?php echo Helper::get_social_networks($networks, $social_template); ?>
	</div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/soapy_layout1.css'?>" rel="stylesheet">
	<?php
endif;