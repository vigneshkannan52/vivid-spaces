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

$lists = $this->parse_group($lists);
if (empty($lists)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-list--rela');
$this->add_render_attribute('wrapper', 'class', 'aheto-list--bullets');

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/list/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style('rela-list-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <?php
    if (!empty($heading)) {
        echo '<' . $text_tag . ' class="aheto-list__title">' . wp_kses($heading, 'post') . '</' . $text_tag . '>';
    }
    ?>
    <ul>
        <?php
        foreach ($lists as $item) {
            echo '<li>' . wp_kses($item['list'], 'post') . '</li>';
        }
        ?>
    </ul>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/rela_layout1.css'?>" rel="stylesheet">
	<?php
endif;