<?php
/**
 * Title bar default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aht-breadcrumbs--creative' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/title-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'outsourceo-title-bar-layout2', $shortcode_dir . 'assets/css/outsourceo_layout2.css', null, null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="container">
		<?php

		if ( $breadcrumb_type == 'default' ) {
			echo str_replace( 'class="breadcrumbs', 'class="aht-breadcrumbs', aheto_get_breadcrumbs() );
		} else {

			$custom_breadcrumb = $this->parse_group( $custom_breadcrumb );

			if ( ! empty( $custom_breadcrumb ) ) { ?>
				<div class="row">
					<ul class="aht-breadcrumbs">

						<?php foreach ( $custom_breadcrumb as $item ) {

							$item_link = $this->get_link_attributes( $item['link_url'] );

							if ( isset( $item_link['href'] ) && ! empty( $item_link['href'] ) ) {

								if ( isset( $item['current_item'] ) && ! empty( $item['current_item'] ) ) { ?>
									<li class="aht-breadcrumbs__item current">
										<a href="<?php echo esc_url( $item_link['href'] ); ?>"
										   class="aht-breadcrumbs__link"><?php echo esc_html( $item['link_title'] ); ?></a>
									</li>
								<?php } else { ?>
									<li class="aht-breadcrumbs__item">
										<a href="<?php echo esc_url( $item_link['href'] ); ?>"
										   class="aht-breadcrumbs__link"><?php echo esc_html( $item['link_title'] ); ?></a>
									</li>
								<?php } ?>

							<?php }

						} ?>

					</ul>
				</div>

			<?php }
		}


		?>
	</div>
</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/outsourceo_layout2.css'?>" rel="stylesheet">
	<?php
endif;


