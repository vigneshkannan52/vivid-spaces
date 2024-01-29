<?php
/**
 * The Clients Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$clients = $this->parse_group( $clients );
if ( empty( $clients ) ) {
	return '';
}

$this->generate_css();

$item_per_row = isset( $item_per_row ) && ! empty( $item_per_row ) ? $item_per_row : 2;

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-clients--classic' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-clients--' . $item_per_row . '-in-row' );
$this->add_render_attribute( 'wrapper', 'class', $hover_style );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/clients/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
	wp_enqueue_style( 'outsourceo-clients-layout1', $shortcode_dir . 'assets/css/outsourceo_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-clients__aside-text">
		<?php if ( isset( $outsourceo_aside_text ) && ! empty( $outsourceo_aside_text ) ) : ?>
            <p><?php echo esc_html( $outsourceo_aside_text ); ?></p>
		<?php endif; ?>
    </div>

    <div class="aheto-clients__wrapper">
		<?php foreach ( $clients as $item ) :
			if ( ! empty( $item['image'] ) ) :
				$button = $this->get_link_attributes( $item['link_url'] ); ?>

                <div class="aheto-clients__holder">

					<?php
					if ( isset( $button['href'] ) && ! empty( $button['href'] ) ) :
						$target = isset($button['target']) ? $button['target'] : '_self';
						$rel = isset( $button['rel'] ) && !empty($button['rel']) ? "rel='" . esc_attr( $button['rel'] )  . "'" : ''; ?>

                        <a href="<?php echo esc_url($button['href']); ?>" target="<?php echo esc_attr($target); ?>" <?php echo $rel; ?>>
							<?php echo Helper::get_attachment( $item['image'] ); ?>
                        </a>
					<?php else :
						echo Helper::get_attachment( $item['image'] );
					endif; ?>

                </div>

			<?php endif; ?>

		<?php endforeach; ?>
    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/outsourceo_layout1.css'?>" rel="stylesheet">  
	<?php
endif;