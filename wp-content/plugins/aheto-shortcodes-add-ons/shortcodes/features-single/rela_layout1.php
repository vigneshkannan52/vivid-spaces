<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

extract($atts);
use Aheto\Helper;
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--rela-classic');

// Button.
$button = $this->get_button_attributes('link');

/**
 * Set dependent style
 */
$shortcode_dir = plugins_url('', \AAddons\PLUGIN_ROOT_FILE) . '/shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style('rela-features-single-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div <?php $this->render_attribute_string('block_wrapper'); ?>>
        <div class="aheto-features-block__shape"></div>
        <div class="aheto-features-block__wrap">

            <?php if ($s_image) : ?>
                <div class="aheto-features-block__image-wrap">
                    <div class="aheto-features-block__image">
                        <?php echo \Aheto\Helper::get_attachment($s_image, [], $image_size, $atts); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($s_heading)) : ?>
                <?php $highlight_heading = $this->highlight_text($s_heading) ?>
                <h4 class="aheto-features-block__title"><?php echo wp_kses($highlight_heading, 'post'); ?></h4>
            <?php endif; ?>

            <?php if (!empty($s_description)) : ?>
                <div class="aheto-features-block__info">
                    <p class="aheto-features-block__description ">
                        <?php echo wp_kses($s_description, 'post'); ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>
<?php
if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) :  
	?>
	<link href="<?php echo $shortcode_dir . 'assets/css/rela_layout1.css'?>" rel="stylesheet">
	<?php
endif;