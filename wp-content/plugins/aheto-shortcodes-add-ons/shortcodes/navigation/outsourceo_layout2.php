<?php
/**
 * Time Schedule default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $menus ) ) {
	return;
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Nav.
$this->add_render_attribute( 'nav', 'class', 'widget-nav-menu widget-nav-menu--outsourceo-menu' );
$this->add_render_attribute( 'title', 'class', 'widget-nav-menu__title' );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/navigation/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'outsourceo-navigation-layout2', $shortcode_dir . 'assets/css/outsourceo_layout2.css', null, null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div <?php $this->render_attribute_string( 'nav' ); ?>>

		<?php if ( !empty($title) ) : ?>
			<h5 <?php $this->render_attribute_string( 'title' ); ?>><?php echo wp_kses($title, 'post'); ?></h5>
		<?php endif; ?>

		<?php wp_nav_menu([
			'container'       => 'div',
			'items_wrap'      => '<ul id="%1$s" class="%2$s widget-nav-menu__menu">%3$s</ul>',
			'container_class' => 'menu-main-container',
			'menu_class'      => 'menu',
			'menu'            => $menus,
		]); ?>

	</div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/outsourceo_layout2.css'?>" rel="stylesheet">
	<?php
endif;