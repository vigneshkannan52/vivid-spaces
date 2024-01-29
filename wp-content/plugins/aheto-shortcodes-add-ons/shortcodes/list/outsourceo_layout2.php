<?php
/**
 * The List Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$lists = $this->parse_group($outsourceo_lists);
if ( empty($lists) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-list--outsourceo-links');


/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/list/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'outsourceo-list-layout2', $shortcode_dir . 'assets/css/outsourceo_layout2.css', null, null );
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<ul>
		<?php

		foreach ( $lists as $item ) {

			$item_link = $this->get_link_attributes( $item['outsourceo_link_url'] );

			echo '<li><i class="ion-android-arrow-dropright"></i><a href="'. esc_url($item_link['href']) .'">' . wp_kses($item['outsourceo_link_text'], 'post') . '</a></li>';

		} ?>
	</ul>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/outsourceo_layout2.css'?>" rel="stylesheet">
	<?php
endif;