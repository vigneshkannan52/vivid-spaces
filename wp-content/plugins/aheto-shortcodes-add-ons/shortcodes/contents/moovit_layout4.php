<?php
/**
 * The Contents Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$moovit_custom_link_items = $this->parse_group( $moovit_custom_link_items );

if ( empty( $moovit_custom_link_items ) ) {
	return '';
}
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--moovit-cl_w_img' );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/contents/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'moovit-contents-layout4', $shortcode_dir . 'assets/css/moovit_layout4.css', null, null );
} ?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	foreach ( $moovit_custom_link_items as $item ) :

		$item_link = $this->get_link_attributes( $item['moovit_link_item_url'] );

		if ( empty( $item['moovit_link_item_image'] ) && empty( $item['moovit_item_title'] ) && empty( $item_link['href'] ) ) {
			continue;
		}
		?>
        <div class="aheto-contents__item">
			<?php

			if ( ! empty( $item['moovit_link_item_image'] ) ) :
				echo Aheto\Helper::get_attachment( $item['moovit_link_item_image'], [ 'class' => 'icon-image' ], $moovit_image_size, $atts, 'moovit_' );
			endif;

			if ( ! empty( $item['moovit_item_title'] ) && ! empty( $item_link['href'] ) ) : ?>
                <a href="<?php echo esc_url( $item_link['href'] ); ?>"><?php echo esc_html( $item['moovit_item_title'] ); ?></a>
			<?php endif; ?>

        </div>

	<?php endforeach; ?>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/moovit_layout4.css'?>" rel="stylesheet">
	<?php
endif;