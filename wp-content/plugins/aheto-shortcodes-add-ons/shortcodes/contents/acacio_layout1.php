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

extract($atts);
$faqs = $this->parse_group($faqs);

if ( empty($faqs) ) {
	return '';
}
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contents--acacio-faq');
$this->add_render_attribute('wrapper', 'class', 'js-accordion-parent');

if (isset($multi_active) && !empty($multi_active)) {
	$this->add_render_attribute('wrapper', 'data-multiple', '1');
}

$icon = $this->get_icon_attributes('acacio_contents1', true, true);
if ( !empty($icon) ) {
	$this->add_render_attribute('icon', 'class', 'icon');
	$this->add_render_attribute('icon', 'class', $icon['icon']);
	if ( !empty($icon['color']) ) {
		$this->add_render_attribute('icon', 'style', 'color:' . $icon['color']);
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url( '', \AAddons\PLUGIN_ROOT_FILE ) . '/shortcodes/contents/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style( 'acacio-contents-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null );
}


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php
	foreach ( $faqs as $key => $item ) :

		$class_active = $key === 0 && $first_is_opened ? 'is-open' : '';
		$active_display = $key === 0 && $first_is_opened ? 'block' : 'none';

		if ( empty($item['title']) && empty($item['description']) ) {
			continue;
		}
		?>
		<div class="aheto-contents__item <?php echo esc_attr($class_active); ?>">
            <div class="aheto-contents__heading js-accordion">
                <?php if (isset($item['title']) && !empty($item['title'])  ) : ?>
                    <h5 class="aheto-contents__title js-accordion"><?php echo wp_kses_post($item['title']); ?></h5>

                <?php endif; ?>
                <?php
                    // Icon.
                    if ( !empty($icon) ) { ?>
                        <i <?php echo wp_kses_post($this->get_render_attribute_string('icon')); ?>></i>
                    <?php } ?>
            </div>


			<?php if (isset($item['description']) && !empty($item['description'])  ) : ?>
				<div class="aheto-contents__panel js-accordion-text"  style="display: <?php echo esc_attr($active_display); ?>">
					<p class="aheto-contents__desc">
						<?php echo wp_kses_post($item['description']); ?>
					</p>
				</div>
			<?php endif; ?>

		</div>

	<?php endforeach; ?>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/acacio_layout1.css'?>" rel="stylesheet">
	<?php
endif;