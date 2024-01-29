<?php
/**
 * The Heading Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
wp_enqueue_script('typed');

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-heading--soapy-simple');
$this->add_render_attribute('wrapper', 'class', $soapy_align);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/heading/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( empty($custom_css) || ($custom_css == "disabled") ) {
	wp_enqueue_style('soapy-heading-layout1', $shortcode_dir . 'assets/css/soapy_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php
	// Heading.
	if ( !empty($soapy_subtitle) ) {
		$image_left  = '';
		$image_right = '';
		if ( !empty($soapy_i_left) ) {
			$image_left = Helper::get_attachment($soapy_i_left, ['class' => 'aheto-heading__image']);
		}
		if ( !empty($soapy_i_right) ) {
			$image_right = Helper::get_attachment($soapy_i_right, ['class' => 'aheto-heading__image']);
		}
		$style = '';
		if ( isset($soapy_subtitle_space) && $soapy_subtitle_space == true ) {
			$style = 'style="margin-bottom: 0"';
		}
		echo '<h6 class="aheto-heading__subtitle" '.$style.'>' . $image_left . wp_kses($soapy_subtitle, 'post') . $image_right . '</h6>';
	}

	if ( !empty($soapy_title) ) {
		if($soapy_use_title_space == true && !empty($soapy_title_space)){
			if(is_numeric ($soapy_title_space)){
				$title_space = 'style="margin-bottom: '.$soapy_title_space.'px;"';
			}
		}else{
			$title_space = '';
		}
		echo '<'.$soapy_title_tag.' class="aheto-heading__title" '.$title_space.'>' . wp_kses($soapy_title, 'post') . '</'.$soapy_title_tag.'>';
	}

	if ( !empty($soapy_desc) ) {
		echo '<p class="aheto-heading__desc  ">' . wp_kses($soapy_desc, 'post') . '</p>';
	}
	if ( $soapy_link == true ) {
	$soapy_remove_arrow = $soapy_remove_arrow == true ? 'aheto-heading__link-arrow-remove' : '';
		if ( !empty($soapy_link_title) && !empty($soapy_link_url) ) {
			$target = '';
			if($soapy_link_url['is_external'] == 'on') {$target == "target='_blank'";}
			echo '<a href="' . esc_url($soapy_link_url['url']) . '"
			  '.$target.'
			 class="aheto-heading__link aheto-heading__link-arrow '.esc_attr($soapy_remove_arrow).'">' . esc_html($soapy_link_title) . '</a>';
		}
	} ?>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/soapy_layout1.css'?>" rel="stylesheet">
	<?php
endif;