<?php

/**
 * The Heading Shortcode.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-heading--ewo__simple');
$this->add_render_attribute('wrapper', 'class', $alignment);

wp_enqueue_script('typed');
$animation = isset($title_animation) && !empty($title_animation);

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/heading/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
  wp_enqueue_style('ewo-heading-layout1', $shortcode_dir . 'assets/css/ewo_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <?php
    $heading = $this->get_heading();
    if (!empty($heading)) {
      echo '<' . $text_tag . ' class="aheto-heading__title">' . $this->highlight_text($heading, $animation) . '</' . $text_tag . '>';
    }

    if (!empty($ewo_subtitle)) {
      echo '<' . $ewo_subtitle_tag . ' class="aheto-heading__subtitle">' . esc_html($ewo_subtitle) . '</' . $ewo_subtitle_tag . '>';
    }
  ?>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/ewo_layout1.css'?>" rel="stylesheet">
	<?php
endif;