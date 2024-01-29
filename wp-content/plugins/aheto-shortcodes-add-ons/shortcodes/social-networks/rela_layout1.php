<?php
/**
 * Social network default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$networks = $this->parse_group($networks);
if (empty($networks)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-socials--networks-rela-modern');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

//Container
$this->add_render_attribute('container', 'class', 'aheto-socials-container');
if (!empty($style)) {
    $this->add_render_attribute('container', 'class', 'aheto-socials--' . $style);
}
$this->add_render_attribute('container', 'class', $socials_align . '-align');
$this->add_render_attribute('container', 'class', $socials_align_mob . '-align-mob');

// Template.
$this->add_render_attribute('link', 'href', '%1$s');
$this->add_render_attribute('link', 'class', 'aheto-socials__link');

$social_template = '<a ' . $this->get_render_attribute_string('link') . ' target="_blank"><i class="aheto-socials__icon icon ion-social-%2$s"></i>%2$s</a>';

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/social-networks/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style('rela-social-networks-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div <?php $this->render_attribute_string('container'); ?>>

        <?php echo Helper::get_social_networks($networks, $social_template); ?>
    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/rela_layout1.css'?>" rel="stylesheet">
	<?php
endif;