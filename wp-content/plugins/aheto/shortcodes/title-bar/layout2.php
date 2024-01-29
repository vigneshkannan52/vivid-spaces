<?php
/**
 * Title bar default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     FOX-THEMES <info@foxthemes.me>
 */

use Aheto\Helper;

extract( $atts );
$this->generate_css();

$arrows_breadcrumb = isset( $arrows_breadcrumb ) && ! empty( $arrows_breadcrumb ) ? 'all-arrows' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aht-breadcrumbs--only arrows-' . $arrows_alignment );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', $arrows_breadcrumb );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/title-bar/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'title-bar-style-2', $sc_dir . 'assets/css/layout2.css', null, null );
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

							$target = isset( $item_link['target'] ) ? $item_link['target'] : '_self';

							$rel = isset( $item_link['rel'] ) && ! empty( $item_link['rel'] )
								? "rel='" . esc_attr( $item_link['rel'] ) . "'"
								: '';

							if ( isset( $item_link['href'] ) && ! empty( $item_link['href'] ) ) {

								if ( isset( $item['current_item'] ) && ! empty( $item['current_item'] ) ) { ?>
                                    <li class="aht-breadcrumbs__item current">
										<?php echo esc_html( $item['link_title'] ); ?>
                                    </li>
								<?php } else { ?>
                                    <li class="aht-breadcrumbs__item">
                                        <a href="<?php echo esc_url( $item_link['href'] ); ?>"
                                           class="aht-breadcrumbs__link"
                                           target="<?php echo esc_attr( $target ) ?>"
											<?php echo $rel; ?>><?php echo esc_html( $item['link_title'] ); ?></a>
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
	<link href="<?php echo $sc_dir . 'assets/css/layout2.css'?>" rel="stylesheet">
	<?php
endif;