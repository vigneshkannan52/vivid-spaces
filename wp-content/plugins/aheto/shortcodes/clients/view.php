<?php
/**
 * The Clients Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     FOX-THEMES <info@foxthemes.me>
 */

use Aheto\Helper;

extract($atts);

$clients = $this->parse_group($clients);
if ( empty($clients) ) {
	return '';
}

$this->generate_css();

$item_per_row = isset($item_per_row) && !empty($item_per_row) ? $item_per_row : 2;

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-clients');
$this->add_render_attribute('wrapper', 'class', 'aheto-clients--classic');
$this->add_render_attribute('wrapper', 'class', 'aheto-clients--' . $item_per_row . '-in-row');
$this->add_render_attribute('wrapper', 'class', $hover_style);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


$sc_dir     = aheto()->plugin_url() . 'shortcodes/clients/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && !empty( $custom_css ) ) ? $custom_css : false;

//if ( 'visual-composer' === Helper::get_settings( 'general.builder' ) ) {
if (  empty( $custom_css )  || (  $custom_css == "disabled"  )  )  {
	wp_enqueue_style( 'clients-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}
//}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php foreach ( $clients as $item ) :
		if ( isset($item['image']) && !empty($item['image']) ) :
			$button = $this->get_link_attributes($item['link_url']); ?>

			<div class="aheto-clients__holder">

				<?php if ( isset($button['href']) && !empty($button['href']) ) :

					$target = isset($button['target']) ? $button['target'] : '_self';
					$rel = isset( $button['rel'] ) && !empty($button['rel']) ? "rel='" . esc_attr( $button['rel'] )  . "'" : ''; ?>

					<a href="<?php echo esc_url($button['href']); ?>" target="<?php echo esc_attr($target); ?>" <?php echo $rel; ?>>
						<?php echo Helper::get_attachment($item['image'], [], $image_size, $atts); ?>
					</a>
				<?php else :
					echo Helper::get_attachment($item['image'], [], $image_size, $atts);
				endif; ?>

			</div>

		<?php endif; ?>

	<?php endforeach; ?>

</div>
