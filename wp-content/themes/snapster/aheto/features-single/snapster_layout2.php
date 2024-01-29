<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--snapster-minimal');

// Button.
$button = $this->get_button_attributes('link');

/**
 * Set dependent style
 */
$sc_dir = SNAPSTER_T_URI . '/aheto/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if (empty($custom_css) || ($custom_css == "disabled")) {
    wp_enqueue_style('snapster-features-single-layout2', $sc_dir . 'assets/css/snapster_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-features-block__wrap">

			<?php if ( !empty($s_image) ) : ?>
            <div class="aheto-features-block__image-wrap">
				<div class="aheto-features-block__image">
					<?php echo \Aheto\Helper::get_attachment( $s_image, [], $snapster_image_size, $atts, 'snapster_' ); ?>
				</div>
            </div>
			<?php endif; ?>

            <div class="aheto-features-block__info">
                <?php if ( !empty( $snapster_heading )) : ?>
                    <h5 class="aheto-content-block__title"><?php echo esc_html($snapster_heading); ?></h5>
                <?php endif; ?>

                <?php if ( !empty( $s_description )) : ?>
                    <p class="aheto-content-block__info-text aheto-features-block__description">
                        <?php echo esc_html($s_description); ?>
                    </p>
                <?php endif; ?>
            </div>

		</div>

	</div>

</div>
